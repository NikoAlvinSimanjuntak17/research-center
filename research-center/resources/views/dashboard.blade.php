@extends('layout.backend.main', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])
@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h2><i class="fa fa-dashboard"></i> Dashboard</h2>
                </div>
            </div>
        </div>
    </div>

    <?php
    $user = Auth::user();
    $role_user = DB::table('role_user')->where('user_id', $user->id)->first();
    ?>

    @if ($role_user->role_id == 1)
    {{-- Statistik Utama --}}
    <div class="row">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6>Total Pengguna</h6>
                    <h3>{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>Dataset Terjual</h6>
                    <h3>{{ $totalDatasetsSold }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6>Total Order</h6>
                    <h3>{{ $totalOrders }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h6>Review Masuk</h6>
                    <h3>{{ $totalReviews }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Proyek & Peneliti --}}
    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>Total Proyek</h6>
                    <h3>{{ $totalProjects }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h6>Proyek Berjalan</h6>
                    <h3>{{ $ongoingProjects }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <h6>Proyek Selesai</h6>
                    <h3>{{ $completedProjects }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-light text-dark">
                <div class="card-body">
                    <h6>Jumlah Peneliti</h6>
                    <h3>{{ $totalResearchers }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Publikasi --}}
    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <h6>Publikasi ORCID</h6>
                    <h3>{{ $pubOrcid }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>Publikasi Scopus</h6>
                    <h3>{{ $pubScopus }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6>Publikasi Scholar</h6>
                    <h3>{{ $pubScholar }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h6>Publikasi TSTH</h6>
                    <h3>{{ $pubTsth }}</h3>
                </div>
            </div>
        </div>
        {{-- Grafik Penjualan --}}
        <div class="card mt-4">
            <div class="card-header">Grafik Penjualan Bulanan</div>
            <div class="card-body">
                <canvas id="salesChart" height="100"></canvas>
            </div>
        </div>
    </div>
    @endif

    @if ($role_user->role_id == 2)
    {{-- Statistik Publikasi --}}
    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <h6>Publikasi ORCID</h6>
                    <h3>{{ $pubOrcid }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>Publikasi Scopus</h6>
                    <h3>{{ $pubScopus }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6>Publikasi Scholar</h6>
                    <h3>{{ $pubScholar }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h6>Publikasi TSTH</h6>
                    <h3>{{ $pubTsth }}</h3>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Chart Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Total Pendapatan (Rp)',
                    data: {!! json_encode($chartData) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: '#36A2EB',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let val = context.raw.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                return 'Rp ' + val;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return 'Rp ' + value.toLocaleString("id-ID");
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection