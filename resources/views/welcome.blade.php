@extends('layouts.app')

@section('title', 'SkiYa-SeeYa - Iznajmljivanje ski opreme')

@section('content')
<div class="text-center py-5" style="background: linear-gradient(135deg, #0c2340 0%, #1e3a8a 100%); border-radius: 16px; color: white; margin-bottom: 2rem;">
    <div class="py-4">
        <h1 class="display-4 fw-bold mb-3">⛷️ SkiYa-SeeYa</h1>
        <p class="lead mb-4" style="font-size: 1.3rem; opacity: 0.9;">
            Pronađi savršenu ski opremu za tvoju avanturu na snegu
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            @auth
                <a href="{{ route('customer.browse') }}" class="btn btn-light btn-lg px-4">
                    Pretraži opremu
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4">
                    Registruj se
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">
                    Prijavi se
                </a>
            @endauth
        </div>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card h-100 text-center p-4 shadow-sm">
            <h5 class="fw-bold">Širok izbor opreme</h5>
            <p class="text-muted">Skije, čizme, jakne, kacige i štapovi — sve na jednom mestu.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 text-center p-4 shadow-sm">
            <h5 class="fw-bold">Laka rezervacija</h5>
            <p class="text-muted">Rezerviši opremu za željeni period u samo nekoliko klikova.</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100 text-center p-4 shadow-sm">
            <h5 class="fw-bold">Ocene i recenzije</h5>
            <p class="text-muted">Čitaj iskustva drugih korisnika i biraj pouzdane pružaoce usluga.</p>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Najpopularnija oprema ovog meseca</h4>
    <a href="{{ route('customer.popular') }}" class="btn btn-outline-primary btn-sm">Vidi sve</a>
</div>

@if(isset($popularEquipment) && $popularEquipment->count() > 0)
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3 mb-5">
    @foreach($popularEquipment as $item)
    <div class="col">
        <div class="card h-100 shadow-sm">
            @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}"
                     class="card-img-top" alt="{{ $item->name }}"
                     style="height: 160px; object-fit: cover;">
            @else
                <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 160px;">
                    <span class="text-white fw-bold">Nema slike</span>
                </div>
            @endif
            <div class="card-body p-3 d-flex flex-column">
                <h6 class="card-title mb-1">{{ $item->name }}</h6>
                <p class="text-primary fw-bold mb-2">{{ $item->price_per_day }} din/dan</p>
                <span class="badge bg-warning text-dark mb-2" style="width: fit-content;">
                    {{ $item->reservations_count }} rezervacija
                </span>
                <div class="mt-auto">
                    <a href="{{ route('customer.equipment-detail', $item->id) }}"
                       class="btn btn-sm btn-outline-primary w-100">Detalji</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="alert alert-info mb-5">Još nema popularnih rezervacija.</div>
@endif

<div class="card shadow-sm text-center p-5" style="background: linear-gradient(135deg, #f8fafc, #e2e8f0);">
    <h4 class="fw-bold mb-2">Postani pružalac usluga</h4>
    <p class="text-muted mb-3">Iznajmljuj svoju ski opremu i zaraduj novac tokom sezone.</p>
    @guest
        <a href="{{ route('register') }}" class="btn btn-primary px-4">Registruj se kao pružalac</a>
    @endguest
</div>
@endsection