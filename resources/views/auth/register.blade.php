@extends('layouts.app')

@section('title', 'Registracija')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">Registracija</h3>
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Ime i prezime</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email adresa</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Lozinka</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password">
                        <small class="text-muted">Minimum 8 karaktera</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Potvrdite lozinku</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation">
                        <small class="text-muted">Ponovite lozinku</small>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Tip naloga</label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role">
                            <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Korisnik</option>
                            <option value="provider" {{ old('role') == 'provider' ? 'selected' : '' }}>Pružalac usluge</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registruj se</button>
                </form>

                <div class="text-center mt-3">
                    <p class="mb-0">Već imate nalog? <a href="{{ route('login') }}">Prijavite se</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection