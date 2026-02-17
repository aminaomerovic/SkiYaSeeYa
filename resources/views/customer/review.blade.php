@extends('layouts.app')

@section('title', 'Ostavi recenziju')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-body p-4">
                <h3 class="mb-4">Ostavi recenziju</h3>

                <div class="mb-4">
                    <h5>{{ $reservation->equipment->name }}</h5>
                    <p class="text-muted mb-0">
                        Rezervacija: {{ \Carbon\Carbon::parse($reservation->start_date)->format('d.m.Y') }} - 
                        {{ \Carbon\Carbon::parse($reservation->end_date)->format('d.m.Y') }}
                    </p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('customer.store-review', $reservation->id) }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label">Ocena *</label>
                        <div class="d-flex gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rating" 
                                           id="rating{{ $i }}" value="{{ $i }}" required>
                                    <label class="form-check-label" for="rating{{ $i }}">
                                        @for($j = 1; $j <= $i; $j++)
                                            <span class="text-warning">★</span>
                                        @endfor
                                    </label>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="comment" class="form-label">Komentar (opciono)</label>
                        <textarea class="form-control" id="comment" name="comment" rows="4" 
                                  placeholder="Podelite svoje iskustvo sa ovom opremom..."></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Ostavi recenziju</button>
                        <a href="{{ route('customer.dashboard') }}" class="btn btn-secondary">Otkaži</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection