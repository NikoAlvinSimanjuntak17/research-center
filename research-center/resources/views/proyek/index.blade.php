@extends('layout.backend.main', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])
@section('title', 'Proyek')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Daftar Proyek</h3>
                </div>
                
                <div class="card-body">
                    {{-- Bagian Permintaan Proyek --}}
                    @if($pendingProjects->isNotEmpty())
                    <div class="alert alert-warning">
                        <strong>Permintaan Proyek yang Menunggu Persetujuan:</strong>
                    </div>

                    
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-striped">
                            <thead class="table-warning">
                                <tr>
                                    <th>Nama Proyek</th>
                                    <th>Deskripsi Singkat</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendingProjects as $project)
                                <tr>
                                    <td>{{ $project->title }}</td>
                                    <td>{!! Str::limit(strip_tags($project->description), 100, '...') !!}</td>
                                    <td>
                                        {{ $project->open_at?->format('d M Y') ?? '-' }} -
                                        {{ $project->close_at?->format('d M Y') ?? '-' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">Menunggu Approval</span>
                                    </td>
                                    <td>
                                        <!-- Tombol Detail -->
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#pendingProjectDetailModal{{ $project->id }}" title="Detail">
                                            <i class="ph-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                                {{-- Modal Detail untuk Permintaan Proyek --}}
                                <div class="modal fade" id="pendingProjectDetailModal{{ $project->id }}" tabindex="-1" aria-labelledby="pendingProjectDetailModalLabel{{ $project->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="pendingProjectDetailModalLabel{{ $project->id }}">
                                                    Detail Permintaan Proyek: {{ $project->title }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Judul:</strong> {{ $project->title }}</p>
                                                <p><strong>Deskripsi:</strong></p>
                                                <div style="background-color: #f8f9fa; padding: 10px; border-radius: 5px;">
                                                    {!! $project->description !!}
                                                </div>
                                            </div>
                                            <!-- Tombol Setujui -->
                                            <div class="modal-footer">
                                                <form action="{{ route('admin.projects.approve', $project->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-success">Setujui</button>
                                                </form>
                                                
                                                <!-- Tombol Tolak: Trigger Modal Alasan -->
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectProjectModal{{ $project->id }}">
                                                    Tolak
                                                </button>
                                                
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Modal Alasan Penolakan -->
                                <div class="modal fade" id="rejectProjectModal{{ $project->id }}" tabindex="-1" aria-labelledby="rejectProjectModalLabel{{ $project->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('admin.projects.reject', $project->id) }}" method="POST">
                                            @csrf
                                            @method('POST')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="rejectProjectModalLabel{{ $project->id }}">Tolak Proyek: {{ $project->title }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="reason{{ $project->id }}" class="form-label">Alasan Penolakan (Opsional)</label>
                                                        <textarea name="reason" id="reason{{ $project->id }}" class="form-control" rows="4" placeholder="Tuliskan alasan penolakan..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-danger">Tolak Proyek</button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    
                    @if($projects->isEmpty())
                    <div class="alert alert-info">Belum ada proyek.</div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nama Proyek</th>
                                    <th>Leader</th>
                                    <th>Deskripsi Singkat</th>
                                    <th>Status Proyek</th>  {{-- kolom tambahan --}}
                                    <th>Status Pendaftaran</th>
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
                                    
                                    {{-- Status Proyek (approval_status / bisa sesuaikan) --}}
                                    <td>
                                        <span class="badge bg-{{ $project->approval_status === 'approved' ? 'success' : ($project->approval_status === 'rejected' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($project->approval_status) }}
                                        </span>
                                    </td>
                                    
                                    {{-- Status (open/closed) --}}
                                    <td>
                                        <span class="badge bg-{{ $project->status === 'open' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($project->status) }}
                                        </span>
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
                                        <!-- Tombol Detail -->
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#projectDetailModal{{ $project->id }}" title="Detail">
                                            <i class="ph-eye"></i>
                                        </button>
                                        
                                        {{-- Cek jika proyek punya kolaborator selain leader --}}
                                        @php
                                        $hasOtherCollaborators = $project->collaborators->where('status', 'approved')->where('user_id', '!=', $project->leader?->user_id)->isNotEmpty();
                                        @endphp
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
