@extends('admin.layouts.app')
@section('title', 'Tambah Slider')

@section('content')
    <h2 class="mb-4">Tambah Slider</h2>

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
            <form id="slider-form" action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Judul --}}
                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" name="title" id="title" class="form-control"
                           value="{{ old('title') }}" required>
                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                {{-- Deskripsi dengan CKEditor --}}
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <input type="hidden" name="description" id="description">
                    <input type="hidden" id="old-description" value="{{ old('description') }}">
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
                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-success" id="submit-btn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .ck-editor__editable_inline {
            min-height: 300px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/38.1.0/decoupled-document/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editorElement = document.querySelector('#editor');
            const toolbarContainer = document.querySelector('#toolbar-container');
            const hiddenInput = document.getElementById('description');
            const form = document.getElementById('slider-form');

            DecoupledEditor.create(editorElement, {
                placeholder: 'Tulis deskripsi slider di sini...'
            }).then(editor => {
                toolbarContainer.appendChild(editor.ui.view.toolbar.element);
                window.editor = editor;

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
