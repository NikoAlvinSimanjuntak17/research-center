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
    <div class="card-header">
        <h4>Proyek yang Kamu Ikuti</h4>
    </div>
    <div class="card-body">
        @if ($joinedProjects->isEmpty())
            <div class="alert alert-info">Kamu belum bergabung di proyek manapun.</div>
        @else
            @include('researcher.projects.join._table', ['projects' => $joinedProjects, 'canJoin' => false])
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
