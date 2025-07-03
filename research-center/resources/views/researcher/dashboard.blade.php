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

    {{-- Statistik Publikasi --}}

    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-teal text-white">
                <div class="card-body">
                    <h6>Total Publikasi</h6>
                    <h3>{{ $totalPublications }}</h3>
                </div>
            </div>
        </div>
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
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6>Total Proyek</h6>
                    <h3>{{ $totalProjects }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6>Proyek Berjalan</h6>
                    <h3>{{ $ongoingProjects }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6>Proyek Selesai</h6>
                    <h3>{{ $completedProjects }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>Total Dataset</h6>
                    <h3>{{ $totalDatasets }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h6>Dataset Terjual</h6>
                    <h3>{{ $totalDatasetsSold }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-indigo text-white">
                <div class="card-body">
                    <h6>Total Review</h6>
                    <h3>{{ $totalReviews }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection