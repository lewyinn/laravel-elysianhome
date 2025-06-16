<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyDashboard</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom CSS -->
    <style>
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 18rem;
            background-color: #fff;
            border-right: 1px solid #dee2e6;
            padding-top: 0;
        }

        .main-content {
            margin-left: 18rem;
            padding-top: 0;
        }

        .welcome-banner {
            background: linear-gradient(to right, #4f46e5, #7c3aed);
            margin-top: 0;
        }

        /* Efek hover tambahan untuk btn-outline-primary */
        .btn-outline-primary:hover {
            background-color: #f8f9fa;
            /* Warna light untuk hover */
        }

        @media (max-width: 991.98px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>

    <!-- SweetAlert CSS and JS -->
    <script src="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.js"></script>
    <link rel="stylesheet" href="https://lipis.github.io/bootstrap-sweetalert/dist/sweetalert.css">
</head>

<body id="body">
    <!-- Mobile Sidebar (Offcanvas) -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header">
            <h1 class="offcanvas-title fs-4 fw-bold text-primary" id="mobileSidebarLabel">MyDashboard</h1>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <nav>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('dashboard.index') }}"
                            class="btn btn-outline-primary d-flex align-items-center p-3 rounded text-decoration-none w-100"
                            id="mobile-dashboard-link">
                            <span class="me-3 fs-5">🏠</span>
                            Dashboard
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('category.index') }}"
                            class="btn btn-outline-primary d-flex align-items-center p-3 rounded text-decoration-none w-100"
                            id="mobile-category-link">
                            <span class="me-3 fs-5">📂</span>
                            Category
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('product.index') }}"
                            class="btn btn-outline-primary d-flex align-items-center p-3 rounded text-decoration-none w-100"
                            id="mobile-product-link">
                            <span class="me-3 fs-5">✅</span>
                            Product
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('order.index') }}"
                            class="btn btn-outline-primary d-flex align-items-center p-3 rounded text-decoration-none w-100"
                            id="mobile-orders-link">
                            <span class="me-3 fs-5">📊</span>
                            Orders
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('users.index') }}"
                            class="btn btn-outline-primary d-flex align-items-center p-3 rounded text-decoration-none w-100"
                            id="mobile-users-link">
                            <span class="me-3 fs-5">📊</span>
                            Users
                        </a>
                    </li>
                    <li class="mb-2">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="btn btn-danger d-flex align-items-center p-3 rounded text-decoration-none w-100 text-start">
                                <span class="me-3 fs-5">🔓</span>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Desktop Sidebar -->
    <div class="sidebar d-none d-lg-block">
        <div class="p-4">
            <h1 class="fs-4 fw-bold text-primary">MyDashboard</h1>
        </div>
        <nav class="px-4 flex-grow-1">
            <ul class="list-unstyled">
                <li class="mb-2">
                    <a href="{{ route('dashboard.index') }}"
                        class="btn btn-outline-primary d-flex align-items-center p-3 rounded text-decoration-none w-100"
                        id="dashboard-link">
                        <span class="me-3 fs-5">🏠</span>
                        Dashboard
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('category.index') }}"
                        class="btn btn-outline-primary d-flex align-items-center p-3 rounded text-decoration-none w-100"
                        id="category-link">
                        <span class="me-3 fs-5">📂</span>
                        Category
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('product.index') }}"
                        class="btn btn-outline-primary d-flex align-items-center p-3 rounded text-decoration-none w-100"
                        id="product-link">
                        <span class="me-3 fs-5">✅</span>
                        Product
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('order.index') }}"
                        class="btn btn-outline-primary d-flex align-items-center p-3 rounded text-decoration-none w-100"
                        id="orders-link">
                        <span class="me-3 fs-5">📊</span>
                        Orders
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('users.index') }}"
                        class="btn btn-outline-primary d-flex align-items-center p-3 rounded text-decoration-none w-100"
                        id="users-link">
                        <span class="me-3 fs-5">📊</span>
                        Users
                    </a>
                </li>
                <li class="mb-2">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="btn btn-danger d-flex align-items-center p-3 rounded text-decoration-none w-100 text-start">
                            <span class="me-3 fs-5">🔓</span>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Mobile Header -->
    <header class="sticky-top bg-white shadow-sm py-3 px-4 d-lg-none">
        <div class="d-flex align-items-center">
            <button class="btn p-0 me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar"
                aria-controls="mobileSidebar">
                <span class="fs-3">☰</span>
            </button>
            <h1 class="flex-grow-1 fs-5 fw-semibold">Dashboard</h1>
            <a href="#" class="text-decoration-none">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                    style="width: 2rem; height: 2rem;">
                    <span>👤</span>
                </div>
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content py-5 px-4">
        @if ($title === 'Dashboard')
            @yield('dashboardpage')
        @elseif ($title === 'Category')
            @yield('categorypage')
            @yield('createcategorypage')
            @yield('editcategorypage')
        @elseif ($title === 'Product')
            @yield('productpage')
            @yield('createproductpage')
            @yield('editproductpage')
        @elseif ($title === 'Order')
            @yield('orderpage')
            @yield('editorderpage')
        @elseif ($title === 'Users')
            @yield('userspage')
            @yield('createuserpage')
            @yield('edituserpage')
        @endif
    </main>

    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        // Objek untuk mapping ID link ke path URL
        const menuLinks = {
            'dashboard-link': '/dashboard',
            'mobile-dashboard-link': '/dashboard',
            'category-link': '/admin/category',
            'mobile-category-link': '/admin/category',
            'product-link': '/admin/product',
            'mobile-product-link': '/admin/product',
            'orders-link': '/admin/order',
            'mobile-orders-link': '/admin/order',
            'users-link': '/admin/users',
            'mobile-users-link': '/admin/users'
        };

        // Dapatkan path URL saat ini
        const currentPath = window.location.pathname;

        // Loop melalui semua menu untuk set kelas aktif
        Object.keys(menuLinks).forEach(linkId => {
            const linkElement = document.getElementById(linkId);
            if (linkElement) {
                if (currentPath.includes(menuLinks[linkId])) {
                    linkElement.classList.remove('btn-outline-primary');
                    linkElement.classList.add('btn-primary', 'text-white');
                    linkElement.setAttribute('aria-current', 'page');
                } else {
                    linkElement.classList.remove('btn-primary', 'text-white');
                    linkElement.classList.add('btn-outline-primary');
                    linkElement.removeAttribute('aria-current');
                }
            }
        });
    </script>
</body>
</html>
