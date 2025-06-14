@extends('Researchers.Layouts.app')

@section('title', 'Dashboard Peneliti')

@section('content')
<h1 class="mb-4">Dashboard Peneliti</h1>

<div class="row">
    <!-- Total Publikasi -->
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h3>{{ $totalPublications }}</h3>
                <p>Total Publikasi</p>
            </div>
        </div>
    </div>

    <!-- Total Proyek -->
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h3>{{ $totalProjects }}</h3>
                <p>Total Proyek</p>
            </div>
        </div>
    </div>

    <!-- Proyek Berjalan -->
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h3>{{ $projectsInProgress }}</h3>
                <p>Proyek Berjalan</p>
            </div>
        </div>
    </div>

    <!-- Proyek Selesai -->
    <div class="col-md-3">
        <div class="card bg-dark text-white">
            <div class="card-body">
                <h3>{{ $projectsCompleted }}</h3>
                <p>Proyek Selesai</p>
            </div>
        </div>
    </div>
</div>

{{-- Chart berdasarkan source --}}
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Publikasi Berdasarkan Sumber</div>
            <div class="card-body">
                <canvas id="publicationSourceChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tabel Kolaborator per Proyek -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Kolaborator per Proyek</div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($collaboratorsPerProject as $project)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $project->title }}
                            <span class="badge bg-info">{{ $project->collaborators_count }} kolaborator</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    
    new Chart(document.getElementById('publicationSourceChart'), {
        type: 'pie',
        data: {
            labels: sources,
            datasets: [{
                data: totals,
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1']
            }]
        }
    });
</script>
@endsection
