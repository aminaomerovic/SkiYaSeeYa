@extends('layouts.app')

@section('title', 'Kontakt')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h2 class="mb-4">Kontakt informacije</h2>
        
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">SkiYa-SeeYa</h5>
                <p class="card-text">Platforma za iznajmljivanje ski opreme</p>
                
                <hr>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6><i class="bi bi-envelope"></i> Email</h6>
                        <p>info@skiya-seeya.com</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6><i class="bi bi-telephone"></i> Telefon</h6>
                        <p>+381 11 123 4567</p>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <h6><i class="bi bi-geo-alt"></i> Adresa</h6>
                        <p>Kneza Miloša 10<br>11000 Beograd, Srbija</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <h6><i class="bi bi-clock"></i> Radno vreme</h6>
                        <p>Ponedeljak - Petak: 09:00 - 17:00<br>
                        Vikend: 10:00 - 14:00</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-3">O nama</h5>
                <p>SkiYa-SeeYa je vodeća platforma za iznajmljivanje ski opreme u Srbiji. Povezujemo ljubitelje zimskih sportova sa pružaocima kvalitetne opreme.</p>
                <p class="mb-0">Naša misija je da zimski sportovi budu dostupni svima, uz najbolje cene i najkvalitetniju opremu.</p>
            </div>
        </div>
    </div>
</div>
@endsection
