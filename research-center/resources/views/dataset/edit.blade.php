@extends('layout.backend.main', ['activePage' => 'dataset.edit', 'titlePage' => __('Edit Dataset')])
@section('title','Edit Dataset')
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Edit Dataset</h4>
                <a href="{{ route('dataset.index') }}" class="btn btn-outline-primary rounded-pill btn-sm mb-3">
                    <i class="ph-skip-back me-2"></i> Kembali
                </a>

                <form action="{{ route('dataset.update', $id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label>Judul Penelitian</label>
                        <input type="text" name="research_title" class="form-control" value="{{ $product->research_title }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Abstrak</label>
                        <textarea name="abstract" rows="4" class="form-control">{{ $product->abstract }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label>Kategori</label>
                        <select name="research_category_id" class="form-control" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $cat->id == $product->research_category_id ? 'selected' : '' }}>
                                    {{ $cat->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Peneliti</label>
                        <select name="researcher_id" class="form-control" required>
                            @foreach($researchers as $res)
                                <option value="{{ $res->id }}" {{ $res->id == $product->researcher_id ? 'selected' : '' }}>
                                    {{ \App\Models\User::find($res->user_id)->name ?? 'Unknown' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Tahun</label>
                        <input type="number" name="year" class="form-control" value="{{ $product->year }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>DOI</label>
                        <input type="text" name="doi" class="form-control" value="{{ $product->doi }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Harga (Rp)</label>
                        <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Ganti File Dataset (opsional)</label>
                        <input type="file" name="file_paths[]" class="form-control" multiple>
                    </div>

                    <div class="form-group mb-3">
                        <label>Ganti File Preview (opsional)</label>
                        <input type="file" name="preview_path" class="form-control">
                    </div>

                    <div class="form-group text-center">
                        <button class="btn btn-success" type="submit">
                            <i class="ph-paper-plane-tilt me-2"></i> Update Dataset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
