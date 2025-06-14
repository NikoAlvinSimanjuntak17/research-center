@extends('Researchers.layouts.app')
@section('title', 'Edit Profil Peneliti')

@section('content')
    <h2>Edit Profil Peneliti</h2>

    @if(session('message'))
    <div class="alert alert-info">{{ session('message') }}</div>
    @endif

    <form action="{{ route('researcher.profile.update') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        {{-- Foto Profil --}}
        <div class="mb-3">
            <label for="image" class="form-label">Foto Profil</label><br>
            @if(auth()->user()->researcher?->image)
            <img src="{{ asset('storage/' . auth()->user()->researcher->image) }}" alt="Foto Profil" width="120" class="rounded mb-2">
            @endif
            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image">
            @error('image') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        {{-- Institusi --}}
<div class="mb-3">
    <label for="institution_id" class="form-label">Institusi</label>
    <select name="institution_id" id="institution_id" class="form-control @error('institution_id') is-invalid @enderror">
        <option value="">-- Pilih Institusi --</option>
        @foreach($institutions as $institution)
            <option value="{{ $institution->id }}"
                {{ old('institution_id', auth()->user()->researcher->department->institution_id ?? '') == $institution->id ? 'selected' : '' }}>
                {{ $institution->name }}
            </option>
        @endforeach
    </select>
    @error('institution_id') <div class="text-danger">{{ $message }}</div> @enderror
</div>

{{-- Departemen --}}
<div class="mb-3">
    <label for="department_id" class="form-label">Posisi</label>
    <select name="department_id" id="department_id" class="form-control @error('department_id') is-invalid @enderror">
        <option value="">-- Pilih Posisi --</option>
        @foreach($departments as $department)
            <option value="{{ $department->id }}"
                {{ old('department_id', auth()->user()->researcher->department_id ?? '') == $department->id ? 'selected' : '' }}>
                {{ $department->name }} ({{ $department->institution->name }})
            </option>
        @endforeach
    </select>
    @error('department_id') <div class="text-danger">{{ $message }}</div> @enderror
</div>


        {{-- ID Eksternal --}}
        @foreach(['orcid_id' => 'ORCID ID', 'scopus_id' => 'Scopus ID', 'garuda_id' => 'Garuda ID', 'googlescholar_id' => 'Google Scholar ID'] as $id => $label)
        <div class="mb-3">
            <label for="{{ $id }}" class="form-label">{{ $label }}</label>
            <input type="text" name="{{ $id }}" class="form-control @error($id) is-invalid @enderror" id="{{ $id }}" value="{{ old($id, auth()->user()->researcher->$id ?? '') }}">
            @error($id) <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        @endforeach

        {{-- Nomor HP --}}
        <div class="mb-3">
            <label for="phone" class="form-label">Nomor HP</label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{ old('phone', auth()->user()->researcher->phone ?? '') }}">
            @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- Biografi --}}
        <div class="mb-3">
            <label for="bio" class="form-label">Biografi Singkat</label>
            <textarea name="bio" id="bio" class="form-control @error('bio') is-invalid @enderror" rows="4">{{ old('bio', auth()->user()->researcher->bio ?? '') }}</textarea>
            @error('bio') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- Tombol Submit --}}
        <button type="submit" class="btn btn-primary">Simpan Profil</button>
        <a href="{{ route('researchers.dashboard') }}" class="btn btn-link">← Kembali ke Dashboard</a>
    </form>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const institutionSelect = document.getElementById('institution_id');
    const newInstitutionDiv = document.getElementById('new-institution-input');

    const departmentSelect = document.getElementById('department_id');
    const newDepartmentDiv = document.getElementById('new-department-input');

    institutionSelect.addEventListener('change', function () {
        if (this.value === 'other') {
            newInstitutionDiv.classList.remove('d-none');
        } else {
            newInstitutionDiv.classList.add('d-none');
        }
    });

    departmentSelect.addEventListener('change', function () {
        if (this.value === 'other') {
            newDepartmentDiv.classList.remove('d-none');
        } else {
            newDepartmentDiv.classList.add('d-none');
        }
    });
});
</script>
@endpush


@endsection
