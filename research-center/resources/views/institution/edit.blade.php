@extends('layout.backend.main', ['activePage' => 'institutions.edit', 'titlePage' => 'Edit Institusi'])

@section('title', 'Edit Institusi')
@section('content')
<div class="row">
    <div class="col-xl-6 offset-xl-3">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">EDIT DATA INSTITUSI</h4>

                <form action="{{ route('admin.institutions.update', $institution) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="name">Nama Institusi</label>
                        <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $institution->name) }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="address">Alamat</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $institution->address) }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="website">Website</label>
                        <input type="url" name="website" id="website" class="form-control" value="{{ old('website', $institution->website) }}">
                    </div>

                    <div class="form-group mb-3 text-center">
                        <button type="submit" class="btn btn-warning rounded-pill">
                            <i class="ph-check-square me-2"></i> Update
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
