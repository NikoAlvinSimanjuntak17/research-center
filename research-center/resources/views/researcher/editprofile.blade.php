@extends('layout.backend.main', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])
@section('title', 'Edit Profil Peneliti')

@section('content')
<div class="container mt-4">
    <h2>Edit Profil Peneliti</h2>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form action="{{ route('researcher.profile.updateProfile') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mt-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $researcher->name) }}">
        </div>

        <div class="form-group mt-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $researcher->email) }}">
        </div>


        <div class="form-group mt-3">
            <label>NIP</label>
            <input type="text" name="nip" class="form-control" value="{{ old('nip', $researcher->nip) }}">
        </div>

        <div class="form-group mt-3">
            <label>Department</label>
            <select name="department_id" class="form-control">
                <option value="">-- Pilih Departemen --</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ $researcher->department_id == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }} ({{ $dept->institution->name ?? '-' }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-3">
            <label>ORCID ID</label>
            <input type="text" name="orcid_id" class="form-control" value="{{ old('orcid_id', $researcher->orcid_id) }}">
        </div>

        <div class="form-group mt-3">
            <label>Scopus ID</label>
            <input type="text" name="scopus_id" class="form-control" value="{{ old('scopus_id', $researcher->scopus_id) }}">
        </div>

        <div class="form-group mt-3">
            <label>Garuda ID</label>
            <input type="text" name="garuda_id" class="form-control" value="{{ old('garuda_id', $researcher->garuda_id) }}">
        </div>

        <div class="form-group mt-3">
            <label>Google Scholar ID</label>
            <input type="text" name="googlescholar_id" class="form-control" value="{{ old('googlescholar_id', $researcher->googlescholar_id) }}">
        </div>

        <div class="form-group mt-3">
            <label>Gelar S1</label>
            <input type="text" name="bachelor_degree" class="form-control" value="{{ old('bachelor_degree', $researcher->bachelor_degree) }}">
        </div>

        <div class="form-group mt-3">
            <label>Gelar S2</label>
            <input type="text" name="master_degree" class="form-control" value="{{ old('master_degree', $researcher->master_degree) }}">
        </div>

        <div class="form-group mt-3">
            <label>Gelar S3</label>
            <input type="text" name="doctor_degree" class="form-control" value="{{ old('doctor_degree', $researcher->doctor_degree) }}">
        </div>

        <div class="form-group mt-3">
            <label>Pengalaman</label>
            <textarea name="experiences" class="form-control">{{ old('experiences', $researcher->experiences) }}</textarea>
        </div>

        <div class="form-group mt-3">
            <label>Jumlah Sitasi</label>
            <input type="number" name="citation_count" class="form-control" value="{{ old('citation_count', $researcher->citation_count) }}">
        </div>

        <div class="form-group mt-3">
            <label>Foto/Logo</label><br>
            @if($researcher->image)
                <img src="{{ asset('storage/' . $researcher->image) }}" width="100" class="mb-2">
            @endif
            <input type="file" name="image" class="form-control-file">
        </div>

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
