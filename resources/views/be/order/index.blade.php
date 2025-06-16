@extends('be.master')

@section('orderpage')
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
        <h1 class="fs-3 fw-bold text-dark">Table Order Overview</h1>
    </div>

    <div class="container-fluid">
        <!-- Dashboard Table -->
        <div class="card shadow">
            <div class="card-header py-3 border-bottom">
                <h3 class="fs-5 fw-medium">Dashboard Orders Data</h3>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-uppercase small">Order Numbers.</th>
                                <th scope="col" class="px-4 py-3 text-uppercase small">Date</th>
                                <th scope="col" class="px-4 py-3 text-uppercase small">Total</th>
                                <th scope="col" class="px-4 py-3 text-uppercase small">Status</th>
                                <th scope="col" class="px-4 py-3 text-uppercase small">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="px-4 py-3">{{ $order->id }} - {{ $order->order_number }} </td>
                                    <td class="px-4 py-3">{{ $order->created_at->format('F d, Y') }}</td>
                                    <td class="px-4 py-3">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">
                                        @php
                                            $badge = match ($order->status) {
                                                'pending' => 'warning',
                                                'paid' => 'primary',
                                                'shipped' => 'info',
                                                'completed' => 'success',
                                                'cancelled' => 'danger',
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $badge }}">{{ $order->status }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('order.edit', $order->id) }}"
                                            class="btn text-light bg-warning">Edit Status</a>
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
@endsection
