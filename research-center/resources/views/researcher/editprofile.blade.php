@extends('layout.backend.main', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])
@section('title', 'Edit Profil Peneliti')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Profil Peneliti</h4>
        </div>

        <div class="card-body">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            {{-- Error global --}}
            @if ($errors->has('error'))
                <div class="alert alert-danger">
                    {{ $errors->first('error') }}
                </div>
            @endif

            <form action="{{ route('researcher.profile.updateProfile') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nama --}}
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $researcher->name) }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Email --}}
                <div class="form-group mt-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $researcher->email) }}">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- NIP --}}
                <div class="form-group mt-3">
                    <label>NIP</label>
                    <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror"
                        value="{{ old('nip', $researcher->nip) }}">
                    @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Department --}}
                <div class="form-group mt-3">
                    <label>Department</label>
                    <select name="department_id" class="form-control @error('department_id') is-invalid @enderror">
                        <option value="">-- Pilih Departemen --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id', $researcher->department_id) == $dept->id ? 'selected' : '' }}>
                                {{ $dept->name }} ({{ $dept->institution->name ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                    @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- ORCID --}}
                <div class="form-group mt-3">
                    <label>ORCID ID</label>
                    <input type="text" name="orcid_id" class="form-control @error('orcid_id') is-invalid @enderror"
                        value="{{ old('orcid_id', $researcher->orcid_id) }}">
                    @error('orcid_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Scopus --}}
                <div class="form-group mt-3">
                    <label>Scopus ID</label>
                    <input type="text" name="scopus_id" class="form-control @error('scopus_id') is-invalid @enderror"
                        value="{{ old('scopus_id', $researcher->scopus_id) }}">
                    @error('scopus_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Garuda --}}
                <div class="form-group mt-3">
                    <label>Garuda ID</label>
                    <input type="text" name="garuda_id" class="form-control"
                        value="{{ old('garuda_id', $researcher->garuda_id) }}">
                </div>

                {{-- Google Scholar --}}
                <div class="form-group mt-3">
                    <label>Google Scholar ID</label>
                    <input type="text" name="googlescholar_id" class="form-control @error('googlescholar_id') is-invalid @enderror"
                        value="{{ old('googlescholar_id', $researcher->googlescholar_id) }}">
                    @error('googlescholar_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Gelar Pendidikan --}}
                <div class="form-group mt-3">
                    <label>Gelar S1</label>
                    <input type="text" name="bachelor_degree" class="form-control"
                        value="{{ old('bachelor_degree', $researcher->bachelor_degree) }}">
                </div>

                <div class="form-group mt-3">
                    <label>Gelar S2</label>
                    <input type="text" name="master_degree" class="form-control"
                        value="{{ old('master_degree', $researcher->master_degree) }}">
                </div>

                <div class="form-group mt-3">
                    <label>Gelar S3</label>
                    <input type="text" name="doctor_degree" class="form-control"
                        value="{{ old('doctor_degree', $researcher->doctor_degree) }}">
                </div>

                {{-- Pengalaman --}}
                <div class="form-group mt-3">
                    <label>Pengalaman</label>
                    <textarea name="experiences" class="form-control">{{ old('experiences', $researcher->experiences) }}</textarea>
                </div>

                {{-- Jumlah Sitasi --}}
                <div class="form-group mt-3">
                    <label>Jumlah Sitasi</label>
                    <input type="number" name="citation_count" class="form-control"
                        value="{{ old('citation_count', $researcher->citation_count) }}">
                </div>

                {{-- Foto --}}
                <div class="form-group mt-3">
                    <label>Foto/Logo</label><br>
                    @if($researcher->image)
                        <img src="{{ asset('storage/' . $researcher->image) }}" width="100" class="mb-2">
                    @endif
                    <input type="file" name="image" class="form-control-file">
                </div>

                {{-- Tombol Submit --}}
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection