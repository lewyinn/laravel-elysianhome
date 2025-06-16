@extends('fe.master')

@section('settingspage')
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Account Settings</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Settings</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Settings Section -->
    <section class="py-5">
        <div class="container">
            <div class="settings-section">
                <ul class="nav nav-tabs mb-4" id="settingsTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                            type="button" role="tab">Profile</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password"
                            type="button" role="tab">Password</button>
                    </li>
                </ul>
                <div class="tab-content" id="settingsTabContent">
                    <!-- Profile Tab -->
                    <div class="tab-pane fade show active" id="profile" role="tabpanel">
                        <h5 class="mb-4">Update Profile</h5>
                        <form id="profileForm" method="POST" action="{{ route('settings.updateProfile') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ auth()->user()->name }}" required>
                                </div>
                            </div>
                            <button type="button" id="btnSimpanProfile" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                    <!-- Password Tab -->
                    <div class="tab-pane fade" id="password" role="tabpanel">
                        <h5 class="mb-4">Change Password</h5>
                        <form id="passwordForm" method="POST" action="{{ route('settings.updatePassword') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="currentPassword" class="form-label">Current Password</label>
                                <input type="password" class="form-control" name="current_password" id="currentPassword"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">New Password</label>
                                <input type="password" class="form-control" name="new_password" id="newPassword" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" name="new_password_confirmation"
                                    id="confirmPassword" required>
                            </div>
                            <button type="button" id="btnSavePassword" class="btn btn-primary">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function tampil_pesan() {
            const success = @json(session('success'));
            const error = @json(session('error'));

            if (typeof swal === 'undefined') {
                console.error('SweetAlert is not loaded. Check CDN or network.');
                return;
            }

            if (success) {
                swal("Good Job!", success, "success");
            }
            if (error) {
                swal("Error!", error, "error");
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            tampil_pesan();
        });

        const btnSaveProfile = document.getElementById('btnSimpanProfile');
        const name = document.getElementById('name');
        const profileForm = document.getElementById('profileForm');

        btnSaveProfile.onclick = function() {
            if (name.value === '') {
                name.focus();
                swal("Data Kosong!", "Input Name Harus Di Isi!", "error");
            } else {
                profileForm.submit();
            }
        }

        const btnSavePassword = document.getElementById('btnSavePassword');
        const currentPassword = document.getElementById('currentPassword');
        const newPassword = document.getElementById('newPassword');
        const newPasswordConfirm = document.getElementById('confirmPassword');
        const passwordForm = document.getElementById('passwordForm');

        btnSavePassword.onclick = function() {
            if (currentPassword.value === '') {
                currentPassword.focus();
                swal("Data Kosong!", "Current Password harus diisi!", "error");
            } else if (newPassword.value === '') {
                newPassword.focus();
                swal("Data Kosong!", "New Password harus diisi!", "error");
            } else if (newPasswordConfirm.value === '') {
                newPasswordConfirm.focus();
                swal("Data Kosong!", "Confirm New Password harus diisi!", "error");
            } else if (newPassword.value !== newPasswordConfirm.value) {
                swal("Error!", "New Password dan Confirm Password tidak cocok!", "error");
            } else {
                passwordForm.submit();
            }
        }
    </script>
@endsection

<script src="{{ asset('fe/assets/js/settings.js') }}"></script>
