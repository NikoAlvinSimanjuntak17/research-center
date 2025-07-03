<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Status Pendaftaran</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->title }}</td>
                    <td>{!! Str::limit(strip_tags($project->description), 100) !!}</td>
                    <td>
                        <span class="badge bg-{{ $project->status === 'open' ? 'success' : 'secondary' }}">
                            {{ ucfirst($project->status) }}
                        </span>
                    </td>
                    <td>
                        {{ $project->open_at?->format('d M Y') ?? '-' }} -
                        {{ $project->close_at?->format('d M Y') ?? '-' }}
                    </td>
                    <td>
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                            data-bs-target="#projectDetailModal{{ $project->id }}">
                            Detail
                        </button>

                        @if ($canJoin && $project->status === 'open')
                            <form action="{{ route('researcher.projects.join.request', $project->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <button class="btn btn-success btn-sm"
                                    onclick="return confirm('Yakin ingin bergabung?')">Join</button>
                            </form>
                        @endif
                    </td>
                </tr>

                {{-- Modal Detail --}}
                <div class="modal fade" id="projectDetailModal{{ $project->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Proyek: {{ $project->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Deskripsi:</strong></p>
                                <div class="p-2 bg-light rounded">{!! $project->description !!}</div>
                                <hr>
                                <p><strong>Leader:</strong> {{ $project->leader?->user?->name ?? '-' }}</p>
                                <p><strong>Kolaborator:</strong></p>
                                <ul>
                                    @forelse ($project->collaborators->where('status', 'approved') as $collab)
                                        <li>{{ $collab->user->name ?? '-' }}</li>
                                    @empty
                                        <li><em>Belum ada kolaborator</em></li>
                                    @endforelse
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                                @if ($canJoin && $project->status === 'open')
                                    <form action="{{ route('researcher.projects.join.request', $project->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button class="btn btn-success">Join</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        </tbody>
    </table>
</div>