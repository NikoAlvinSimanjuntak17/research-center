@extends('layout.backend.main', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])
@section('title', 'Gaung Proyek Penelitian')

@section('content')

{{-- Flash Messages --}}
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@elseif (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

{{-- Proyek yang Diikuti --}}
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Proyek yang Kamu Ikuti</h4>

        <ul class="nav nav-tabs border-0" id="joinedProjectTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved"
                    type="button" role="tab" aria-controls="approved" aria-selected="true">
                    Disetujui
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending"
                    type="button" role="tab" aria-controls="pending" aria-selected="false">
                    Menunggu
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected"
                    type="button" role="tab" aria-controls="rejected" aria-selected="false">
                    Ditolak
                </button>
            </li>
        </ul>
    </div>

    <div class="card-body">
        @if (empty($joinedProjects['approved']) && empty($joinedProjects['pending']) && empty($joinedProjects['rejected']))
        <div class="alert alert-info">Kamu belum bergabung di proyek manapun.</div>
        @else
        <div class="tab-content" id="joinedProjectTabsContent">
            <div class="tab-pane fade show active" id="approved" role="tabpanel" aria-labelledby="approved-tab">
                @include('researcher.projects.join._table', ['projects' => collect($joinedProjects['approved']), 'canJoin' => false])
            </div>
            <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                @include('researcher.projects.join._table', ['projects' => collect($joinedProjects['pending']), 'canJoin' => false])
            </div>
            <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
                @include('researcher.projects.join._table', ['projects' => collect($joinedProjects['rejected']), 'canJoin' => false])
            </div>
        </div>
        @endif
    </div>
</div>




{{-- Proyek yang Tersedia untuk Diikuti --}}
<div class="card">
    <div class="card-header">
        <h4>Proyek yang Bisa Diikuti</h4>
    </div>
    <div class="card-body">
        @if ($availableProjects->isEmpty())
        <div class="alert alert-success">Tidak ada proyek baru untuk saat ini.</div>
        @else
        @include('researcher.projects.join._table', ['projects' => $availableProjects, 'canJoin' => true])
        @endif
    </div>
</div>

@endsection