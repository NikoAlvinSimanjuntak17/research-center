@extends('admin.layouts.app')
@section('title', 'Edit Profil Institusi')

@section('content')
    <h2 class="mb-4">Edit Profil Institusi</h2>

    <div class="card">
        <div class="card-body">
            <form id="profile-form" action="{{ route('admin.profiles.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Kategori Umum (Key) --}}
                <div class="mb-3">
                    <label for="key" class="form-label">Kategori Umum (Key)</label>
                    <select class="form-select" name="key" id="key" required>
                        @foreach($existingKeys as $existingKey)
                            <option value="{{ $existingKey }}" {{ (old('key', $profile->key) === $existingKey) ? 'selected' : '' }}>
                                {{ $existingKey }}
                            </option>
                        @endforeach
                        @if(!in_array($profile->key, $existingKeys->toArray()))
                            <option value="{{ $profile->key }}" selected>{{ $profile->key }}</option>
                        @endif
                    </select>
                    @error('key') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Judul --}}
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Spesifik</label>
                    <input type="text" name="title" id="title" class="form-control"
                           value="{{ old('title', $profile->title) }}" required>
                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <div id="ckeditor-wrapper" class="border rounded p-2">
                        <div id="toolbar-container" class="mb-2"></div>
                        <div id="editor" class="document-editor-editable">{!! old('description', $profile->description) !!}</div>
                    </div>
                    <input type="hidden" name="description" id="description">
                    @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Gambar --}}
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar (Opsional)</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    @if($profile->image)
                        <small class="d-block mt-1">Gambar saat ini: <a href="{{ asset('storage/' . $profile->image) }}" target="_blank">Lihat</a></small>
                    @endif
                    @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label for="active" class="form-label">Status</label>
                    <select name="active" id="active" class="form-select">
                        <option value="1" {{ old('active', $profile->active) == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('active', $profile->active) == '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('active') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.profiles.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .ck-editor__editable_inline {
            min-height: 300px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/decoupled-document/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
            $('#key').select2({
                tags: true,
                placeholder: 'Pilih atau ketik key baru...',
                allowClear: true,
                width: '100%'
            });

            const editorElement = document.querySelector('#editor');
            const toolbarContainer = document.querySelector('#toolbar-container');
            const hiddenInput = document.getElementById('description');
            const form = document.getElementById('profile-form');

            DecoupledEditor.create(editorElement, {
                placeholder: 'Tulis deskripsi profil institusi di sini...'
            }).then(editor => {
                toolbarContainer.appendChild(editor.ui.view.toolbar.element);
                window.editor = editor;

                form.addEventListener('submit', function (e) {
                    const data = editor.getData().trim();
                    if (!data) {
                        e.preventDefault();
                        alert('Deskripsi tidak boleh kosong.');
                        return;
                    }
                    hiddenInput.value = data;
                });
            }).catch(error => {
                console.error('CKEditor initialization error:', error);
            }); 
        });
    </script>
@endpush
