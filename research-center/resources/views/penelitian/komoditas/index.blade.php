@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layout.backend.main', ['activePage' => 'commodity.index', 'titlePage' => 'Komoditas'])

@section('title', 'Daftar Komoditas')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">DAFTAR KOMODITAS</h4>

                <a href="{{ route('admin.commodity.create') }}" class="btn btn-primary mb-3">
                    <i class="ph-plus-circle me-2"></i> Tambah Komoditas
                </a>

                @if(session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="15%">Kategori</th>
                                <th width="15%">Nama</th>
                                <th width="30%">Deskripsi</th>
                                <th width="20%">Gambar</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($commodities as $key => $group)
                                @foreach($group as $commodity)
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td>{{ $commodity->name }}</td>
                                        <td>{!! Str::limit(strip_tags($commodity->description), 80) !!}</td>
                                        <td>
                                            @if($commodity->image)
                                                <img src="{{ Storage::url($commodity->image) }}" alt="Gambar Komoditas" class="img-fluid" style="max-width: 100px;">
                                            @else
                                                <em class="text-muted">Tidak ada gambar</em>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.commodity.edit', $commodity->id) }}" class="btn btn-warning btn-sm mb-1">
                                                <i class="ph-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.commodity.destroy', $commodity->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus komoditas ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="ph-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data komoditas.</td>
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
