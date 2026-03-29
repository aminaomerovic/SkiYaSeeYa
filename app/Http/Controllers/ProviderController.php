<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProviderController extends Controller
{
    public function dashboard()
    {
        $equipment = Equipment::where('provider_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        return view('provider.dashboard', compact('equipment'));
    }

    public function createEquipment()
    {
        return view('provider.create-equipment');
    }

    public function storeEquipment(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:skis,boots,jacket,helmet,poles',
            'gender' => 'required|in:male,female,unisex',
            'price_per_day' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('equipment', 'public');
        }

        Equipment::create([
            'provider_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'gender' => $request->gender,
            'price_per_day' => $request->price_per_day,
            'image' => $imagePath,
        ]);

        return redirect()->route('provider.dashboard')->with('success', 'Oprema uspešno dodata.');
    }

    public function editEquipment($id)
    {
        $equipment = Equipment::where('provider_id', Auth::id())->findOrFail($id);
        return view('provider.edit-equipment', compact('equipment'));
    }

    public function updateEquipment(Request $request, $id)
    {
        $equipment = Equipment::where('provider_id', Auth::id())->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:skis,boots,jacket,helmet,poles',
            'gender' => 'required|in:male,female,unisex',
            'price_per_day' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $equipment->image;
        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('equipment', 'public');
        }

        $equipment->update([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'gender' => $request->gender,
            'price_per_day' => $request->price_per_day,
            'image' => $imagePath,
        ]);

        return redirect()->route('provider.dashboard')->with('success', 'Oprema uspešno izmenjena.');
    }

    public function deleteEquipment($id)
    {
        $equipment = Equipment::where('provider_id', Auth::id())->findOrFail($id);

        if ($equipment->image) {
            Storage::disk('public')->delete($equipment->image);
        }

        $equipment->delete();
        return redirect()->route('provider.dashboard')->with('success', 'Oprema uspešno obrisana.');
    }

    public function reservations()
    {
        $reservations = Reservation::whereHas('equipment', function($query) {
            $query->where('provider_id', Auth::id());
        })->orderBy('created_at', 'desc')->get();

        return view('provider.reservations', compact('reservations'));
    }

    public function reviews()
    {
        $reviews = Review::whereHas('equipment', function($query) {
            $query->where('provider_id', Auth::id());
        })->orderBy('created_at', 'desc')->get();

        return view('provider.reviews', compact('reviews'));
    }

    public function completeReservation($id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->equipment->provider_id != Auth::id()) {
            abort(403);
        }

        $reservation->status = 'completed';
        $reservation->save();

        return back()->with('success', 'Rezervacija označena kao završena.');
    }

    public function rejectReservation($id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->equipment->provider_id != Auth::id()) {
            abort(403);
        }

        $reservation->status = 'rejected';
        $reservation->save();

        return back()->with('success', 'Rezervacija odbijena.');
    }
}