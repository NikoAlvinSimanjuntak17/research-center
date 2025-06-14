@extends('admin.layouts.app')
@section('title', 'Tambah Galeri')

@section('content')
    <h2 class="mb-4">Tambah Galeri</h2>

    <div class="card">
        <div class="card-body">
            <form id="gallery-form" action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <div id="ckeditor-wrapper" class="border rounded p-2">
                        <div id="toolbar-container" class="mb-2"></div>
                        <div id="editor" class="document-editor-editable" style="min-height: 300px;"></div>
                    </div>
                    <input type="hidden" name="description" id="description">
                    @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
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

            DecoupledEditor.create(editorElement, {
                placeholder: 'Tulis deskripsi galeri di sini...',
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                        { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                        { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                        { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                    ]
                }
            }).then(editor => {
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

                // Jika sebelumnya ada old('description'), isi ke editor
                const oldContent = `{!! old('description') !!}`;
                if (oldContent) editor.setData(oldContent);
            }).catch(error => {
                console.error('CKEditor initialization error:', error);
            });
        });
    </script>
@endpush
