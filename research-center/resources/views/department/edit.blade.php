{{-- EDIT DEPARTEMEN --}}
@extends('layout.backend.main', ['activePage' => 'department.edit', 'titlePage' => 'Edit Departemen'])

@section('title', 'Edit Departemen')
@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-4">Edit Departemen</h4>

                <form action="{{ route('admin.department.update', $department) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Departemen</label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               name="name" 
                               id="name" 
                               value="{{ old('name', $department->name) }}" 
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="institution_id" class="form-label">Institusi</label>
                        <select name="institution_id" 
                                id="institution_id" 
                                class="form-select @error('institution_id') is-invalid @enderror" 
                                required>
                            <option value="">-- Pilih Institusi --</option>
                            @foreach($institutions as $institution)
                                <option value="{{ $institution->id }}"
                                    {{ old('institution_id', $department->institution_id) == $institution->id ? 'selected' : '' }}>
                                    {{ $institution->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('institution_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary rounded-pill">
                        <i class="ph-check me-2"></i> Update
                    </button>
                    <a href="{{ route('admin.department.index') }}" class="btn btn-light border ms-2">Batal</a>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
