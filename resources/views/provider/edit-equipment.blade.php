@extends('layouts.app')

@section('title', 'Izmeni opremu')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body p-4">
                <h3 class="mb-4">Izmeni opremu</h3>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('provider.update-equipment', $equipment->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Naziv opreme *</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="{{ $equipment->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Opis *</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ $equipment->description }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Tip *</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Izaberite tip</option>
                                <option value="skis" {{ $equipment->type == 'skis' ? 'selected' : '' }}>Skije</option>
                                <option value="boots" {{ $equipment->type == 'boots' ? 'selected' : '' }}>Čizme</option>
                                <option value="jacket" {{ $equipment->type == 'jacket' ? 'selected' : '' }}>Jakna</option>
                                <option value="helmet" {{ $equipment->type == 'helmet' ? 'selected' : '' }}>Kaciga</option>
                                <option value="poles" {{ $equipment->type == 'poles' ? 'selected' : '' }}>Štapovi</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Pol *</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Izaberite pol</option>
                                <option value="male" {{ $equipment->gender == 'male' ? 'selected' : '' }}>Muško</option>
                                <option value="female" {{ $equipment->gender == 'female' ? 'selected' : '' }}>Žensko</option>
                                <option value="unisex" {{ $equipment->gender == 'unisex' ? 'selected' : '' }}>Unisex</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="price_per_day" class="form-label">Cena po danu ($) *</label>
                        <input type="number" class="form-control" id="price_per_day" name="price_per_day" 
                               step="0.01" min="0" value="{{ $equipment->price_per_day }}" required>
                    </div>

                    @if($equipment->image)
                        <div class="mb-3">
                            <label class="form-label">Trenutna slika</label>
                            <div>
                                <img src="{{ asset('storage/' . $equipment->image) }}" 
                                     alt="{{ $equipment->name }}" 
                                     class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        </div>
                    @endif

                    <div class="mb-4">
                        <label for="image" class="form-label">Nova slika (opciono)</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <small class="text-muted">Ostavite prazno ako ne želite da menjate sliku</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
                        <a href="{{ route('provider.dashboard') }}" class="btn btn-secondary">Otkaži</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection