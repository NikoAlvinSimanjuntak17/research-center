@extends('layout.backend.main', ['activePage' => 'slider.update', 'titlePage' => __('Update Slider')])
@section('title','Update Slider')
@section('content')

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <center>
                    <h4 class="card-title">UBAH DATA SLIDER</h4>
                </center>

                <p align="left">
                    <a href="{{ route('slider.index') }}" class="btn btn-outline-primary rounded-pill btn-sm">
                        <i class="ph-skip-back me-2"></i> Kembali
                    </a>
                </p>

                <form action="{{ route('slider.update', ['id' => $id]) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf

                    <div class="form-group mb-3">
                        <label for="title">Judul Slider</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $slider->title }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Deskripsi</label>
                        <textarea name="editor" id="editor">{{ $slider->description }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="image">Gambar Slider</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        @if ($slider->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/sliders/' . $slider->image) }}" alt="Slider Image" width="150">
                            </div>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="active">Status Tampil</label>
                        <select class="form-control" name="active" id="active">
                            <option value="1" {{ $slider->active ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ !$slider->active ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <center>
                            <button type="submit" class="btn btn-success">
                                <i class="ph-paper-plane-tilt me-2"></i>UPDATE DATA SLIDER
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
