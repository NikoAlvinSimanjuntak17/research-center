@extends('layout.backend.main', ['activePage' => 'department.index', 'titlePage' => 'Data Departemen'])

@section('title','Data Departemen')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">DATA DEPARTEMEN</h4>

                <p>
                    <a href="{{ route('admin.department.create') }}" class="btn btn-primary rounded-pill mb-3">
                        <i class="ph-plus-circle me-2"></i> Tambah Departemen
                    </a>
                </p>

                @if(session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Departemen</th>
                            <th>Institusi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departments as $dept)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $dept->name }}</td>
                                <td>{{ $dept->institution->name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.department.edit', $dept) }}" class="btn btn-sm btn-warning">
                                        <i class="ph-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.department.destroy', $dept->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin mau hapus?')">
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
                                <td colspan="4" class="text-center text-muted">Belum ada departemen terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
