@extends('layout.backend.main', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])
@section('title', 'Edit Proyek')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h2 class="mb-4">Edit Proyek</h2>

            {{-- Pesan Sukses --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Validasi Error --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Edit Proyek --}}
            <form id="project" action="{{ route('researcher.projects.update', $project->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Judul Proyek</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $project->title) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi Proyek</label>
                    <input type="hidden" name="description" id="description">
                    <div id="document_editor_project">
                        <div class="document-editor-toolbar"></div>
                        <div class="document-editor-editable border p-3 rounded bg-white">
                            {!! old('description', $project->description) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="open_at" class="form-label">Open Registration</label>
                        <input type="date" class="form-control" id="open_at" name="open_at"
                            value="{{ old('open_at', $project->open_at ? $project->open_at->format('Y-m-d') : '') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="close_at" class="form-label">End Registration</label>
                        <input type="date" class="form-control" id="close_at" name="close_at"
                            value="{{ old('close_at', $project->close_at ? $project->close_at->format('Y-m-d') : '') }}" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Perbarui Proyek</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/decoupled-document/ckeditor.js"></script>
<script>
    const CKEditorProject = (() => {
        const init = () => {
            if (typeof DecoupledEditor === 'undefined') {
                console.warn('CKEditor Decoupled belum dimuat.');
                return;
            }

            DecoupledEditor.create(document.querySelector('#document_editor_project .document-editor-editable'), {
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraf', class: 'ck-heading_paragraph' },
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
                window.editorProject = editor;
                const toolbarContainer = document.querySelector('#document_editor_project .document-editor-toolbar');
                toolbarContainer.appendChild(editor.ui.view.toolbar.element);

                const form = document.getElementById('project');
                const hiddenInput = document.getElementById('description');
                const openAt = document.getElementById('open_at');
                const closeAt = document.getElementById('close_at');

                form.addEventListener('submit', function (e) {
                    const content = editor.getData().trim();
                    hiddenInput.value = content;

                    const openDate = new Date(openAt.value);
                    const closeDate = new Date(closeAt.value);

                    // Validasi deskripsi kosong
                    if (!content) {
                        e.preventDefault();
                        alert('Deskripsi proyek tidak boleh kosong.');
                        return;
                    }

                    // Validasi tanggal tidak boleh sama
                    if (openDate.toDateString() === closeDate.toDateString()) {
                        e.preventDefault();
                        alert('Tanggal mulai dan tanggal selesai tidak boleh sama.');
                        return;
                    }

                    // Validasi tanggal selesai tidak boleh sebelum tanggal mulai
                    if (closeDate < openDate) {
                        e.preventDefault();
                        alert('Tanggal selesai tidak boleh lebih awal dari tanggal mulai.');
                        return;
                    }
                });
            })
            .catch(error => {
                console.error('CKEditor error:', error);
            });
        };
        return { init };
    })();

    document.addEventListener('DOMContentLoaded', function () {
        CKEditorProject.init();

        const today = new Date().toISOString().split('T')[0];
        const openAt = document.getElementById('open_at');
        const closeAt = document.getElementById('close_at');

        if (openAt && !openAt.value) openAt.setAttribute('min', today);
        if (closeAt && !closeAt.value) closeAt.setAttribute('min', today);

        openAt.addEventListener('change', function () {
            if (closeAt) closeAt.setAttribute('min', this.value);
        });

        // Atur ulang min close_at jika open_at sudah ada nilainya (untuk edit form)
        if (openAt && openAt.value) {
            closeAt.setAttribute('min', openAt.value);
        }
    });
</script>
@endpush
