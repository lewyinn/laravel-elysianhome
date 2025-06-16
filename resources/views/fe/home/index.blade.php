@extends('fe.master')

@section('homepage')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content fade-in">
                <h1 class="display-4 fw-bold mb-4">Modern Furniture for Your Dream Home</h1>
                <p class="lead mb-4">Discover our curated collection of high-quality, stylish furniture that combines comfort
                    and elegance.</p>
                <a href="#products" class="btn btn-primary btn-lg px-4 me-2">Shop Now</a>
                <a href="#featured" class="btn btn-outline-light btn-lg px-4">Explore</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5" id="featured">
        <div class="container py-5">
            <div class="text-center mb-5 fade-in">
                <h2 class="fw-bold">Why Choose Us</h2>
                <p class="text-muted">We provide the best service for your home needs</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4 fade-in delay-1">
                    <div class="feature-card p-4 text-center h-100">
                        <div class="feature-icon bg-primary">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h4 class="mb-3">Fast Delivery</h4>
                        <p class="text-muted">Get your furniture delivered quickly and safely to your doorstep within 3-5
                            business days.</p>
                    </div>
                </div>
                <div class="col-md-4 fade-in delay-2">
                    <div class="feature-card p-4 text-center h-100">
                        <div class="feature-icon" style="background-color: var(--success);">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="mb-3">Quality Assurance</h4>
                        <p class="text-muted">All our products undergo strict quality checks to ensure durability and
                            safety.</p>
                    </div>
                </div>
                <div class="col-md-4 fade-in delay-3">
                    <div class="feature-card p-4 text-center h-100">
                        <div class="feature-icon" style="background-color: var(--warning);">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4 class="mb-3">24/7 Support</h4>
                        <p class="text-muted">Our customer service team is always ready to assist you with any questions or
                            concerns.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-5 bg-light" id="products">
        <div class="container py-5">
            <div class="text-center mb-5 fade-in">
                <h2 class="fw-bold">Featured Products</h2>
                <p class="text-muted">Discover our most popular items</p>
            </div>
            <div class="row g-4">
                @foreach ($products as $product)
                    <div class="col-lg-3 col-md-6 fade-in">
                        <div class="product-card h-100">
                            <div class="position-relative">
                                <img src="{{ asset('storage/product/' . $product->image) }}" class="product-img w-100"
                                    alt="Modern Sofa">
                                {{-- <div class="badge-discount">-20%</div> --}}
                            </div>
                            <div class="p-3">
                                <h5 style="height: 40px;">{{ $product->name }}</h5>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-primary fw-bold">Rp {{ number_format($product->price, 0) }}</span>
                                </div>
                                <p>
                                    {{ substr($product->description, 0, 64) }}...
                                </p>
                                {{-- <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="text-warning">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <span class="text-muted ms-1">(42)</span>
                                    </div>
                                </div> --}}
                                <form class="add-to-cart-form">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-5 fade-in">
                <a href="{{ route('all-product.index') }}" class="btn btn-outline-primary btn-lg">View All Products</a>
            </div>
        </div>
    </section>

    <!-- Banner Section -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center bg-primary text-white rounded-3 p-5">
                <div class="col-md-8 fade-in">
                    <h2 class="fw-bold mb-3">Summer Sale - Up to 40% Off</h2>
                    <p class="mb-4">Transform your home with our premium furniture collection at unbeatable prices.
                        Limited time offer!</p>
                    <a href="{{ route('all-product.index') }}" class="btn btn-light btn-lg">Shop the Sale</a>
                </div>
                <div class="col-md-4 fade-in delay-1">
                    <img src="{{ asset('fe/assets/img/banner-sale.png')}}"  alt="Summer Sale" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-5" id="testimonials">
        <div class="container py-5">
            <div class="text-center mb-5 fade-in">
                <h2 class="fw-bold">What Our Customers Say</h2>
                <p class="text-muted">Hear from people who love our products</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4 fade-in">
                    <div class="testimonial-card h-100 text-center">
                        <img src="fe/assets/img/testimonial-profile/cantika-profile.jpg" class="testimonial-img"
                            alt="Sarah J.">
                        <div class="text-warning mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="mb-4">"The quality of the sofa exceeded my expectations. It's comfortable, stylish, and
                            the delivery was super fast!"</p>
                        <h5 class="mb-1">Sarah Johnson</h5>
                        <p class="text-muted small">New York</p>
                    </div>
                </div>
                <div class="col-md-4 fade-in delay-1">
                    <div class="testimonial-card h-100 text-center">
                        <img src="fe/assets/img/testimonial-profile/geder-profile.jpg" class="testimonial-img"
                            alt="Michael T.">
                        <div class="text-warning mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <p class="mb-4">"I've bought several pieces from ElysianHome and they've all been fantastic. The
                            customer service is excellent too."</p>
                        <h5 class="mb-1">Michael Thompson</h5>
                        <p class="text-muted small">Los Angeles</p>
                    </div>
                </div>
                <div class="col-md-4 fade-in delay-2">
                    <div class="testimonial-card h-100 text-center">
                        <img src="fe/assets/img/testimonial-profile/susanto-profile.jpg" class="testimonial-img"
                            alt="Emily R.">
                        <div class="text-warning mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="mb-4">"The bed frame is absolutely stunning and so sturdy. It completely transformed my
                            bedroom. Worth every penny!"</p>
                        <h5 class="mb-1">Emily Rodriguez</h5>
                        <p class="text-muted small">Chicago</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="py-5">
        <div class="container">
            <div class="newsletter-section p-5 fade-in">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <h2 class="fw-bold mb-3">Subscribe to Our Newsletter</h2>
                        <p>Get the latest updates on new products, exclusive offers, and design inspiration.</p>
                    </div>
                    <div class="col-lg-6">
                        <form class="row g-2">
                            <div class="col-md-8">
                                <input type="email" class="form-control form-control-lg"
                                    placeholder="Your email address">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-light btn-lg w-100">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Ajaxx --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function tampil_pesan() {
            // Check if session variables are set
            const success = @json(session('success'));
            const error = @json(session('error'));

            // Check if swal is defined
            if (typeof swal === 'undefined') {
                console.error('SweetAlert is not loaded. Check CDN or network.');
                return;
            }

            // Show alerts only if session variables exist
            if (success) {
                swal("Good Job!", success, "success");
            }
            if (error) {
                swal("Error!", error, "error");
            }
        }

        // Use DOMContentLoaded instead of window.onload for better timing
        document.addEventListener('DOMContentLoaded', function() {
            tampil_pesan();
        });

        $(document).ready(function () {
        $('.add-to-cart-form').on('submit', function (e) {
            e.preventDefault(); // Mencegah form submit biasa

            const form = $(this);
            const url = "{{ route('cart.add') }}"; // Sesuaikan dengan rute kamu

            $.ajax({
                type: 'POST',
                url: url,
                data: form.serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    swal("Good Job!", "Produk berhasil ditambahkan ke keranjang!", "success");
                },
                error: function (xhr) {
                    if (xhr.status === 401) {
                        swal({
                            title: "Login Required",
                            text: "You need to log in to add items to your cart.",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        }).then((willLogin) => {
                            if (willLogin) {
                                window.location.href = "{{ route('login') }}"; // Ganti dengan rute login kamu
                            }
                        });
                    } else {
                        swal("Error!", "Gagal menambahkan produk ke keranjang. Silakan coba lagi.", "error");
                    }
                }
            });
        });
    });
    </script>
@endsection
