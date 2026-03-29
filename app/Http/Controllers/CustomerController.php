<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function welcome()
    {
        $oneMonthAgo = Carbon::now()->subMonth();
        $popularEquipment = Equipment::where('available', true)
            ->withCount(['reservations' => function($query) use ($oneMonthAgo) {
                $query->where('created_at', '>=', $oneMonthAgo);
            }])
            ->having('reservations_count', '>=', 2)
            ->orderBy('reservations_count', 'desc')
            ->take(4)
            ->get();

        return view('welcome', compact('popularEquipment'));
    }

    public function dashboard()
    {
        $reservations = Reservation::where('customer_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.dashboard', compact('reservations'));
    }

    public function browseEquipment(Request $request)
    {
        $query = Equipment::where('available', true);

        if ($request->filled('type')) {
            $query->whereRaw('LOWER(type) = ?', [strtolower($request->type)]);
        }

        if ($request->filled('gender')) {
            $query->whereRaw('LOWER(gender) = ?', [strtolower($request->gender)]);
        }

        $equipment = $query->orderBy('created_at', 'desc')->paginate(12);

        $announcements = Announcement::where('active', true)
                                     ->orderBy('created_at', 'desc')
                                     ->take(3)
                                     ->get();

        return view('customer.browse', compact('equipment', 'announcements'));
    }

    public function popularEquipment()
    {
        $oneMonthAgo = Carbon::now()->subMonth();

        $equipment = Equipment::where('available', true)
            ->withCount(['reservations' => function($query) use ($oneMonthAgo) {
                $query->where('created_at', '>=', $oneMonthAgo);
            }])
            ->having('reservations_count', '>=', 2)
            ->orderBy('reservations_count', 'desc')
            ->take(10)
            ->get();

        return view('customer.popular', compact('equipment'));
    }

    public function showEquipment($id)
    {
        $equipment = Equipment::with(['reviews.customer'])
            ->findOrFail($id);

        return view('customer.equipment-detail', compact('equipment'));
    }

    public function reserveEquipment($id)
    {
        $equipment = Equipment::findOrFail($id);
        return view('customer.reserve', compact('equipment'));
    }

    public function storeReservation(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after:start_date',
        ]);

        $equipment = Equipment::findOrFail($id);

        $startDate = Carbon::parse($request->start_date);
        $endDate   = Carbon::parse($request->end_date);

        $overlap = Reservation::where('equipment_id', $equipment->id)
            ->where('status', 'confirmed')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhere(function ($q) use ($startDate, $endDate) {
                          $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                      });
            })
            ->exists();

        if ($overlap) {
            return back()->withErrors([
                'msg' => 'Ovaj artikal je već rezervisan u izabranom periodu.'
            ]);
        }

        $days = $startDate->diffInDays($endDate) + 1;
        $totalPrice = $equipment->price_per_day * $days;

        Reservation::create([
            'customer_id'  => Auth::id(),
            'equipment_id' => $equipment->id,
            'start_date'   => $request->start_date,
            'end_date'     => $request->end_date,
            'total_price'  => $totalPrice,
            'status'       => 'confirmed',
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Rezervacija uspešno kreirana.');
    }

    public function showReviewForm($reservationId)
    {
        $reservation = Reservation::where('customer_id', Auth::id())
            ->where('status', 'completed')
            ->whereDoesntHave('review')
            ->findOrFail($reservationId);

        if (Carbon::now()->lt(Carbon::parse($reservation->end_date))) {
            abort(403, 'Ne možete još ostaviti recenziju. Rezervacija nije završena.');
        }

        return view('customer.review', compact('reservation'));
    }

    public function storeReview(Request $request, $reservationId)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $reservation = Reservation::where('customer_id', Auth::id())
            ->where('status', 'completed')
            ->whereDoesntHave('review')
            ->findOrFail($reservationId);

        if (Carbon::now()->lt(Carbon::parse($reservation->end_date))) {
            abort(403, 'Ne možete još ostaviti recenziju. Rezervacija nije završena.');
        }

        Review::create([
            'customer_id'    => Auth::id(),
            'equipment_id'   => $reservation->equipment_id,
            'reservation_id' => $reservation->id,
            'rating'         => $request->rating,
            'comment'        => $request->comment,
        ]);

        return redirect()->route('customer.dashboard')
            ->with('success', 'Recenzija uspešno dodata.');
    }
}