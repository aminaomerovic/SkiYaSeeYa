@extends('layouts.app')

@section('title', 'Prijava')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">Prijava</h3>
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email adresa</label>
                        <input type="email" class="form-control" id="email" name="email" required 
       oninvalid="this.setCustomValidity('Unesite ispravnu email adresu')"
       oninput="this.setCustomValidity('')">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Lozinka</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Prijavi se</button>
                </form>
                
                <div class="text-center mt-3">
                    <p class="mb-0">Nemate nalog? <a href="{{ route('register') }}">Registrujte se</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection