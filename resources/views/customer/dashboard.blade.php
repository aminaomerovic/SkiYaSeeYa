@extends('layouts.app')

@section('title', 'Moje rezervacije')

@section('content')
<h2 class="mb-4">Moje rezervacije</h2>

@if($reservations->count() > 0)
    <div class="row">
        @foreach($reservations as $reservation)
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                @if($reservation->equipment->image)
                    <img src="{{ asset('storage/' . $reservation->equipment->image) }}"
                         class="card-img-top" alt="{{ $reservation->equipment->name }}"
                         style="height: 200px; object-fit: cover;">
                @else
                    <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                        <span class="text-white fw-bold">Nema slike</span>
                    </div>
                @endif

                <div class="card-body">
                    <h5 class="card-title">{{ $reservation->equipment->name }}</h5>

                    <p class="mb-1"><strong>Datum početka:</strong> {{ \Carbon\Carbon::parse($reservation->start_date)->format('d.m.Y') }}</p>
                    <p class="mb-1"><strong>Datum kraja:</strong> {{ \Carbon\Carbon::parse($reservation->end_date)->format('d.m.Y') }}</p>
                    <p class="mb-2"><strong>Ukupna cena:</strong> <span class="text-primary fw-bold">{{ $reservation->total_price }} din</span></p>

                    <p class="mb-3">
                        <strong>Status:</strong>
                        @if($reservation->status == 'confirmed')
                            <span class="badge bg-success">Potvrdjeno</span>
                        @elseif($reservation->status == 'completed')
                            <span class="badge bg-secondary">Zavrseno</span>
                        @elseif($reservation->status == 'rejected')
                            <span class="badge bg-danger">Odbijeno</span>
                        @endif
                    </p>

                    @if($reservation->status == 'completed' && !$reservation->review)
                        <a href="{{ route('customer.review-form', $reservation->id) }}" class="btn btn-primary">
                            Ostavi recenziju
                        </a>
                    @elseif($reservation->review)
                        <span class="text-success">Recenzija ostavljena</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="alert alert-info">
        Nemate aktivnih rezervacija. <a href="{{ route('customer.browse') }}" class="alert-link">Pregledajte opremu</a>
    </div>
@endif
@endsection