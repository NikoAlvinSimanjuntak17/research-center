@extends('admin.layouts.app')
@section('title', 'Struktur Organisasi')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Tambah Struktur Organisasi</h3>
                    <a href="{{ route('admin.organization.index') }}" class="btn btn-primary">Kembali</a>
                </div>
                <div class="card-body">
                    <form id="organization-form" action="{{ route('admin.organization.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="photo">Gambar</label>
                            <input type="file" class="form-control" id="photo" name="photo" required>
                            @error('photo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" name="description" id="description">
                        <div id="document_editor_empty" class="document-editor">
                            <div class="document-editor-toolbar mb-2"></div>
                            <div class="document-editor-editable border rounded p-3" style="min-height: 300px;"></div>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success mt-3">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('admin/assets2/demo/pages/editor_ckeditor_document.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof DecoupledEditor === 'undefined') {
                console.warn('CKEditor DecoupledEditor tidak ditemukan.');
                return;
            }

            const editorContainer = document.querySelector('#document_editor_empty .document-editor-editable');
            const toolbarContainer = document.querySelector('#document_editor_empty .document-editor-toolbar');

            if (!editorContainer || !toolbarContainer) {
                console.error('Element CKEditor tidak ditemukan.');
                return;
            }

            DecoupledEditor
                .create(editorContainer, {
                    placeholder: 'Tulis deskripsi struktur organisasi di sini...',
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
                })
                .then(editor => {
                    window.editor = editor;
                    toolbarContainer.appendChild(editor.ui.view.toolbar.element);

                    const form = document.getElementById('organization-form');
                    const hiddenInput = document.getElementById('description');

                    form.addEventListener('submit', function (e) {
                        const data = editor.getData().trim();
                        if (!data) {
                            e.preventDefault();
                            alert('Deskripsi tidak boleh kosong.');
                            return;
                        }
                        hiddenInput.value = data;
                    });
                })
                .catch(error => {
                    console.error('CKEditor initialization error:', error);
                });
        });
    </script>
@endpush
