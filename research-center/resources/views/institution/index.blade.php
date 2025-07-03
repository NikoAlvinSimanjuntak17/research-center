@extends('layout.backend.main', ['activePage' => 'institutions.index', 'titlePage' => 'Daftar Institusi'])

@section('title', 'Daftar Institusi')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">DAFTAR INSTITUSI</h4>

                <p>
                    <a href="{{ route('admin.institutions.create') }}" class="btn btn-primary rounded-pill">
                        <i class="ph-plus-circle me-2"></i> Tambah Institusi
                    </a>
                </p>

                @if(session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Website</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($institutions as $institution)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $institution->name }}</td>
                                <td>{{ $institution->address ?? '-' }}</td>
                                <td>
                                    @if($institution->website)
                                        <a href="{{ $institution->website }}" target="_blank">{{ $institution->website }}</a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.institutions.edit', $institution) }}" class="btn btn-sm btn-warning">
                                        <i class="ph-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.institutions.destroy', $institution) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin mau hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="ph-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada institusi terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
