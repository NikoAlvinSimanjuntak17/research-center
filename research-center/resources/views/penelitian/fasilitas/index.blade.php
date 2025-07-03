@extends('layout.backend.main', ['activePage' => 'research-facility.index', 'titlePage' => 'Fasilitas Riset'])

@section('title', 'Fasilitas Riset')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">DAFTAR FASILITAS RISET</h4>

                <a href="{{ route('admin.research-facility.create') }}" class="btn btn-primary mb-3">
                    <i class="ph-plus-circle me-2"></i> Tambah Fasilitas
                </a>

                @if(session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Gambar</th>
                                <th class="text-center" width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($facilities as $facility)
                                <tr>
                                    <td>{{ $facility->name }}</td>
                                    <td>{{ Str::limit(strip_tags($facility->description), 50) }}</td>
                                    <td>
                                        @if($facility->image)
                                            <img src="{{ asset('storage' . $facility->image) }}" class="img-thumbnail" style="max-width: 100px;">
                                        @else
                                            <span class="text-muted">Tidak ada gambar</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.research-facility.show', $facility->id) }}" class="btn btn-info btn-sm">
                                            Detail
                                        </a>
                                        <a href="{{ route('admin.research-facility.edit', $facility->id) }}" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.research-facility.destroy', $facility->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus fasilitas ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada data fasilitas riset.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
