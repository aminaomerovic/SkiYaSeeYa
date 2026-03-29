<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SkiYa-SeeYa - Iznajmljivanje Ski Opreme')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    :root {
    --primary-color: #1d4ed8;
    --secondary-color: #1e3a8a;
    --light-bg: #f8fafc;
    --navbar-bg: #0c2340;
}
    
    body {
        background-color: var(--light-bg);
    }
    
    .navbar {
        background: linear-gradient(135deg, var(--navbar-bg) 0%, var(--secondary-color) 100%) !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .navbar-brand { 
        font-size: 1.5rem; 
        font-weight: bold;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
    }
    
    .nav-link {
        transition: background-color 0.3s ease;
        border-radius: 5px;
        margin: 0 5px;
    }
    
    .nav-link:hover {
        background-color: rgba(255,255,255,0.1);
    }
    
    .btn-link.nav-link {
        color: rgba(255,255,255,0.9) !important;
    }
    
    .btn-link.nav-link:hover {
        color: white !important;
    }
    
    .card {
        border: none;
        transition: box-shadow 0.2s;
    }
    
    .card:hover {
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }
    
    footer { 
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        color: white; 
        padding: 2rem 0; 
        margin-top: 3rem;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
    }
    
    footer a {
        transition: color 0.3s;
    }
    
    footer a:hover {
        color: var(--primary-color) !important;
    }
    
    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .btn-primary:hover {
        background-color: var(--secondary-color);
        border-color: var(--secondary-color);
        box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
    }
    
    .alert {
        border-radius: 10px;
        border: none;
    }
</style>
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('welcome') }}">⛷️ SkiYa-SeeYa</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        @if(Auth::user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Kontrolna tabla</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.announcements') }}">Obaveštenja</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.edit-contact') }}">Uredi kontakt</a>
                            </li>
                        @elseif(Auth::user()->isProvider())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('provider.dashboard') }}">Moja oprema</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('provider.reservations') }}">Rezervacije</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('provider.reviews') }}">Recenzije</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('customer.browse') }}">Pretraga opreme</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('customer.popular') }}">Popularna oprema</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('customer.dashboard') }}">Moje rezervacije</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('change-password') }}">Promena lozinke</a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Odjava</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Prijava</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registracija</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('customer.browse') }}">Pretraga opreme</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('customer.popular') }}">Popularna oprema</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1 py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="mt-auto">
        <div class="container text-center">
            <p class="mb-1">&copy; 2026 SkiYa-SeeYa - Iznajmljivanje ski opreme</p>
            <p class="mb-0">
                <a href="{{ route('contact') }}" class="text-white text-decoration-none">Kontakt</a>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/validation.js') }}"></script>
</body>
</html>