<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | ElysianHome | Modern Furniture Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('fe/assets/img/logo.png') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if ($title === 'Home')
        <link rel="stylesheet" href="{{ asset('fe/assets/css/style.css') }}">
    @elseif ($title === 'AllProduct')
        <link rel="stylesheet" href="{{ asset('fe/assets/css/allproduct.css') }}">
    @elseif ($title === 'Cart')
        <link rel="stylesheet" href="{{ asset('fe/assets/css/cart.css') }}">
    @elseif ($title === 'CheckoutFinal')
        <link rel="stylesheet" href="{{ asset('fe/assets/css/checkout-final.css') }}">
    @elseif ($title === 'History')
        <link rel="stylesheet" href="{{ asset('fe/assets/css/history.css') }}">
    @elseif ($title === 'Setting')
        <link rel="stylesheet" href="{{ asset('fe/assets/css/settings.css') }}">
    @endif

    <!-- SweetAlert CSS and JS -->
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home.index') }}">
                <img src="{{ asset('fe/assets/img/Logo.png') }}" alt="ElysianHome" width="120">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('home.index') ? 'active' : '' }}"
                            href="{{ route('home.index') }}">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('home.index') && request()->has('featured') ? 'active' : '' }}"
                            href="{{ route('home.index', ['#featured']) }}">
                            Featured
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('all-product.index') ? 'active' : '' }}"
                            href="{{ route('all-product.index') }}">
                            Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('home.index') && request()->has('testimonials') ? 'active' : '' }}"
                            href="{{ route('home.index', ['#testimonials']) }}">
                            Testimonials
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <a href="#" class="text-dark me-3 position-relative">
                        <i class="fas fa-search fa-lg"></i>
                    </a>
                    <a href="{{ route('keranjang.index') }}" class="text-dark me-3 position-relative">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                        @if ($cartCount > 0)
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                    <div class="dropdown">
                        @auth
                            <a href="#" class="dropdown-toggle" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user fa-lg text-dark"></i>
                            </a>
                            <ul class="dropdown-menu">
                                @if (Auth::user()->role == 'admin')
                                    <li><a class="dropdown-item" href="{{ route('dashboard.index') }}">Dashboard</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('history.index') }}">History Trx</a></li>
                                    <li><a class="dropdown-item" href="{{ route('settings.index') }}">Settings</a></li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        @endauth

                        @guest
                            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </nav>

    @if ($title === 'Home')
        @yield('homepage')
    @elseif ($title === 'AllProduct')
        @yield('allproductpage')
    @elseif ($title === 'Cart')
        @yield('cartpage')
    @elseif ($title === 'CheckoutFinal')
        @yield('checkoutfinalpage')
    @elseif ($title === 'History')
        @yield('historypage')
    @elseif ($title === 'Setting')
        @yield('settingspage')
    @endif

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 fade-in">
                    <img src="{{ asset('fe/assets/img/Logo.png') }}" alt="ElysianHome" width="150" class="mb-3">
                    <p class="text-muted">Bringing modern, high-quality furniture to your home since 2010. We believe in
                        combining style, comfort, and functionality.</p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 fade-in delay-1">
                    <h5 class="mb-4">Shop</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="#">Living Room</a></li>
                        <li class="mb-2"><a href="#">Bedroom</a></li>
                        <li class="mb-2"><a href="#">Office</a></li>
                        <li class="mb-2"><a href="#">Outdoor</a></li>
                        <li class="mb-2"><a href="#">New Arrivals</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 fade-in delay-2">
                    <h5 class="mb-4">Company</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="#">About Us</a></li>
                        <li class="mb-2"><a href="#">Blog</a></li>
                        <li class="mb-2"><a href="#">Careers</a></li>
                        <li class="mb-2"><a href="#">Press</a></li>
                        <li class="mb-2"><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 fade-in delay-3">
                    <h5 class="mb-4">Help</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="#">FAQs</a></li>
                        <li class="mb-2"><a href="#">Shipping</a></li>
                        <li class="mb-2"><a href="#">Returns</a></li>
                        <li class="mb-2"><a href="#">Order Status</a></li>
                        <li class="mb-2"><a href="#">Size Guide</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 fade-in delay-4">
                    <h5 class="mb-4">Contact</h5>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Design St, New York</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> (123) 456-7890</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> hello@elysianhome.com</li>
                    </ul>
                </div>
            </div>
            <hr class="my-5 bg-secondary">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="text-muted small">&copy; 2024 ElysianHome. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="text-muted small">
                        <a href="#" class="text-muted text-decoration-none me-3">Privacy Policy</a>
                        <a href="#" class="text-muted text-decoration-none me-3">Terms of Service</a>
                        <a href="#" class="text-muted text-decoration-none">Accessibility</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <a href="#" class="btn btn-primary rounded-circle position-fixed bottom-0 end-0 m-4" id="back-to-top"
        style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Back to top button
        const backToTopButton = document.getElementById('back-to-top');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTopButton.style.display = 'flex';
            } else {
                backToTopButton.style.display = 'none';
            }
        });

        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 70,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>

</body>

</html>
