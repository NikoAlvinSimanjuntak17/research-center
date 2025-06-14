@extends('admin.layouts.app')
@section('title', 'Edit Galeri')

@section('content')
    <h2 class="mb-4">Edit Galeri</h2>

    <div class="card">
        <div class="card-body">
            <form id="gallery-form" action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" class="form-control" name="title" value="{{ old('title', $gallery->title) }}" required>
                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <div id="ckeditor-wrapper" class="border rounded p-2">
                        <div id="toolbar-container" class="mb-2"></div>
                        <div id="editor" class="document-editor-editable" style="min-height: 300px;">{!! old('description', $gallery->description) !!}</div>
                    </div>
                    <input type="hidden" name="description" id="description">
                    @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof DecoupledEditor === 'undefined') {
                console.warn('CKEditor DecoupledEditor tidak ditemukan.');
                return;
            }

            const editorElement = document.querySelector('#editor');
            const toolbarContainer = document.querySelector('#toolbar-container');
            const form = document.getElementById('gallery-form');
            const hiddenInput = document.getElementById('description');

            DecoupledEditor.create(editorElement).then(editor => {
                window.editor = editor;
                toolbarContainer.appendChild(editor.ui.view.toolbar.element);

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
