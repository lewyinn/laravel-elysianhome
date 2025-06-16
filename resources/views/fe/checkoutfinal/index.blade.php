@extends('fe.master')

@section('checkoutfinalpage')

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Order Confirmed</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('keranjang.index') }}">Cart</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Checkout Success</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Success Section -->
    <section class="py-5">
        <div class="container">
            <div class="success-section mb-5 text-center">
                <i class="fas fa-check-circle success-icon fs-1 text-success mb-3"></i>
                <h2 class="mb-3">Thank You for Your Order!</h2>
                <p class="text-muted mb-4">Your order has been successfully placed. You'll receive a confirmation email soon
                    with the details below.</p>
                <a href="{{ route('all-product.index') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-bag me-2"></i> Continue Shopping
                </a>
            </div>

            @if ($order)
                <!-- Order Summary -->
                <div class="order-table">
                    <h5 class="mb-4">Order Summary</h5>
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th>Order Number:</th>
                                <td>#{{ $order->order_number }}</td>
                            </tr>
                            <tr>
                                <th>Order Date:</th>
                                <td>{{ $order->created_at->format('F d, Y') }}</td>
                            </tr>
                            <tr>
                                <th>Shipping Address:</th>
                                <td>{{ $order->shipping_address }}</td>
                            </tr>
                            <tr>
                                <th>Payment Method:</th>
                                <td>{{ $order->payment_method }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <hr>

                    <h6 class="mt-4 mb-3">Items Ordered</h6>
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($order->items->count() === 1)
                                @php
                                    $item = $order->items->first();
                                @endphp
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                            @else
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong>Rp{{ number_format($order->total_price, 0, ',', '.') }}</strong>
                    </div>
                </div>
            @else
                <div class="alert alert-info text-center">
                    <p class="mb-0">No completed order found.</p>
                </div>
            @endif
        </div>

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
        </script>
    </section>
@endsection
