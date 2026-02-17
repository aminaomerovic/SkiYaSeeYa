@extends('layouts.app')

@section('title', 'Promena lozinke')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-body p-4">
                <h3 class="text-center mb-4">Promena lozinke</h3>
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('update-password') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Trenutna lozinka *</label>
                        <input type="password" class="form-control" id="current_password" 
                               name="current_password" required>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">Nova lozinka *</label>
                        <input type="password" class="form-control" id="new_password" 
                               name="new_password" minlength="8" required>
                        <small class="text-muted">Minimum 8 karaktera</small>
                    </div>

                    <div class="mb-4">
                        <label for="new_password_confirmation" class="form-label">Potvrdite novu lozinku *</label>
                        <input type="password" class="form-control" id="new_password_confirmation" 
                               name="new_password_confirmation" minlength="8" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Promeni lozinku</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
