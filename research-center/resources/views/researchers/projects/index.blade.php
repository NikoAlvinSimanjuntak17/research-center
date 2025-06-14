@extends('researchers.layouts.app')
@section('title', 'Proyek')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            {{-- Flash Message Success --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ph-check-circle me-1"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Flash Message Error --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="ph-x-circle me-1"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Validasi Error --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Daftar Proyek</h3>
                    <a href="{{ route('researchers.projects.create') }}" class="btn btn-primary">Tambah Proyek</a>
                </div>
                
                <div class="card-body">
                    
                    @if($projects->isEmpty())
                        <div class="alert alert-info">Belum ada proyek.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nama Proyek</th>
                                        <th>Leader</th>
                                        <th>Deskripsi</th>
                                        <th>Status Pendaftaran</th>
                                        <th>Approval Status</th>
                                        <th>Progress Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($projects as $project)
                                        <tr>
                                            <td>{{ $project->title }}</td>

                                            {{-- Leader --}}
                                            <td>
                                                {{ optional($project->leader?->user)->name ?? '-' }}
                                            </td>

                                            {{-- Deskripsi --}}
                                            <td>
                                                {!! Str::limit(strip_tags($project->description), 100, '...') !!}
                                            </td>

                                            {{-- Status --}}
                                            <td>
                                                <span class="badge bg-{{ $project->status === 'open' ? 'success' : ($project->status === 'close' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($project->status) }}
                                                </span>
                                            </td>
                                            {{-- Approval Status --}}
                                            <td>
                                                @if ($project->approval_status === 'approved')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif ($project->approval_status === 'rejected')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @else
                                                    <span class="badge bg-warning">Menunggu</span>
                                                @endif
                                            </td>
                                            {{-- Progress Status --}}
                                            <td>
                                                @if ($project->progress_status === 'in_progress')
                                                    <span class="badge bg-primary">In Progress</span>
                                                @elseif ($project->progress_status === 'completed')
                                                    <span class="badge bg-success">Completed</span>
                                                @else
                                                    <span class="badge bg-secondary">Belum Dimulai</span>
                                                @endif
                                            </td>
                                            {{-- Tanggal --}}
                                            <td>
                                                {{ $project->open_at?->format('d M Y') ?? '-' }} -
                                                {{ $project->close_at?->format('d M Y') ?? '-' }}
                                            </td>
                                            
                                            {{-- Aksi --}}
                                            <td>
                                                @if($project->approval_status === 'pending')
                                                <a href="{{ route('researchers.projects.edit', $project->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="ph-pencil"></i>
                                                </a>
                                                
                                                <form action="{{ route('researchers.projects.destroy', $project->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus proyek ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                        <i class="ph-trash"></i>
                                                    </button>
                                                </form>
                                                @endif
                                                
                                                <!-- Tombol Detail selalu tampil -->
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#projectDetailModal{{ $project->id }}" title="Detail">
                                                    <i class="ph-eye"></i>
                                                </button>

                                                @if ($project->approval_status === 'approved' && $project->progress_status === 'in_progress')
                                                <a href="{{ route('researchers.projects.form', $project->id) }}" class="btn btn-success btn-sm"  title="Selesaikan Proyek">
                                                <i class="ph-check"></i>
                                                 </a>
                                            @endif
                                            
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @foreach ($projects as $project)
                            <div class="modal fade" id="projectDetailModal{{ $project->id }}" tabindex="-1" aria-labelledby="projectDetailModalLabel{{ $project->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="projectDetailModalLabel{{ $project->id }}">
                                                Detail Proyek: {{ $project->title }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        
                                        <div class="modal-body">
                                            <p><strong>Judul:</strong> {{ $project->title }}</p>
                                            
                                            <p>
                                                <strong>Leader:</strong><br>
                                                {{ $project->leader?->user?->name ?? '-' }}<br>
                                                <small>{{ $project->leader?->institution ?? '-' }}</small>
                                            </p>
                                            
                                            <p><strong>Deskripsi Proyek:</strong></p>
                                            <div style="background-color: #f8f9fa; padding: 10px; border-radius: 5px;">
                                                {!! $project->description !!}
                                            </div>
                                            <p class="mt-3"><strong>Kolaborator:</strong></p>
                                            <ul>
                                                @forelse ($project->collaborators->where('status', 'approved') as $collaborator)
                                                <li>
                                                    {{ $collaborator->user->name ?? '-' }} — 
                                                    <small>{{ $collaborator->institution ?? '-' }}</small>
                                                </li>
                                                @empty
                                                <li><em>Belum ada kolaborator yang disetujui.</em></li>
                                                @endforelse
                                            </ul>                                        
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                        </div>
                        @endif
                    </div>
                </div>
                <!-- Modal Detail Proyek -->
        </div>
    </div>
</div>
@endsection
