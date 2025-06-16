@extends('be.master')

@section('edituserpage')
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
        <h1 class="fs-3 fw-bold text-dark">Add New Project</h1>
    </div>

    <div class="container-fluid">
        <!-- Project Input Form -->
        <div class="card shadow">
            <div class="card-header py-3 border-bottom">
                <h3 class="fs-5 fw-medium">Project Details</h3>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Wajib untuk update -->

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', $user->name) }}" placeholder="Enter Name" required>
                    </div>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email"
                            value="{{ old('email', $user->email) }}" placeholder="Enter Email" required>
                    </div>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role"
                            required>
                            <option value="" disabled>Select role</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                    @error('role')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password" name="password"
                            placeholder="Enter Password" required>
                    </div>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="text" class="form-control" id=password_confirmationd" name="password_confirmation"
                            placeholder="Enter Confirm Password" required>
                    </div>
                    @error('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const btnSave = document.getElementById('btnSimpan');
        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password_confirmation');
        const form = document.getElementById('formCreateUser');
        const body = document.getElementById('body');

        function simpan() {
            if (name.value === '') {
                name.focus();
                swal("Data Kosong!", "Input Name Harus Di Isi!", "error");
            } else if (email.value === '') {
                email.focus();
                swal("Data Kosong!", "Input Email Harus Di Isi!", "error");
            } else if (password.value === '') {
                password.focus();
                swal("Data Kosong!", "Input Password Harus Di Isi!", "error");
            } else if (confirmPassword.value === '') {
                confirmPassword.focus();
                swal("Data Kosong!", "Input Confirm Password Harus Di Isi!", "error");
            } else {
                form.submit();
            }
        }

        btnSave.onclick = function() {
            simpan();
        }
    </script>
@endsection
