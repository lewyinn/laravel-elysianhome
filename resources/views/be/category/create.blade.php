@extends('be.master')

@section('createcategorypage')
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
        <h1 class="fs-3 fw-bold text-dark">Add New Category</h1>
    </div>

    <div class="container-fluid">
        <!-- Project Input Form -->
        <div class="card shadow">
            <div class="card-header py-3 border-bottom">
                <h3 class="fs-5 fw-medium">Category Forms</h3>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('category.store') }}" id="formCreateCategory" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter Name of Category">
                    </div>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <button type="button" id="btnSimpan" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const btnSave = document.getElementById('btnSimpan');
        const name = document.getElementById('name');
        const form = document.getElementById('formCreateCategory');
        const body = document.getElementById('body');

        function simpan() {
            if (name.value === '') {
                name.focus();
                swal("Data Kosong!", "Input Name Harus Di Isi!", "error");
            } else {
                form.submit();
            }
        }

        btnSave.onclick = function() {
            simpan();
        }
    </script>
@endsection
