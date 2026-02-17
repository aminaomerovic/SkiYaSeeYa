@extends('layouts.app')

@section('title', 'Dodaj obaveštenje')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body p-4">
                <h3 class="mb-4">Dodaj novo obaveštenje</h3>

                <form method="POST" action="{{ route('admin.store-announcement') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Naslov *</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-4">
                        <label for="content" class="form-label">Sadržaj *</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Dodaj obaveštenje</button>
                        <a href="{{ route('admin.announcements') }}" class="btn btn-secondary">Otkaži</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
