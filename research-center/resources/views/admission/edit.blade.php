@extends('layout.backend.main', ['activePage' => 'admission.update', 'titlePage' => __('Update Admisi')])
@section('title','Update Admisi')

@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <center>
                    <h4 class="card-title">DETAIL DATA ADMISI</h4>
                </center>

                <p align="left">
                    <a href="{{route('admission.index')}}" class="btn btn-outline-primary rounded-pill btn-sm"><i class="ph-skip-back me-2"></i> Kembali</a>
                </p>
                <form action="{{route('admission.update',['id'=>$id])}}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group mb-3">
                        <label for="judul">Judul</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Judul Admisi" value="{{ $admission->title }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="isi">Deskripsi</label>
                        {{-- <textarea class="form-control" id="description" name="description" rows="5" placeholder="Deskripsi Berita" required></textarea> --}}
                        <textarea name="editor" id="editor">
                            {{ $admission->description }}
                        </textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="file">File</label>
                        <input type="file" class="form-control" id="file" name="file">
                    </div>
                   
                    <div class="form-group mb-3">
                        <center>
                            <button type="submit" class="btn btn-success"><i class="ph-paper-plane-tilt me-2"></i>UPDATE DATA ADMISI</button>
                            
                        </center>
                    </div>   
                    

            </div>
        </div>
    </div>  
    {{-- <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script> --}}
    <script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
    {{-- <script src="{{ URL::asset('vuexy/js/ckeditor/ckeditor.js') }}"></script> --}}
    <script>
        CKEDITOR.replace('editor');
    </script>
@endsection