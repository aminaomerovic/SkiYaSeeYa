@extends('layouts.app')

@section('title', 'Obaveštenja')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Obaveštenja</h2>
    <a href="{{ route('admin.create-announcement') }}" class="btn btn-success">Dodaj obaveštenje</a>
</div>

@if($announcements->count() > 0)
    <div class="row">
        @foreach($announcements as $announcement)
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $announcement->title }}</h5>
                    <p class="card-text">{{ Str::limit($announcement->content, 150) }}</p>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($announcement->created_at)->format('d.m.Y H:i') }}</small>
                    
                    <form action="{{ route('admin.delete-announcement', $announcement->id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" 
                                onclick="return confirm('Da li ste sigurni?')">Obriši</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="alert alert-info">Nema obaveštenja.</div>
@endif
@endsection
