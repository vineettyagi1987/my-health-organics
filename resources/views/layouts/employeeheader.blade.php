<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Home')</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<header class="sticky-top bg-white border-bottom">
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">

      <!-- Logo -->
      <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-success" href="/">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 24 24">
          <path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/>
          <path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/>
        </svg>
        The Health Organics
      </a>

      <!-- Mobile toggle -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar links -->
      <div class="collapse navbar-collapse" id="mainNavbar">
       

        <!-- Right icons -->
        <div class="d-flex align-items-center gap-3 ms-auto">
          <a href="/cart" class="position-relative text-dark">
            <i class="bi bi-cart3 fs-5"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">{{ getCart()->items()->sum('quantity') }}</span>
          </a>

         @guest
            <a href="{{ route('login') }}" class="text-dark">
                <i class="bi bi-box-arrow-in-right fs-5"></i>
            </a>

            <a href="{{ route('register') }}" class="text-dark">
                <i class="bi bi-person-plus fs-5"></i>
            </a>
        @endguest


@auth
    <div class="dropdown">
        <a class="text-dark dropdown-toggle text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
            {{ auth()->user()->name }} ({{ auth()->user()->role }})
        </a>

        <ul class="dropdown-menu dropdown-menu-end">

        {{-- Orders --}}
        <li>
            <a class="dropdown-item" href="{{ route('orders.index') }}">
                My Orders
            </a>
        </li>

        {{-- Refunds (same orders page filtered) --}}
        <li>
            <a class="dropdown-item" href="{{ route('orders.index') }}?status=refunded">
                My Refunds
            </a>
        </li>

        {{-- Cancelled Orders --}}
        <li>
            <a class="dropdown-item" href="{{ route('orders.index') }}?status=cancelled">
                Cancelled Orders
            </a>
        </li>

        <li><hr class="dropdown-divider"></li>

        {{-- Logout --}}
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item text-danger">
                    Logout
                </button>
            </form>
        </li>

    </ul>
    </div>
@endauth

        </div>
      </div>

    </div>
  </nav>
</header>
