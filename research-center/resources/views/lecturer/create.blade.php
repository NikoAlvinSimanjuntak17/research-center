@extends('layout.backend.main', ['activePage' => 'lecturer.create', 'titlePage' => __('Create Dosen')])
@section('title','Create Dosen')
@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <center>
                    <h4 class="card-title">FORM DATA DOSEN</h4>
                </center>
                <p align="left">
                    <a href="{{route('lecturer.index')}}" class="btn btn-outline-primary rounded-pill btn-sm"><i class="ph-skip-back me-2"></i> Kembali</a>
                </p>
                <form action="{{route('lecturer.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="judul">Nama Lengkap Dosen (<i>Beserta Gelar</i>)</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="judul">Pendidikan Terakhir</label>
                        <input type="text" class="form-control" id="last_education" name="last_education" required>
                    </div>

                     <div class="form-group mb-3">
                        <label for="judul">Bidang</label>
                        <input type="text" class="form-control" id="expertise" name="expertise" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="gambar">Foto Dosen</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                   
                    <div class="form-group mb-3">
                        <center>
                            <button type="submit" class="btn btn-success"><i class="ph-paper-plane-tilt me-2"></i>SIMPAN DATA DOSEN</button>
                            
                        </center>
                    </div>   
                    

            </div>
        </div>
    </div>  
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>
@endsection