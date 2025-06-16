@extends('be.master')

@section('editproductpage')
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
        <h1 class="fs-3 fw-bold text-dark">Edit Product</h1>
    </div>

    <div class="container-fluid">
        <!-- Product Edit Form -->
        <div class="card shadow">
            <div class="card-header py-3 border-bottom">
                <h3 class="fs-5 fw-medium">Product Details</h3>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input 
                            type="text" 
                            class="form-control @error('name') is-invalid @enderror" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $product->name) }}" 
                            placeholder="Enter product name" 
                            required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea 
                            class="form-control @error('description') is-invalid @enderror" 
                            id="description" 
                            name="description" 
                            rows="3" 
                            placeholder="Enter product description" 
                            required>{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price ($)</label>
                        <input 
                            type="number" 
                            class="form-control @error('price') is-invalid @enderror" 
                            id="price" 
                            name="price" 
                            value="{{ old('price', $product->price) }}" 
                            min="0" step="0.01" 
                            placeholder="Enter product price" 
                            required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input 
                            type="number" 
                            class="form-control @error('stock') is-invalid @enderror" 
                            id="stock" 
                            name="stock" 
                            value="{{ old('stock', $product->stock) }}" 
                            min="0" step="1" 
                            placeholder="Enter stock quantity" 
                            required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select 
                            class="form-select @error('category_id') is-invalid @enderror" 
                            id="category_id" 
                            name="category_id" 
                            required>
                            <option value="" disabled>Select category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Product Image</label>
                        <input 
                            type="file" 
                            class="form-control @error('image') is-invalid @enderror" 
                            id="image" 
                            name="image" 
                            accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        @if ($product->image)
                            <small>Current image:</small><br>
                            <img src="{{ asset('storage/product/' . $product->image) }}" alt="Current product image" style="max-width: 150px; margin-top: 10px;">
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Update Product</button>
                </form>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success custom-alert" role="alert">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger custom-alert" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <style>
        .custom-alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            /* Centers the alert horizontally */
            width: auto;
            /* Let the width adjust to the content */
            display: inline-block;
            /* Makes the alert wrap around the text */
            padding: 10px 20px;
            /* Adjust padding for better appearance */
            text-align: center;
            z-index: 1050;
        }

        .fade-out {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
    </style>

    <script>
        setTimeout(() => {
            const alertEl = document.querySelector('.custom-alert');
            if (alertEl) {
                alertEl.classList.add('fade-out');
                setTimeout(() => alertEl.remove(), 500);
            }
        }, 3000);
    </script>
@endsection
