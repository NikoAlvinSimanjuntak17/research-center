@extends('layout.backend.main', ['activePage' => 'dataset.create', 'titlePage' => __('Tambah Dataset')])
@section('title','Tambah Dataset')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">FORM TAMBAH DATASET</h4>
                <a href="{{route('dataset.index')}}" class="btn btn-outline-primary mb-3">Kembali</a>

                <form action="{{ route('dataset.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label>Judul Riset</label>
                        <input type="text" class="form-control" name="research_title" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Deskripsi / Abstrak</label>
                        <textarea name="abstract" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label>Harga (Rp)</label>
                        <input type="number" class="form-control" name="price" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Kategori</label>
                        <select name="research_category_id" class="form-control" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="researcher_id">Peneliti (Researcher)</label>
                        <select name="researcher_id" id="researcher_id" class="form-control" required>
                            <option value="">-- Pilih Peneliti --</option>
                            @foreach ($researchers as $researcher)
                                <option value="{{ $researcher->id }}">{{ $researcher->name }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group mb-3">
                        <label>Tahun</label>
                        <input type="number" class="form-control" name="year" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>DOI</label>
                        <input type="text" class="form-control" name="doi" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>File Dataset (boleh lebih dari satu)</label>
                        <input type="file" class="form-control" name="file_paths[]" multiple required>
                    </div>

                    <div class="form-group mb-3">
                        <label>File Preview</label>
                        <input type="file" class="form-control" name="preview_path" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">SIMPAN DATA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
