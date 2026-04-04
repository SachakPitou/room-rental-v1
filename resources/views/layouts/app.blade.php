<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>🏠 Room Rental — @yield('title', 'Dashboard')</title>

    {{-- Bootstrap CDN (no Vite needed) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body { background-color: #f0f2f5; }
        .navbar-brand { font-size: 1.3rem; letter-spacing: 0.5px; }
        .card { border: none; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
        .card-header { border-radius: 12px 12px 0 0 !important; background: #fff; border-bottom: 1px solid #eee; font-weight: 600; padding: 1rem 1.25rem; }
        .stat-card { border-radius: 16px; padding: 1.5rem; color: white; }
        .table thead th { background: #1e293b; color: #fff; border: none; }
        .badge { font-size: 0.8rem; padding: 0.4em 0.75em; border-radius: 20px; }
        .nav-link { color: rgba(255,255,255,0.75) !important; }
        .nav-link:hover, .nav-link.active { color: #fff !important; }
        .btn { border-radius: 8px; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 py-3 mb-2">
    <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">🏠 Room Rental</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto gap-1">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}"
                   href="{{ route('dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('rooms.*') ? 'active fw-bold' : '' }}"
                   href="{{ route('rooms.index') }}">
                    <i class="bi bi-house-door"></i> Room
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('tenants.*') ? 'active fw-bold' : '' }}"
                   href="{{ route('tenants.index') }}">
                    <i class="bi bi-people"></i> Tenants
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('invoices.*') ? 'active fw-bold' : '' }}"
                   href="{{ route('invoices.index') }}">
                    <i class="bi bi-receipt"></i> Invoices
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="container py-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-3">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>