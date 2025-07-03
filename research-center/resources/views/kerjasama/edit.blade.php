@extends('layout.backend.main', ['activePage' => 'partnership.edit', 'titlePage' => 'Edit Kerja Sama'])

@section('title', 'Edit Kerja Sama')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form id="partnershipEditForm" action="{{ route('admin.partnership.update', $partnership->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Mitra</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $partnership->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <input type="hidden" name="description" id="description">
                        <div id="document_editor_partnership">
                            <div class="document-editor-toolbar"></div>
                            <div class="document-editor-editable border p-3 rounded bg-white">
                                {!! old('description', $partnership->description) !!}
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Logo (opsional)</label>
                        <input type="file" name="image" class="form-control">
                        @if($partnership->image)
                            <small class="text-muted d-block mt-1">
                                Logo saat ini: <a href="{{ Storage::url($partnership->image) }}" target="_blank">Lihat Gambar</a>
                            </small>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
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
    const CKEditorPartnershipEdit = function () {
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
                window.editorPartnershipEdit = editor;

                const toolbarContainer = document.querySelector('#document_editor_partnership .document-editor-toolbar');
                toolbarContainer.appendChild(editor.ui.view.toolbar.element);

                const form = document.getElementById('partnershipEditForm');
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
        CKEditorPartnershipEdit.init();
    });
</script>
@endpush
