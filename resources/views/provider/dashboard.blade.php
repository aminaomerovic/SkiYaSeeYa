@extends('layouts.app')

@section('title', 'Moja oprema')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Moja oprema</h2>
    <a href="{{ route('provider.create-equipment') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Dodaj novu opremu
    </a>
</div>

@if($equipment->count() > 0)
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($equipment as $item)
        <div class="col">
            <div class="card h-100 shadow-sm">
                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" 
                         class="card-img-top" alt="{{ $item->name }}" 
                         style="height: 200px; object-fit: cover;">
                @else
                    <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                        <span class="text-white fs-1">⛷️</span>
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text text-muted small">{{ Str::limit($item->description, 80) }}</p>
                    <p class="mb-1"><strong>Tip:</strong> 
    @if($item->type == 'skis') Skije
    @elseif($item->type == 'boots') Čizme
    @elseif($item->type == 'jacket') Jakna
    @elseif($item->type == 'helmet') Kaciga
    @elseif($item->type == 'poles') Štapovi
    @else {{ $item->type }}
    @endif
</p>
<p class="mb-1"><strong>Pol:</strong> 
    @if($item->gender == 'male') Muško
    @elseif($item->gender == 'female') Žensko
    @else Unisex
    @endif
</p>
                    <p class="mb-2"><strong>Cena:</strong> <span class="text-primary fw-bold">${{ $item->price_per_day }}/dan</span></p>
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('provider.edit-equipment', $item->id) }}" class="btn btn-sm btn-warning flex-fill">Izmeni</a>
                        <form action="{{ route('provider.delete-equipment', $item->id) }}" method="POST" class="flex-fill">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger w-100" 
                                    onclick="return confirm('Da li ste sigurni da želite da obrišete ovu opremu?')">
                                Obriši
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="alert alert-info">
        <p class="mb-0">Još uvek niste dodali opremu. <a href="{{ route('provider.create-equipment') }}" class="alert-link">Dodajte prvu opremu</a></p>
    </div>
@endif
@endsection