@extends('fe.master')

@section('historypage')

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Purchase History</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Purchase History</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- History Section -->
    <section class="py-5">
        <div class="container">
            <div class="history-table">
                <table class="table table-borderless mb-0">
                    <thead>
                        <tr>
                            <th>Order Number</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="history-items">
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->id }} - {{ $order->order_number }}</td>
                                <td>{{ $order->created_at->format('F d, Y') }}</td>
                                <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td>
                                    @php
                                        $badge = match ($order->status) {
                                            'pending' => 'warning',
                                            'paid' => 'secondary',
                                            'shipped' => 'primary',
                                            'completed' => 'success',
                                            'cancelled' => 'danger',
                                            default => 'secondary',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badge }}">{{ $order->status }}</span>
                                </td>
                                <td>
                                    @if ($order->status === 'pending')
                                        <button class="btn btn-sm btn-success pay-button" data-order-id="{{ $order->id }}">
                                            <i class="fas fa-credit-card me-1"></i> Pay
                                        </button>
                                    @elseif ($order->status === 'cancelled')
                                        <button class="btn btn-sm btn-danger" disabled>
                                            <i class="fas fa-times-circle me-1"></i> Sudah Gagal Bayar
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-outline-secondary" disabled>
                                            <i class="fas fa-check me-1"></i> Sudah Bayar
                                        </button>
                                    @endif

                                    @php
                                        $canPrint = in_array($order->status, ['paid', 'shipped', 'completed']);
                                    @endphp

                                    @if ($canPrint)
                                        <button class="btn btn-sm btn-print" id="btn-print" data-order-id="{{ $order->id }}">
                                            <i class="fas fa-print me-1"></i> Print Invoice
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <ul class="mb-0 small">
                                        @foreach ($order->orderItems as $item)
                                            <li>{{ $item->product->name }} - Qty: {{ $item->quantity }} @ Rp
                                                {{ number_format($item->price, 0, ',', '.') }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>



    <!-- Include Midtrans Snap script -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}"></script>

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

        // Handle Pay button click
        document.querySelectorAll('.pay-button').forEach(button => {
            button.addEventListener('click', function () {
                const orderId = this.getAttribute('data-order-id');

                // Make AJAX request to get Snap Token
                fetch('{{ url("/history/pay") }}/' + orderId, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Open Midtrans Snap popup
                        snap.pay(data.snap_token, {
                            onSuccess: function (result) {
                                // Redirect to success page
                                fetch('{{ route("history.payment-success") }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({
                                        order_id: data.order_id,
                                        payment_type: result.payment_type,
                                    }),
                                })
                                .then(() => {
                                    currentOrder = data.order_id;
                                    window.location.href = '/history/payment-success?order_id=' + currentOrder;
                                });
                            },
                            onPending: function (result) {
                                // Handle pending payment
                                alert('Pembayaran tertunda. Silakan selesaikan pembayaran Anda.');
                            },
                            onError: function (result) {
                                // Redirect to failed page
                                fetch('{{ route("history.payment-failed") }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({
                                        order_id: data.order_id,
                                    }),
                                })
                                .then(() => {
                                    currentOrder = data.order_id;
                                    window.location.href = '/history/payment-failed?order_id=' + currentOrder;
                                });
                            },
                            onClose: function () {
                                // Handle when user closes the popup
                                fetch('{{ route("history.payment-failed") }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({
                                        order_id: data.order_id,
                                    }),
                                })
                                .then(() => {
                                    currentOrder = data.order_id;
                                    window.location.href = '/history/payment-failed?order_id=' + currentOrder;
                                });
                            }
                        });
                    } else {
                        swal("Error!", data.error, "error");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    swal("Error!", "Terjadi kesalahan saat memproses pembayaran.", "error");
                });
            });
        });

        // Handle Print Invoice button click
        document.querySelectorAll('.btn-print').forEach(button => {
            button.addEventListener('click', function () {
                const orderId = this.getAttribute('data-order-id');
                window.open('/history/invoice/' + orderId, '_blank');
            });
        });
    </script>
@endsection
