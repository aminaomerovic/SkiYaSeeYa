@extends('layouts.app')

@section('title', 'Dodaj novu opremu')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body p-4">
                <h3 class="mb-4">Dodaj novu opremu</h3>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('provider.store-equipment') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Naziv opreme *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Opis *</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label">Tip *</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Izaberite tip</option>
                                <option value="skis">Skije</option>
                                <option value="boots">Čizme</option>
                                <option value="jacket">Jakna</option>
                                <option value="helmet">Kaciga</option>
                                <option value="poles">Štapovi</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Pol *</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="">Izaberite pol</option>
                                <option value="male">Muško</option>
                                <option value="female">Žensko</option>
                                <option value="unisex">Unisex</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="price_per_day" class="form-label">Cena po danu ($) *</label>
                        <input type="number" class="form-control" id="price_per_day" name="price_per_day" 
                               step="0.01" min="0" required>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label">Slika</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <small class="text-muted">Opciono - JPG, PNG (max 2MB)</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Dodaj opremu</button>
                        <a href="{{ route('provider.dashboard') }}" class="btn btn-secondary">Otkaži</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection