@extends('fe.master')

@section('allproductpage')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Our Products</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-5">
        <div class="container">
            <!-- Simple Search & Category Filter -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="search-filter">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search products...">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="search-filter">
                        <select class="form-select">
                            <option selected>All Categories</option>
                            @foreach ($categories as $category)
                                <option>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-md-6 col-lg-4">
                        <div class="product-card" data-category="{{ $product->category->name }}">
                            <div class="product-img-container">
                                <img src="{{ asset('storage/product/' . $product->image) }}" class="product-img"
                                    alt="{{ $product->name }}">
                            </div>
                            <div class="p-3">
                                <h5>{{ $product->name }}</h5>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-primary fw-bold">Rp. {{ number_format($product->price, 0) }}</span>
                                </div>
                                <p>
                                    {{ substr($product->description, 0, 64) }}...
                                </p>
                                {{-- <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="text-warning">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($product->rating))
                                                <i class="fas fa-star"></i>
                                            @elseif ($i === ceil($product->rating) && $product->rating % 1 !== 0)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                        <span class="text-muted ms-1">({{ $product->reviews }})</span>
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

            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-5">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
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

        $(document).ready(function() {
            $('.add-to-cart-form').on('submit', function(e) {
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
                    success: function(response) {
                        swal("Good Job!", "Produk berhasil ditambahkan ke keranjang!", "success");
                    },
                    error: function(xhr) {
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
                            swal("Error!", "Gagal menambahkan produk ke keranjang.", "error");
                        }
                    }
                });
            });
        });
    </script>
@endsection

<script src="{{ asset('fe/assets/js/product-filter.js') }}"></script>
