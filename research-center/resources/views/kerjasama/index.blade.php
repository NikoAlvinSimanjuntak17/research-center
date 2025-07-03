@extends('layout.backend.main', ['activePage' => 'partnership.index', 'titlePage' => 'Kerja Sama'])

@section('title', 'Daftar Kerja Sama')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">DAFTAR KERJA SAMA</h4>

                <a href="{{ route('admin.partnership.create') }}" class="btn btn-primary mb-3">
                    <i class="ph-plus-circle me-2"></i> Tambah Kerja Sama
                </a>

                @if(session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Mitra</th>
                            <th>Deskripsi</th>
                            <th>Logo</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($partnerships as $partner)
                            <tr>
                                <td>{{ $partner->name }}</td>
                                <td>{!!  Str::limit($partner->description, 1000) !!}</td>
                                <td>
                                    @if($partner->image)
                                        <img src="{{ asset('storage/' . $partner->image) }}" width="100">
                                    @else
                                        <em class="text-muted">Tidak ada logo</em>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.partnership.edit', $partner->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.partnership.destroy', $partner->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus kerja sama ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
    