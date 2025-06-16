@extends('be.master')

@section('productpage')
    <!-- Header -->
    <div class="d-flex flex-column justify-content-between align-items-start mb-5">
        <h1 class="fs-3 fw-bold text-dark">Table Product Overview</h1>
        <a class="btn btn-success" href="{{ route('product.create') }}">Add New Product</a>
    </div>

    <div class="container-fluid">
        <!-- Dashboard Table -->
        <div class="card shadow">
            <div class="card-header py-3 border-bottom">
                <h3 class="fs-5 fw-medium">Dashboard Data Product</h3>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-uppercase small">No.</th>
                                <th scope="col" class="px-4 py-3 text-uppercase small">Name</th>
                                <th scope="col" class="px-4 py-3 text-uppercase small">Description</th>
                                <th scope="col" class="px-4 py-3 text-uppercase small">Price</th>
                                <th scope="col" class="px-4 py-3 text-uppercase small">Stock</th>
                                <th scope="col" class="px-4 py-3 text-uppercase small">Category</th>
                                <th scope="col" class="px-4 py-3 text-uppercase small">Image</th>
                                <th scope="col" class="px-4 py-3 text-uppercase small">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product as $item)
                                <tr>
                                    <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3">{{ $item->name }}</td>
                                    <td class="px-4 py-3">{{ $item->description }}</td>
                                    <td class="px-4 py-3">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">{{ $item->stock }}</td>
                                    <td class="px-4 py-3">{{ $item->category->name }}</td>
                                    <td class="px-4 py-3">
                                        <img src="{{ asset('storage/product/' . $item->image) }}" alt=""
                                            width="100">
                                    </td>
                                    <td class="px-4 py-4  d-flex gap-2">
                                        <a href="{{ route('product.edit', $item->id) }}"
                                            class="btn text-light bg-warning">Edit</a>
                                        <form action="{{ route('product.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn text-light bg-danger">Delete</button>
                                        </form>
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
