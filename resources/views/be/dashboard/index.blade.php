@extends('be.master')

@section('dashboardpage')
    <div class="container-fluid">
        <!-- Welcome Banner -->
        <div class="welcome-banner rounded-3 p-5 mb-5 shadow-sm text-white" style="margin-top: 0;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fs-3 fw-bold">Halo, {{ auth()->user()->name }}!</h2>
                    <p class="mt-1 text-indigo-100">Selamat datang kembali di Dashboard Anda</p>
                </div>
                <div class="d-none d-sm-block">
                    <span class="fs-1">👋</span>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5">
            <h1 class="fs-3 fw-bold text-dark">Dashboard Overview</h1>
        </div>

        <!-- Stats Cards -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4 mb-5">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <span class="fs-4 me-3">📈</span>
                            <div>
                                <p class="text-muted mb-1 small">Total Revenue</p>
                                <h5 class="mb-0">$45,231</h5>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-success small">+12% from last month</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <span class="fs-4 me-3">📈</span>
                            <div>
                                <p class="text-muted mb-1 small">New Users</p>
                                <h5 class="mb-0">2,345</h5>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-success small">+18% from last month</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <span class="fs-4 me-3">📉</span>
                            <div>
                                <p class="text-muted mb-1 small">Pending Orders</p>
                                <h5 class="mb-0">12</h5>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-danger small">-2% from last month</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <span class="fs-4 me-3">➖</span>
                            <div>
                                <p class="text-muted mb-1 small">Active Projects</p>
                                <h5 class="mb-0">9</h5>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="text-muted small">0% from last month</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Chart Card -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 border-bottom">
                        <h3 class="fs-5 fw-medium">Performance Metrics</h3>
                    </div>
                    <div class="card-body p-4">
                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center"
                            style="height: 20rem;">
                            <p class="text-muted">Chart will be displayed here</p>
                        </div>
                    </div>
                </div>

                <!-- Table Card -->
                <div class="card shadow">
                    <div class="card-header py-3 border-bottom">
                        <h3 class="fs-5 fw-medium">Recent Transactions</h3>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-uppercase small">ID</th>
                                        <th scope="col" class="px-4 py-3 text-uppercase small">Date</th>
                                        <th scope="col" class="px-4 py-3 text-uppercase small">Amount</th>
                                        <th scope="col" class="px-4 py-3 text-uppercase small">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="px-4 py-3">#TRX1001</td>
                                        <td class="px-4 py-3">2023-06-11</td>
                                        <td class="px-4 py-3">$250</td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">#TRX2002</td>
                                        <td class="px-4 py-3">2023-06-12</td>
                                        <td class="px-4 py-3">$500</td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-success">Completed</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">#TRX3003</td>
                                        <td class="px-4 py-3">2023-06-13</td>
                                        <td class="px-4 py-3">$750</td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">#TRX4004</td>
                                        <td class="px-4 py-3">2023-06-14</td>
                                        <td class="px-4 py-3">$1000</td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-success">Completed</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">#TRX5005</td>
                                        <td class="px-4 py-3">2023-06-15</td>
                                        <td class="px-4 py-3">$1250</td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Quick Actions -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 border-bottom">
                        <h3 class="fs-5 fw-medium">Quick Actions</h3>
                    </div>
                    <div class="card-body p-4">
                        <div class="row row-cols-2 g-3">
                            <div class="col">
                                <button
                                    class="btn bg-primary-subtle text-primary w-100 p-3 d-flex flex-column align-items-center">
                                    <span class="fs-4 mb-2">➕</span>
                                    <span class="small fw-medium">Add Item</span>
                                </button>
                            </div>
                            <div class="col">
                                <button
                                    class="btn bg-success-subtle text-success w-100 p-3 d-flex flex-column align-items-center">
                                    <span class="fs-4 mb-2">📤</span>
                                    <span class="small fw-medium">Export</span>
                                </button>
                            </div>
                            <div class="col">
                                <button
                                    class="btn bg-info-subtle text-info w-100 p-3 d-flex flex-column align-items-center">
                                    <span class="fs-4 mb-2">📊</span>
                                    <span class="small fw-medium">Report</span>
                                </button>
                            </div>
                            <div class="col">
                                <button
                                    class="btn bg-purple-subtle text-purple w-100 p-3 d-flex flex-column align-items-center">
                                    <span class="fs-4 mb-2">⚙️</span>
                                    <span class="small fw-medium">Settings</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="card shadow">
                    <div class="card-header py-3 border-bottom">
                        <h3 class="fs-5 fw-medium">Recent Activity</h3>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-unstyled">
                            <li class="position-relative pb-4">
                                <span class="position-absolute start-0 top-0 mt-3 ms-3 h-100 w-px bg-secondary"
                                    style="left: 1.5rem;"></span>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                        style="width: 2rem; height: 2rem;">
                                        <span>👨</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="small mb-0"><span class="fw-medium">John Doe</span> Completed the
                                            project dashboard</p>
                                    </div>
                                    <div class="text-muted small">1h ago</div>
                                </div>
                            </li>
                            <li class="position-relative pb-4">
                                <span class="position-absolute start-0 top-0 mt-3 ms-3 h-100 w-px bg-secondary"
                                    style="left: 1.5rem;"></span>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                        style="width: 2rem; height: 2rem;">
                                        <span>👩</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="small mb-0"><span class="fw-medium">Jane Smith</span> assigned
                                            <span class="fw-medium">New marketing campaign</span>
                                        </p>
                                    </div>
                                    <div class="text-muted small">2h ago</div>
                                </div>
                            </li>
                            <li class="position-relative">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                        style="width: 2rem; height: 2rem;">
                                        <span>🏢</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="small mb-0">Received payment of <span class="fw-medium">$5,000</span>
                                            from <span class="fw-medium">Client
                                                Corp</span></p>
                                    </div>
                                    <div class="text-muted small">1d ago</div>
                                </div>
                            </li>
                        </ul>
                    </div>
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
