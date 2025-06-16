@extends('be.master')

@section('editorderpage')
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
        <h1 class="fs-3 fw-bold text-dark">Edit Status Order</h1>
    </div>

    <div class="container-fluid">
        <!-- Project Input Form -->
        <div class="card shadow">
            <div class="card-header py-3 border-bottom">
                <h3 class="fs-5 fw-medium">Order Status</h3>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('order.update', $order->id) }}" id="formEditOrder" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label for="statusInput" class="form&B-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="statusInput" name="status"
                            required>
                            <option value="" disabled>Select status</option>
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="button" id="btnSimpan" class="btn btn-primary">Update Status</button>
                    <a href="{{ route('order.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        const btnSave = document.getElementById('btnSimpan');
        const status = document.getElementById('statusInput');
        const form = document.getElementById('formEditOrder');
        const body = document.getElementById('body');

        function simpan() {
            if (status.value === '') {
                status.focus();
                swal("Data Kosong!", "Input Status Harus Di Isi!", "error");
            } else {
                form.submit();
            }
        }

        btnSave.onclick = function() {
            simpan();
        }
    </script>
@endsection
