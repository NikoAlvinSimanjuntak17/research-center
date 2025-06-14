@extends('Admin.Layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<h1 class="mb-4">Dashboard Admin</h1>
<div class="row">
    <!-- Total Peneliti -->
    <div class="col-md-3">
        <div class="card bg-pink text-white">
            <div class="card-body">
                <h3 class="mb-0">{{ $totalResearchers }}</h3>
                <div>Total Peneliti</div>
            </div>
        </div>
    </div>

    <!-- Total Publikasi -->
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h3 class="mb-0">{{ $totalPublications }}</h3>
                <div>Total Publikasi</div>
            </div>
        </div>
    </div>

    <!-- Total Proyek -->
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h3 class="mb-0">{{ $totalProjects }}</h3>
                <div>Total Proyek</div>
            </div>
        </div>
    </div>

    <!-- Proyek Selesai -->
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h3 class="mb-0">{{ $completedProjects }}</h3>
                <div>Proyek Selesai</div>
            </div>
        </div>
    </div>

    <!-- Proyek Berjalan -->
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h3 class="mb-0">{{ $inProgressProjects }}</h3>
                <div>Proyek Berjalan</div>
            </div>
        </div>
    </div>

    <!-- Total Sitasi -->
    <div class="col-md-3">
        <div class="card bg-dark text-white">
            <div class="card-body">
                <h3 class="mb-0">{{ $totalCitations }}</h3>
                <div>Total Sitasi</div>
            </div>
        </div>
    </div>
</div>

{{-- Chart Publikasi Per Tahun --}}
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Grafik Publikasi per Tahun</div>
            <div class="card-body">
                <canvas id="publicationsChart" height="200"></canvas>
            </div>
        </div>
    </div>

    {{-- Chart Publikasi per Sumber --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Distribusi Sumber Publikasi</div>
            <div class="card-body">
                <canvas id="sourceChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data publikasi per tahun
    const publicationsPerYear = @json($publicationsPerYear);
    const years = publicationsPerYear.map(item => item.year);
    const totals = publicationsPerYear.map(item => item.total);

    const ctx1 = document.getElementById('publicationsChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: years,
            datasets: [{
                label: 'Jumlah Publikasi',
                data: totals,
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        }
    });

    // Data publikasi berdasarkan sumber
    const publicationsBySource = @json($publicationsBySource);
    const sources = publicationsBySource.map(item => item.source ?? 'Tidak Diketahui');
    const sourceCounts = publicationsBySource.map(item => item.total);

    const ctx2 = document.getElementById('sourceChart').getContext('2d');
    new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: sources,
            datasets: [{
                data: sourceCounts,
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1', '#17a2b8']
            }]
        }
    });
</script>
@endsection
