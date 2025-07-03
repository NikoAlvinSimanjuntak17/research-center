@extends('layout.backend.main', ['activePage' => 'research-facilities.edit', 'titlePage' => 'Edit Fasilitas'])

@section('title', 'Edit Fasilitas Riset')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="editFacilityForm" action="{{ route('admin.research-facility.update', $facility->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Fasilitas</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $facility->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea name="description" id="description" class="form-control" rows="8">{!! old('description', $facility->description) !!}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Ganti Gambar (Opsional)</label>
                        <input type="file" name="image" class="form-control">
                        @if($facility->image)
                            <small class="text-muted d-block mt-1">Gambar saat ini: 
                                <a href="{{ Storage::url($facility->image) }}" target="_blank">Lihat Gambar</a>
                            </small>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.research-facility.index') }}" class="btn btn-secondary">Batal</a>
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
        removePlugins: 'exportpdf',
        filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
        filebrowserUploadMethod: 'form'
    });

    document.getElementById('editFacilityForm').addEventListener('submit', function () {
        for (var instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
    });
</script>
@endpush
