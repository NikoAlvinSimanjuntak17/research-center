@extends('layout.backend.main', ['activePage' => 'slider.create', 'titlePage' => __('Create Slider')])
@section('title','Create Slider')
@section('content')

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <center>
                    <h4 class="card-title">TAMBAH DATA SLIDER</h4>
                </center>

                <p align="left">
                    <a href="{{ route('slider.index') }}" class="btn btn-outline-primary rounded-pill btn-sm">
                        <i class="ph-skip-back me-2"></i> Kembali
                    </a>
                </p>

                <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="title">Judul Slider</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Judul Slider" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Deskripsi (Opsional)</label>
                        <textarea name="editor" id="editor"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="image">Gambar Slider</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="active">Status Tampil</label>
                        <select class="form-control" name="active" id="active">
                            <option value="1" selected>Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <center>
                            <button type="submit" class="btn btn-success">
                                <i class="ph-paper-plane-tilt me-2"></i>SIMPAN DATA SLIDER
                            </button>
                        </center>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

{{-- CKEditor --}}
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>

@endsection
