@extends('layout.backend.main', ['activePage' => 'researchers.create', 'titlePage' => __('Create Peneliti')])
@section('title','Create Peneliti')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <center>
                    <h4 class="card-title">DATA PENELITI</h4>
                </center>
                <p align="left">
                    <a href="{{ route('researcher.index') }}" class="btn btn-outline-primary rounded-pill btn-sm">
                        <i class="ph-skip-back me-2"></i> Kembali
                    </a>
                </p>

                <form action="{{ route('researcher.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Peneliti" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">Email Peneliti</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Peneliti" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Kata Sandi</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Kata Sandi" required>
                    </div>

                    <div class="form-group mb-3">
                        <center>
                            <button type="submit" class="btn btn-success">
                                <i class="ph-paper-plane-tilt me-2"></i>SIMPAN DATA PENELITI
                            </button>
                        </center>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
