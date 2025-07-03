@extends('layout.backend.main', ['activePage' => 'institutions.create', 'titlePage' => 'Tambah Institusi'])

@section('title', 'Tambah Institusi')
@section('content')
<div class="row">
    <div class="col-xl-6 offset-xl-3">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">FORM TAMBAH INSTITUSI</h4>

                <form action="{{ route('admin.institutions.store') }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="name">Nama Institusi</label>
                        <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="address">Alamat</label>
                        <input type="text" name="address" id="address" class="form-control" value="{{ old('address') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="website">Website</label>
                        <input type="url" name="website" id="website" class="form-control" value="{{ old('website') }}">
                    </div>

                    <div class="form-group mb-3 text-center">
                        <button type="submit" class="btn btn-success rounded-pill">
                            <i class="ph-paper-plane-tilt me-2"></i> Simpan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
