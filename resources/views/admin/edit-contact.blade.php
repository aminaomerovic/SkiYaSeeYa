@extends('layouts.app')

@section('title', 'Uredi kontakt stranicu')

@section('content')
<h2 class="mb-4">Uredi kontakt stranicu</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.update-contact') }}">
            @csrf
            <div class="mb-3">
                <label for="content" class="form-label">Sadržaj kontakt stranice (HTML)</label>
                <textarea class="form-control font-monospace" id="content" name="content"
                          rows="20" style="font-size: 0.85rem;">{{ $content }}</textarea>
                @error('content')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Otkaži</a>
            </div>
        </form>
    </div>
</div>
@endsection