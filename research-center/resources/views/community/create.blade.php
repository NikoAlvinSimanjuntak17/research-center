@extends('layout.backend.main', ['activePage' => 'community.create', 'titlePage' => __('Create Community')])
@section('title','Create Community')
@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <center>
                    <h4 class="card-title">FORM KOMUNITAS</h4>
                </center>
                <p align="left">
                    <a href="{{route('community.index')}}" class="btn btn-outline-primary rounded-pill btn-sm"><i class="ph-skip-back me-2"></i> Kembali</a>
                </p>
                <form action="{{route('community.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="judul">Nama Komunitas</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Nama Komunitas" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="isi">Deskripsi</label>
                        {{-- <textarea class="form-control" id="description" name="description" rows="5" placeholder="Deskripsi Berita" required></textarea> --}}
                        <textarea name="editor" id="editor"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="gambar">Gambar</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>
                   
                    <div class="form-group mb-3">
                        <center>
                            <button type="submit" class="btn btn-success"><i class="ph-paper-plane-tilt me-2"></i>SIMPAN DATA KOMUNITAS</button>
                            
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