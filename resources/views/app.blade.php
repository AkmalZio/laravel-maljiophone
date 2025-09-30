<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Warung PKL')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #f0f4f8, #d9e4f5);
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar {
            background-color: #1e293b !important;
        }

        h2 {
            color: #1e293b; 
        }

        .container {
            color: #101820;
            flex: 1; /* biar konten dorong footer ke bawah */
        }

        .card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .btn-primary {
            background-color: #2563eb;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
        }

        a {
            color: #2563eb;
            text-decoration: none;
        }

        a:hover {
            color: #f59e0b;
        }

        /* Badge keranjang */
        .cart-badge {
            font-size: 0.75rem;
            background: #ffffffff;
            color: #1e293b;
            border-radius: 50%;
            padding: 2px 7px;
            position: absolute;
            top: 5px;
            right: -10px;
        }

        /* Footer styling */
        footer.footer {
            background-color: #1e293b;
            color: #f1f5f9;
        }

        footer h5, footer h6 {
            color: #ffffffff;
        }

        footer a {
            color: #f1f5f9;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: #facc15;
        }

        footer hr {
            opacity: 0.2;
        }

        footer.footer p,
        footer.footer small {
            color: #f1f5f9 !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">
                <i class="bi bi-shop me-1"></i> MaljioPhone
            </a>

            <!-- Toggler for mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('produk.index') ? 'active' : '' }}" 
                               href="{{ route('produk.index') }}">
                               <i class="bi bi-box-seam"></i> Daftar Produk
                            </a>
                        </li>
                        {{-- Jika role USER --}}
                        @if (auth()->user()->role === 'user')
                            @php
                                $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                            @endphp
                            <li class="nav-item position-relative me-3">
                                <a class="nav-link {{ request()->routeIs('cart.index') ? 'active' : '' }}" 
                                href="{{ route('cart.index') }}">
                                <i class="bi bi-cart"></i> Keranjang
                                @if ($cartCount > 0)
                                    <span class="cart-badge">{{ $cartCount }}</span>
                                @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('purchase.purchases') ? 'active' : '' }}" 
                                href="{{ route('purchase.purchases') }}">
                                <i class="bi bi-bag-check"></i> Riwayat Pembelian
                                </a>
                            </li>
                        @endif

                        {{-- Jika role ADMIN --}}
                        @if (auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('purchase.index') ? 'active' : '' }}" 
                                href="{{ route('purchase.index') }}">
                                <i class="bi bi-clipboard-check"></i> Riwayat Pembelian
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-link nav-link" type="submit">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" 
                               href="{{ route('register') }}">
                               <i class="bi bi-person-plus"></i> Register
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" 
                               href="{{ route('login') }}">
                               <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <!-- Footer Global -->
    <footer class="footer mt-auto">
        <div class="container py-4">
            <div class="row text-center text-md-start">
                <!-- Brand / Toko -->
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold"><i class="bi bi-shop me-2"></i>MaljioPhone</h5>
                    <p class="small mb-0">Tempat terpercaya untuk kebutuhan smartphone dan aksesoris.</p>
                </div>

                <!-- Kontak -->
                <div class="col-md-4 mb-3">
                    <h6 class="fw-bold">Kontak Kami</h6>
                    <p class="mb-1"><i class="bi bi-geo-alt-fill me-2"></i>Jl. Golf, Ciriung, Cibinong, Bogor</p>
                    <p class="mb-1"><i class="bi bi-telephone-fill me-2"></i>(+62) 123-4567-890</p>
                    <p class="mb-0"><i class="bi bi-envelope-fill me-2"></i>maljiophone@gmail.com</p>
                </div>

                <!-- Sosial Media -->
                <div class="col-md-4 mb-3">
                    <h6 class="fw-bold">Ikuti Kami</h6>
                    <a href="#" class="text-white me-3"><i class="bi bi-facebook fs-5"></i></a>
                    <a href="#" class="text-white me-3"><i class="bi bi-instagram fs-5"></i></a>
                    <a href="#" class="text-white me-3"><i class="bi bi-whatsapp fs-5"></i></a>
                    <a href="#" class="text-white"><i class="bi bi-twitter-x fs-5"></i></a>
                </div>
            </div>

            <hr class="border-light">

            <div class="text-center">
                <small>&copy; {{ date('Y') }} MaljioPhone | All Rights Reserved</small><br>
                <small></small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
