@extends('layout.backend.main', ['activePage' => 'commodity.edit', 'titlePage' => 'Edit Komoditas'])

@section('title', 'Edit Komoditas')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="commodityEditForm" action="{{ route('admin.commodity.update', $commodity->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="key" class="form-label">Kategori (Key)</label>
                        <input type="text" name="key" class="form-control" required value="{{ old('key', $commodity->key) }}">
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Komoditas</label>
                        <input type="text" name="name" class="form-control" required value="{{ old('name', $commodity->name) }}">
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea name="description" id="description" class="form-control" rows="8">{!! old('description', $commodity->description) !!}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Gambar Baru (opsional)</label>
                        <input type="file" name="image" class="form-control">
                        @if($commodity->image)
                            <small class="text-muted d-block mt-1">
                                Gambar saat ini: <a href="{{ Storage::url($commodity->image) }}" target="_blank">Lihat</a>
                            </small>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
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
        filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
        filebrowserUploadMethod: 'form'
    });
</script>
@endpush
