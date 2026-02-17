@extends('layouts.app')

@section('title', 'Admin - Kontrolna tabla')

@section('content')
<h2 class="mb-4">Kontrolna tabla administratora</h2>

<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Odobravanje korisnika</h5>
    </div>
    <div class="card-body p-0">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Ime</th>
                            <th>Email</th>
                            <th>Uloga</th>
                            <th>Status</th>
                            <th>Datum registracije</th>
                            <th>Akcije</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role == 'admin')
                                    <span class="badge bg-info">Administrator</span>
                                @elseif($user->role == 'provider')
                                    <span class="badge bg-success">Pružalac usluge</span>
                                @else
                                    <span class="badge bg-primary">Korisnik</span>
                                @endif
                            </td>
                            <td>
                                @if($user->status == 'approved')
                                    <span class="badge bg-success">Odobren</span>
                                @elseif($user->status == 'pending')
                                    <span class="badge bg-warning">Na čekanju</span>
                                @else
                                    <span class="badge bg-danger">Odbijen</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d.m.Y H:i') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    @if($user->status == 'pending')
                                        <form action="{{ route('admin.approve-user', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Odobri</button>
                                        </form>
                                    @endif
                                    
                                    @if($user->id != Auth::id())
                                        <form action="{{ route('admin.delete-user', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Da li ste sigurni da želite da obrišete ovog korisnika?')">
                                                Obriši
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-4">
                <p class="text-muted mb-0">Nema korisnika u sistemu.</p>
            </div>
        @endif
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h3 class="text-primary">{{ $users->where('status', 'pending')->count() }}</h3>
                <p class="text-muted mb-0">Na čekanju</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h3 class="text-success">{{ $users->where('status', 'approved')->count() }}</h3>
                <p class="text-muted mb-0">Odobreno</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h3 class="text-info">{{ $users->count() }}</h3>
                <p class="text-muted mb-0">Ukupno korisnika</p>
            </div>
        </div>
    </div>
</div>
@endsection