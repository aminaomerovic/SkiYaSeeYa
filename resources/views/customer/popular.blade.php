@extends('layouts.app')

@section('title', 'Najpopularnija oprema')

@section('content')
<h2 class="mb-4">Najpopularnija oprema u poslednjem mesecu</h2>

@if($equipment->count() > 0)
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3">
        @foreach($equipment as $item)
        <div class="col">
            <div class="card h-100 shadow-sm">
                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}"
                         class="card-img-top" alt="{{ $item->name }}"
                         style="height: 180px; object-fit: cover;">
                @else
                    <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 180px;">
                        <span class="text-white fs-2">⛷️</span>
                    </div>
                @endif
                <div class="card-body p-3 d-flex flex-column">
                    <h6 class="card-title mb-2">{{ $item->name }}</h6>
                    <p class="card-text text-muted small mb-2" style="font-size: 0.85rem;">
                        {{ Str::limit($item->description, 60) }}
                    </p>
                    <div class="mb-2 small">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Tip:</span>
                            <span class="fw-semibold">
                                @if($item->type == 'skis') Skije
                                @elseif($item->type == 'boots') Čizme
                                @elseif($item->type == 'jacket') Jakna
                                @elseif($item->type == 'helmet') Kaciga
                                @elseif($item->type == 'poles') Štapovi
                                @else {{ $item->type }}
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Pol:</span>
                            <span class="fw-semibold">
                                @if($item->gender == 'male') Muško
                                @elseif($item->gender == 'female') Žensko
                                @else Unisex
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Cena:</span>
                            <span class="text-primary fw-bold">${{ $item->price_per_day }}/dan</span>
                        </div>
                    </div>
                    <div class="mb-2">
                        <span class="badge bg-warning text-dark">
                            {{ $item->reservations_count }} {{ $item->reservations_count == 1 ? 'rezervacija' : 'rezervacija' }} ovog meseca
                        </span>
                    </div>
                    @if($item->averageRating())
                        <div class="mb-2 small">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="text-{{ $i <= round($item->averageRating()) ? 'warning' : 'muted' }}">★</span>
                            @endfor
                            <span class="ms-1" style="font-size: 0.8rem;">({{ number_format($item->averageRating(), 1) }})</span>
                        </div>
                    @endif
                    <div class="mt-auto d-grid gap-2">
                        <a href="{{ route('customer.equipment-detail', $item->id) }}"
                           class="btn btn-sm btn-outline-primary">Detalji</a>
                        <a href="{{ route('customer.reserve-equipment', $item->id) }}"
                           class="btn btn-sm btn-success">Rezerviši</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="alert alert-info">Nema popularnih rezervacija u poslednjem mesecu.</div>
@endif

<div class="mt-4">
    <a href="{{ route('customer.browse') }}" class="btn btn-secondary">← Nazad na pretragu</a>
</div>
@endsection