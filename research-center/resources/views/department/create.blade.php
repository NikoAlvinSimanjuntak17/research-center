
{{-- CREATE --}}
@extends('layout.backend.main', ['activePage' => 'department.create', 'titlePage' => __('Tambah Departemen')])
@section('title','Tambah Departemen')
@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3>Tambah Department</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.department.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Departemen</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="institution_id" class="form-label">Institusi</label>
                        <select name="institution_id" id="institution_id" class="form-select" required>
                            <option value="">-- Pilih Institusi --</option>
                            @foreach($institutions as $institution)
                                <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

