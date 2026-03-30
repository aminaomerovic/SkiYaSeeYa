@extends('layouts.app')

@section('title', $equipment->name)

@section('content')
<div class="row">
    <div class="col-md-6 mb-4">
        @if($equipment->image)
            <img src="{{ asset('storage/' . $equipment->image) }}"
                 class="img-fluid rounded shadow" alt="{{ $equipment->name }}">
        @else
            <div class="bg-secondary d-flex align-items-center justify-content-center rounded" style="height: 400px;">
                <span class="text-white fw-bold">Nema slike</span>
            </div>
        @endif
    </div>

    <div class="col-md-6">
        <h2>{{ $equipment->name }}</h2>
        <h4 class="text-primary mb-3">{{ $equipment->price_per_day }} din/dan</h4>

        <p class="mb-1"><strong>Tip:</strong>
            @if($equipment->type == 'skis') Skije
            @elseif($equipment->type == 'boots') Čizme
            @elseif($equipment->type == 'jacket') Jakna
            @elseif($equipment->type == 'helmet') Kaciga
            @elseif($equipment->type == 'poles') Štapovi
            @else {{ $equipment->type }}
            @endif
        </p>
        <p class="mb-1"><strong>Pol:</strong>
            @if($equipment->gender == 'male') Muško
            @elseif($equipment->gender == 'female') Žensko
            @else Unisex
            @endif
        </p>
        <p class="mb-3"><strong>Pružalac:</strong> {{ $equipment->provider->name }}</p>

        @if($equipment->averageRating())
            <p class="mb-3">
                <strong>Ocena:</strong>
                @for($i = 1; $i <= 5; $i++)
                    <span class="text-{{ $i <= round($equipment->averageRating()) ? 'warning' : 'muted' }}" style="font-size: 1.5rem;">★</span>
                @endfor
                <span class="ms-2">{{ number_format($equipment->averageRating(), 1) }} ({{ $equipment->reviews->count() }} recenzija)</span>
            </p>
        @endif

        <h5 class="mt-4">Opis</h5>
        <p>{{ $equipment->description }}</p>

        @auth
            <a href="{{ route('customer.reserve-equipment', $equipment->id) }}" class="btn btn-success btn-lg mt-3">
                Rezerviši opremu
            </a>
        @else
            <a href="{{ route('login') }}" class="btn btn-success btn-lg mt-3">
                Prijavite se da rezervišete
            </a>
        @endauth
    </div>
</div>

@if($equipment->reviews->count() > 0)
    <hr class="my-5">
    <h4 class="mb-4">Recenzije korisnika</h4>

    <div class="row">
        @foreach($equipment->reviews as $review)
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <strong>{{ $review->customer->name }}</strong>
                        <div>
                            @for($i = 1; $i <= 5; $i++)
                                <span class="text-{{ $i <= $review->rating ? 'warning' : 'muted' }}">★</span>
                            @endfor
                        </div>
                    </div>

                    @if($review->comment)
                        <p class="mb-2">{{ $review->comment }}</p>
                    @endif

                    <small class="text-muted">{{ \Carbon\Carbon::parse($review->created_at)->format('d.m.Y') }}</small>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection