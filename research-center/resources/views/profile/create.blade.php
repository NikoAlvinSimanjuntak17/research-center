@extends('layout.backend.main', ['activePage' => 'news.create', 'titlePage' => __('Create Tentang Kami')])
@section('title','Create Tentang Kami')
@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <center>
                    <h4 class="card-title">FORM DATA TENTANG KAMI</h4>
                </center>
                <p align="left">
                    <a href="{{route('profile.index')}}" class="btn btn-outline-primary rounded-pill btn-sm"><i class="ph-skip-back me-2"></i> Kembali</a>
                </p>
                <form action="{{route('profile.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="judul">Judul Tentang Kami</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Judul Tentang Kami" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="key">Kata kunci profil</label>
                        <input type="text" class="form-control" id="key" name="key" placeholder="Kata Kunci" required>
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
                            <button type="submit" class="btn btn-success"><i class="ph-paper-plane-tilt me-2"></i>SIMPAN DATA TENTANG KAMI</button>
                            
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