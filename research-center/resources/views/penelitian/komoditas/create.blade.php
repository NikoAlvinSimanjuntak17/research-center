@extends('layout.backend.main', ['activePage' => 'commodity.index', 'titlePage' => 'Tambah Komoditas'])

@section('title', 'Tambah Komoditas')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="commodityForm" action="{{ route('admin.commodity.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="key" class="form-label">Kategori (Key)</label>
                        <input type="text" name="key" class="form-control" required placeholder="Masukkan kategori" value="{{ old('key') }}">
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Komoditas</label>
                        <input type="text" name="name" class="form-control" required placeholder="Contoh: Ayam Broiler" value="{{ old('name') }}">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea name="description" id="description" class="form-control" rows="8">{!! old('description') !!}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar</label>
                        <input type="file" name="image" class="form-control">
                        <small class="text-muted">Opsional. Maksimal 2MB. Format: JPG/PNG</small>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.commodity.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- CKEditor 4 Full -->
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description', {
        removePlugins: 'exportpdf', // Hindari error export PDF
        filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
        filebrowserUploadMethod: 'form'
    });

    // Pastikan textarea sinkron sebelum submit
    document.getElementById('commodityForm').addEventListener('submit', function () {
        for (var instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
    });
</script>
@endpush
