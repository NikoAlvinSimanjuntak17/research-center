@extends('admin.layouts.app')

@section('title', 'Detail Publikasi')

@section('content')
    <h1 class="mb-4 text-2xl font-semibold">Detail Publikasi</h1>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ $publication->title ?? '-' }}</h5>
        </div>

        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th width="20%">Tahun</th>
                    <td>{{ $publication->year ?? 'Tidak diketahui' }}</td>
                </tr>
                <tr>
                    <th>Jenis</th>
                    <td>
                        @if ($publication->type)
                            <span class="badge bg-info text-dark">{{ ucfirst($publication->type) }}</span>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
    <th>Penulis</th>
    <td>
        @if($publication->researchers->isEmpty())
            -
        @else
            @foreach ($publication->researchers as $researcher)
                {{ $researcher->user->name ?? '-' }}@if(!$loop->last), @endif
            @endforeach
        @endif
    </td>
</tr>

                <tr>
                    <th>Source</th>
                    <td>{{ ucfirst($publication->source) ?? '-' }}</td>
                </tr>
                @if ($publication->doi)
                <tr>
                    <th>DOI</th>
                    <td>
                        <a href="https://doi.org/{{ $publication->doi }}" target="_blank" rel="noopener noreferrer">
                            {{ $publication->doi }}
                        </a>
                    </td>
                </tr>
                @endif
                <tr>
                    <th>Abstrak</th>
                    <td class="text-justify">
                        {{ $publication->abstract ?? 'Tidak ada abstrak yang tersedia.' }}
                    </td>
                </tr>
            </table>
        </div>

        <div class="card-footer bg-light text-end">
            <a href="{{ route('admin.publications.index') }}" class="btn btn-secondary">
                <i class="ph-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
@endsection
