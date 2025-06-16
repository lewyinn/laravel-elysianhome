@extends('be.master')

@section('createproductpage')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
        <h1 class="fs-3 fw-bold text-dark">Add New Product</h1>
    </div>

    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header py-3 border-bottom">
                <h3 class="fs-5 fw-medium">Product Details</h3>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('product.store') }}" id="formCreateProduct" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Product">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Masukkan Deskripsi Produk"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="price" name="price" min="0" placeholder="Harga Product">
                    </div>

                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" min="0" placeholder="Jumlah Stock Product">
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="" disabled selected>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Product Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>

                    <button type="button" id="btnSimpan" class="btn btn-primary">Create Product</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const btnSave = document.getElementById('btnSimpan');
        const name = document.getElementById('name');
        const description = document.getElementById('description');
        const price = document.getElementById('price');
        const stock = document.getElementById('stock');
        const categories = document.getElementById('category_id');
        const image = document.getElementById('image');
        const form = document.getElementById('formCreateProduct');
        const body = document.getElementById('body');

        function simpan() {
            if (name.value === '') {
                name.focus();
                swal("Data Kosong!", "Input Name Harus Di Isi!", "error");
            } else if (description.value === '') {
                description.focus();
                swal("Data Kosong!", "Input Description Harus Di Isi!", "error");
            } else if (price.value === '') {
                price.focus();
                swal("Data Kosong!", "Input Price Harus Di Isi!", "error");
            } else if (stock.value === '') {
                stock.focus();
                swal("Data Kosong!", "Input Stock Harus Di Isi!", "error");
            } else if (categories.value === '') {
                categories.focus();
                swal("Data Kosong!", "Input Category Harus Di Isi!", "error");
            } else if (image.files.length === 0) {
                image.focus();
                swal("Data Kosong!", "Input Image Harus Di Isi!", "error");
            } else {
                form.submit();
            }
        }

        btnSave.onclick = function() {
            simpan();
        }
    </script>
@endsection
