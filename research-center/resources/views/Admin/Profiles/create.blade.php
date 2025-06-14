@extends('admin.layouts.app')
@section('title', 'Tambah Profil Institusi')

@section('content')
    <h2 class="mb-4">Tambah Profil Institusi</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form id="profile-form" action="{{ route('admin.profiles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Kategori Umum (Key) --}}
                <div class="mb-3">
                    <label for="key" class="form-label">Kategori Umum (Key)</label>
                    @php $oldKey = old('key') @endphp
                    <select class="form-select" name="key" id="key" required>
                        @foreach($existingKeys as $existingKey)
                            <option value="{{ $existingKey }}" {{ $oldKey === $existingKey ? 'selected' : '' }}>
                                {{ $existingKey }}
                            </option>
                        @endforeach
                        @if($oldKey && !$existingKeys->contains($oldKey))
                            <option value="{{ $oldKey }}" selected>{{ $oldKey }}</option>
                        @endif
                    </select>
                    @error('key') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Judul --}}
                <div class="mb-3">
                    <label for="title" class="form-label">Judul Spesifik</label>
                    <input type="text" name="title" id="title" class="form-control"
                           value="{{ old('title') }}" required>
                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Deskripsi dengan CKEditor --}}
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    {{-- Hidden input untuk deskripsi --}}
                    <input type="hidden" name="description" id="description">
                    <input type="hidden" id="old-description" value="{{ old('description') }}">
                    {{-- Editor wrapper --}}
                    <div id="ckeditor-wrapper" class="border rounded p-2">
                        <div id="toolbar-container" class="mb-2"></div>
                        <div id="editor" class="document-editor-editable" style="min-height: 300px;"></div>
                    </div>
                    @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Gambar --}}
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar (Opsional)</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label for="active" class="form-label">Status</label>
                    <select name="active" id="active" class="form-select">
                        <option value="1" {{ old('active', 1) == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('active') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.profiles.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-success" id="submit-btn">Simpan</button>
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

                // Ambil old description dari input hidden
                const oldDescription = document.getElementById('old-description').value;
                if (oldDescription) {
                    editor.setData(oldDescription);
                }

                form.addEventListener('submit', function (e) {
                    const data = editor.getData().trim();
                    if (!data) {
                        e.preventDefault();
                        alert('Deskripsi tidak boleh kosong.');
                        return;
                    }
                    hiddenInput.value = data;
                    document.getElementById('submit-btn')?.setAttribute('disabled', true);
                });
            }).catch(error => {
                console.error('CKEditor initialization error:', error);
            });
        });
    </script>
@endpush
