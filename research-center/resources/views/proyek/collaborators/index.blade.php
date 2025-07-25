@extends('layout.backend.main', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])
@section('title', 'Daftar Kolaborator Semua Proyek')
@section('content')

<h1 class="mb-4">Daftar Kolaborator Semua Proyek</h1>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    @forelse($projects as $project)
    <div class="col-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Proyek: {{ $project->title }}</h5>
                <span class="pending-count-badge" data-project-id="{{ $project->id }}">
                    <span class="badge bg-secondary">Loading...</span>
                </span>
            </div>
            <div class="card-body">
                @if($project->collaborators->isEmpty())
                    <div class="alert alert-warning mb-0">Belum ada kolaborator yang terdaftar.</div>
                @else
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Posisi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($project->collaborators as $collaborator)
                            <tr>
                                <td>{{ $collaborator->user->name }}</td>
                                <td>{{ $collaborator->user->email }}</td>
                                <td>{{ $collaborator->position ?? '-' }}</td>
                                <td>{{ ucfirst($collaborator->status) }}</td>
                                <td>
                                    <a href="{{ route('admin.projects.collaborators.show', ['project' => $project->id, 'user' => $collaborator->user_id]) }}" class="btn btn-info btn-sm" title="Detail">
                                        <i class="ph-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">Belum ada proyek yang tersedia.</div>
    </div>
    @endforelse
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.pending-count-badge').each(function () {
            const container = $(this);
            const projectId = container.data('project-id');

            $.ajax({
                url: `/admin/project/${projectId}/pending-count`,
                method: 'GET',
                success: function (response) {
                    if (response.count > 0) {
                        container.html(`<span class="badge bg-warning text-dark">${response.count} pending</span>`);
                    } else {
                        container.html('');
                    }
                },
                error: function () {
                    container.html('<span class="badge bg-danger">Error</span>');
                }
            });
        });
    });
</script>
@endpush
