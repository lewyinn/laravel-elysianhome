@extends('fe.master')

@section('cartpage')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Shopping Cart</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cart</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Cart Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <div class="cart-table mb-4">
                        <table class="table table-borderless mb-0">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="cart-items">
                                @foreach ($cartItems as $item)
                                    <tr class="cart-item" data-id="{{ $item->id }}"
                                        data-price="{{ $item->product->price }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('storage/product/' . $item->product->image) }}"
                                                    alt="{{ $item->product->name }}" class="cart-item-img me-3"
                                                    width="60">
                                                <div>
                                                    <h6 class="mb-0">{{ $item->product->name }}</h6>
                                                    <small class="text-muted">{{ $item->product->category->name }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp {{ number_format($item->product->price, 0) }}</td>
                                        <td>
                                            <input type="number" class="form-control quantity-input"
                                                value="{{ $item->quantity }}" min="1"
                                                data-item-id="{{ $item->id }}">
                                        </td>
                                        <td class="item-total">
                                            Rp {{ number_format($item->product->price * $item->quantity, 0) }}
                                        </td>
                                        <td>
                                            <button
                                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $item->id }}').submit();"
                                                class="btn btn-remove">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $item->id }}"
                                                action="{{ route('cart.destroy', $item->id) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('all-product.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                    </a>
                </div>

                <!-- Cart Summary -->
                <div class="col-lg-4">
                    <div class="cart-summary">
                        <h5 class="mb-4">Order Summary</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal</span>
                            <span id="subtotal">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Shipping</span>
                            <span>Free</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total</strong>
                            <strong id="total">Rp 0</strong>
                        </div>
                        {{-- <form action="{{ route('cart.process') }}" method="POST">
                            @csrf
                            <input type="hidden" name="shipping_address" value="Default Address">
                            <input type="hidden" name="payment_method" value="manual">
                            <button type="submit" class="btn btn-primary w-100">Process to Checkout</button>
                        </form> --}}
                        <button id="pay-button" class="btn btn-success w-100" disabled>
                            <i class="fas fa-credit-card me-2"></i>
                            <span id="pay-button-text">Pay with Midtrans</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

    <script type="text/javascript">
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

        let currentOrder = null;

        // Enable pay button when cart has items
        document.addEventListener('DOMContentLoaded', function() {
            const cartItems = document.querySelectorAll('.cart-item');
            const payButton = document.getElementById('pay-button');

            if (cartItems.length > 0) {
                payButton.disabled = false;
            }
        });

        document.getElementById('pay-button').onclick = function(){
            const payButton = this;
            const payButtonText = document.getElementById('pay-button-text');

            // Disable button and show loading
            payButton.disabled = true;
            payButtonText.textContent = 'Processing...';
            payButton.classList.add('loading');

            // Create order first
            fetch('{{ route("cart.process") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    shipping_address: 'Default Address',
                    payment_method: 'midtrans'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    currentOrder = data.order_id;
                    // Open Midtrans payment modal
                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            // Redirect to success page
                            window.location.href = '{{ route("cart.payment.success") }}?order_id=' + currentOrder;
                        },
                        onPending: function(result) {
                            // Handle pending payment
                            alert('Pembayaran Anda sedang diproses. Silakan tunggu konfirmasi.');
                            window.location.reload();
                        },
                        onError: function(result) {
                            // Handle payment error
                            window.location.href = '{{ route("cart.payment.failed") }}?order_id=' + currentOrder;
                        },
                        onClose: function() {
                            // Handle when user closes the modal
                            swal("Cancelled", "Pembayaran telah dibatalkan.", "error");
                            // Reset button
                            payButton.disabled = false;
                            payButtonText.textContent = 'Pay with Midtrans';
                            payButton.classList.remove('loading');
                        }
                    });
                } else {
                    swal("Error!", data.error, "error");
                    // Reset button
                    payButton.disabled = false;
                    payButtonText.textContent = 'Pay with Midtrans';
                    payButton.classList.remove('loading');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                swal("Error!", "Terjadi kesalahan saat memproses pembayaran.", "error");
                // Reset button
                payButton.disabled = false;
                payButtonText.textContent = 'Pay with Midtrans';
                payButton.classList.remove('loading');
            });
        };
    </script>
@endsection

<script src="{{ asset('fe/assets/js/cart.js') }}"></script>
