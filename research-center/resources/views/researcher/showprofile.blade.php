@extends('layout.backend.main', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('title', 'Profil Peneliti')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Profil Peneliti</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                {{-- FOTO PROFIL --}}
                <div class="col-md-3 text-center mb-3">
                    @if($researcher->image)
                        <img src="{{ asset('storage/' . $researcher->image) }}" alt="Foto Peneliti" class="img-fluid rounded" style="max-height: 200px;">
                    @else
                        <img src="{{ asset('default/user.png') }}" alt="Default" class="img-fluid rounded" style="max-height: 200px;">
                    @endif
                </div>

                {{-- DETAIL INFORMASI --}}
                <div class="col-md-9">
                    <table class="table table-borderless">
                        <tr>
                            <th>Nama</th>
                            <td>{{ $researcher->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $researcher->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jabatan Akademik</th>
                            <td>{{ $researcher->position ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>NIP</th>
                            <td>{{ $researcher->nip ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Departemen</th>
                            <td>{{ $researcher->department->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Pendidikan</th>
                            <td>
                                <ul class="mb-0">
                                    <li>S1: {{ $researcher->bachelor_degree ?? '-' }}</li>
                                    <li>S2: {{ $researcher->master_degree ?? '-' }}</li>
                                    <li>S3: {{ $researcher->doctor_degree ?? '-' }}</li>
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <th>Pengalaman</th>
                            <td>{!! nl2br(e($researcher->experiences ?? '-')) !!}</td>
                        </tr>
                        <tr>
                            <th>Citation Count</th>
                            <td>{{ $researcher->citation_count ?? 0 }}</td>
                        </tr>
                        <tr>
                            <th>ORCID</th>
                            <td>{{ $researcher->orcid_id ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Scopus</th>
                            <td>{{ $researcher->scopus_id ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Garuda</th>
                            <td>{{ $researcher->garuda_id ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Google Scholar</th>
                            <td>{{ $researcher->googlescholar_id ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($researcher->active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <a href="{{ route('researcher.profile.edit') }}" class="btn btn-warning mt-3">Edit Profil</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
