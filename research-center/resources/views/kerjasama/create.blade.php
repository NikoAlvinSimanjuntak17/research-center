@extends('layout.backend.main', ['activePage' => 'partnership.create', 'titlePage' => 'Tambah Kerja Sama'])

@section('title', 'Tambah Kerja Sama')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="partnershipForm" action="{{ route('admin.partnership.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Mitra</label>
                        <input type="text" name="name" class="form-control" required placeholder="Contoh: PT Mitra Hebat" value="{{ old('name') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <input type="hidden" name="description" id="description">
                        <div id="document_editor_partnership">
                            <div class="document-editor-toolbar"></div>
                            <div class="document-editor-editable border p-3 rounded bg-white">
                                {!! old('description') !!}
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Logo</label>
                        <input type="file" name="image" class="form-control">
                        <small class="text-muted">Opsional. Maksimal 2MB. Format: JPG/PNG</small>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.partnership.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- CKEditor Decoupled CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/35.3.0/decoupled-document/ckeditor.js"></script>

<script>
    const CKEditorPartnership = function () {
        const initCKEditor = function () {
            if (typeof DecoupledEditor === 'undefined') {
                console.warn('CKEditor Decoupled belum dimuat.');
                return;
            }

            DecoupledEditor.create(document.querySelector('#document_editor_partnership .document-editor-editable'), {
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraf', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                    ]
                }
            }).then(editor => {
                window.editorPartnership = editor;

                const toolbarContainer = document.querySelector('#document_editor_partnership .document-editor-toolbar');
                toolbarContainer.appendChild(editor.ui.view.toolbar.element);

                const form = document.getElementById('partnershipForm');
                const hiddenInput = document.getElementById('description');

                form.addEventListener('submit', function () {
                    hiddenInput.value = editor.getData();
                });
            }).catch(error => {
                console.error('CKEditor error:', error);
            });
        };

        return {
            init: function () {
                initCKEditor();
            }
        };
    }();

    document.addEventListener('DOMContentLoaded', function () {
        CKEditorPartnership.init();
    });
</script>
@endpush
