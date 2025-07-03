@extends('layout.backend.main', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])
@section('title', 'Detail Kolaborator')
@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Detail Kolaborator</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Nama Lengkap</dt>
                <dd class="col-sm-8">{{ $collaborator->user->name ?? '-' }}</dd>

                <dt class="col-sm-4">Email</dt>
                <dd class="col-sm-8">{{ $collaborator->user->email ?? '-' }}</dd>

                <dt class="col-sm-4">Posisi</dt>
                <dd class="col-sm-8">{{ $collaborator->position ?? '-' }}</dd>

                <dt class="col-sm-4">Institusi / Universitas</dt>
                <dd class="col-sm-8">{{ $collaborator->institution ?? '-' }}</dd>

                <dt class="col-sm-4">Fakultas / Departemen</dt>
                <dd class="col-sm-8">{{ $collaborator->department ?? '-' }}</dd>

                <dt class="col-sm-4">Bidang Keahlian</dt>
                <dd class="col-sm-8">{{ $collaborator->expertise ?? '-' }}</dd>

                <dt class="col-sm-4">Alasan Bergabung</dt>
                <dd class="col-sm-8">{{ $collaborator->reason ?? '-' }}</dd>

                <dt class="col-sm-4">CV</dt>
                <dd class="col-sm-8">
                    @if($collaborator->cv)
                        <a href="{{ Storage::url($collaborator->cv) }}" target="_blank">Lihat CV</a>
                    @else
                        <span class="text-muted">CV tidak tersedia</span>
                    @endif
                </dd>

                <dt class="col-sm-4">Tanggal Daftar</dt>
                <dd class="col-sm-8">{{ $collaborator->created_at ? $collaborator->created_at->format('d M Y H:i') : '-' }}</dd>
            </dl>
        </div>
    </div>

    <a href="{{ route('admin.projects.collaborators.index') }}" class="btn btn-secondary">
        ← Kembali ke Daftar
    </a>
</div>
@endsection
