@extends('layouts.app')

@section('title', 'Pretraga opreme')

@section('content')
<h2 class="mb-4">Pretraga opreme</h2>
@if($announcements->count() > 0)
    <div class="alert alert-info">
        <h5 class="alert-heading">Aktuelnosti</h5>
        @foreach($announcements as $announcement)
            <div class="mb-2">
                <strong>{{ $announcement->title }}</strong>
                <p class="mb-0">{{ $announcement->content }}</p>
                <small class="text-muted">{{ \Carbon\Carbon::parse($announcement->created_at)->format('d.m.Y') }}</small>
            </div>
            @if(!$loop->last)<hr>@endif
        @endforeach
    </div>
@endif
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('customer.browse') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="type" class="form-label">Tip opreme</label>
                    <select class="form-select" id="type" name="type">
                        <option value="">Svi tipovi</option>
                        <option value="skis" {{ request('type') == 'skis' ? 'selected' : '' }}>Skije</option>
                        <option value="boots" {{ request('type') == 'boots' ? 'selected' : '' }}>Čizme</option>
                        <option value="jacket" {{ request('type') == 'jacket' ? 'selected' : '' }}>Jakna</option>
                        <option value="helmet" {{ request('type') == 'helmet' ? 'selected' : '' }}>Kaciga</option>
                        <option value="poles" {{ request('type') == 'poles' ? 'selected' : '' }}>Štapovi</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="gender" class="form-label">Pol</label>
                    <select class="form-select" id="gender" name="gender">
                        <option value="">Svi</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Muško</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Žensko</option>
                        <option value="unisex" {{ request('gender') == 'unisex' ? 'selected' : '' }}>Unisex</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Filtriraj</button>
                        <a href="{{ route('customer.browse') }}" class="btn btn-secondary">Poništi</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

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
                        <span class="text-white fw-bold">Nema slike</span>
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
                            <span class="text-primary fw-bold">{{ $item->price_per_day }} din/dan</span>
                        </div>
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

    <div class="d-flex justify-content-center mt-4">
        {{ $equipment->links() }}
    </div>
@else
    <div class="alert alert-info">Nema opreme koja odgovara vašim filterima.</div>
@endif
@endsection