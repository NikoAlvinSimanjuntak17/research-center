@extends('admin.layouts.app')

@section('title', 'Detail Peneliti')

@section('content')
        <h2 class="mb-4">Detail Peneliti</h2>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ $researcher->user->name }}</h5>
            </div>

            <div class="card-body">
                <p class="text-muted mb-4">Informasi lengkap mengenai peneliti.</p>

                <div class="row mb-2">
                    <div class="col-md-4 fw-semibold">Email:</div>
                    <div class="col-md-8">{{ $researcher->user->email }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4 fw-semibold">Institusi:</div>
                    <div class="col-md-8">{{ $researcher->department->institution->name ?? '-' }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4 fw-semibold">Departemen:</div>
                    <div class="col-md-8">{{ $researcher->department->name ?? '-' }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4 fw-semibold">Jabatan Akademik:</div>
                    <div class="col-md-8">{{ $researcher->academic_position ?? '-' }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4 fw-semibold">Keahlian:</div>
                    <div class="col-md-8">{{ $researcher->expertise ?? '-' }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4 fw-semibold">ORCID ID:</div>
                    <div class="col-md-8">{{ $researcher->orcid_id ?? '-' }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4 fw-semibold">Scopus ID:</div>
                    <div class="col-md-8">{{ $researcher->scopus_id ?? '-' }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4 fw-semibold">Garuda ID:</div>
                    <div class="col-md-8">{{ $researcher->garuda_id ?? '-' }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4 fw-semibold">Google Scholar ID:</div>
                    <div class="col-md-8">{{ $researcher->googlescholar_id ?? '-' }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4 fw-semibold">Telepon:</div>
                    <div class="col-md-8">{{ $researcher->phone ?? '-' }}</div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-4 fw-semibold">Biografi:</div>
                    <div class="col-md-8">{!! nl2br(e($researcher->bio)) ?? '-' !!}</div>
                </div>
            </div>

            <div class="card-footer text-end bg-light">
                <a href="{{ route('admin.researchers.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
</div>
@endsection
