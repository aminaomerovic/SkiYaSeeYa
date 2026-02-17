@extends('layouts.app')

@section('title', 'Recenzije')

@section('content')
<h2 class="mb-4">Recenzije</h2>

@if($reviews->count() > 0)
    <div class="row">
        @foreach($reviews as $review)
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">{{ $review->equipment->name }}</h5>
                        <div>
                            @for($i = 1; $i <= 5; $i++)
                                <span class="text-{{ $i <= $review->rating ? 'warning' : 'muted' }}">★</span>
                            @endfor
                        </div>
                    </div>
                    
                    @if($review->comment)
                        <p class="card-text text-muted">{{ $review->comment }}</p>
                    @endif
                    
                    <div class="text-muted small">
                        <strong>Korisnik:</strong> {{ $review->customer->name }} • 
                        {{ \Carbon\Carbon::parse($review->created_at)->format('d.m.Y') }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="alert alert-info">Još uvek nemate recenzija.</div>
@endif
@endsection