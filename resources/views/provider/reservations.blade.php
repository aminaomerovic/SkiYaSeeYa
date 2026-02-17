@extends('layouts.app')

@section('title', 'Rezervacije')

@section('content')
<h2 class="mb-4">Rezervacije</h2>

@if($reservations->count() > 0)
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Oprema</th>
                            <th>Korisnik</th>
                            <th>Datum početka</th>
                            <th>Datum kraja</th>
                            <th>Ukupna cena</th>
                            <th>Status</th>
                            <th>Akcija</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->equipment->name }}</td>
                            <td>{{ $reservation->customer->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($reservation->start_date)->format('d.m.Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($reservation->end_date)->format('d.m.Y') }}</td>
                            <td class="fw-bold">${{ $reservation->total_price }}</td>
                            <td>
                                @if($reservation->status == 'confirmed')
                                    <span class="badge bg-success">Potvrđeno</span>
                                @else
                                    <span class="badge bg-secondary">Završeno</span>
                                @endif
                            </td>
                            <td>
                                @if($reservation->status == 'confirmed')
                                    <form action="{{ route('provider.complete-reservation', $reservation->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            Označi kao završeno
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small">Završeno</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="alert alert-info">Trenutno nemate rezervacija.</div>
@endif
@endsection