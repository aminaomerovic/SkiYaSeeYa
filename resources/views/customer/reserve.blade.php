@extends('layouts.app')

@section('title', 'Rezervacija')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body p-4">
                <h3 class="mb-4">Rezervacija opreme</h3>

                <div class="row mb-4">
                    <div class="col-md-4">
                        @if($equipment->image)
                            <img src="{{ asset('storage/' . $equipment->image) }}" 
                                 class="img-fluid rounded" alt="{{ $equipment->name }}">
                        @else
                            <div class="bg-secondary d-flex align-items-center justify-content-center rounded" style="height: 150px;">
                                <span class="text-white fs-1">⛷️</span>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h5>{{ $equipment->name }}</h5>
                        <p class="text-muted">{{ $equipment->description }}</p>
                        <p class="mb-0"><strong>Cena:</strong> <span class="text-primary fs-5">${{ $equipment->price_per_day }}/dan</span></p>
                    </div>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('customer.store-reservation', $equipment->id) }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Datum početka *</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   min="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">Datum kraja *</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   min="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <strong>Napomena:</strong> Ukupna cena će biti izračunata na osnovu broja dana.
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">Potvrdi rezervaciju</button>
                        <a href="{{ route('customer.equipment-detail', $equipment->id) }}" class="btn btn-secondary">Otkaži</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection