@extends('layout.backend.main', ['activePage' => 'researchers.create', 'titlePage' => __('Create Peneliti')])

@section('title', 'Daftar Publikasi')

@section('content')

{{-- Tabel Publikasi --}}
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
                <h1 class="text-2xl font-semibold mb-4">Daftar Publikasi</h1>
                <table class="table datatable-basic">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Source</th>
                            <th>Tahun</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($publications as $pub)
                        <tr>
                            <td>{{ $pub->title }}</td>
                            <td class="capitalize">{{ $pub->source }}</td>
                            <td>{{ $pub->publication_date?->year ?? 'Tidak diketahui' }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <div class="dropdown">
                                        <a href="#" class="text-body" data-bs-toggle="dropdown">
                                            <i class="ph-list"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="{{ route('admin.publications.show', $pub->id) }}" class="dropdown-item">
                                                <i class="ph-eye me-2"></i> Detail
                                            </a>
                                            {{-- Tambahin aksi lain kalau mau, misal edit/hapus --}}
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">Tidak ada publikasi ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $publications->onEachSide(1)->links('pagination::bootstrap-4') }}
                </div>
                
            </div>
        </div>
    </div>
        @endsection
        