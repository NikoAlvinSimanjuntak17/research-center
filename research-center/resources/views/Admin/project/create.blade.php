@extends('admin.layouts.app')
@section('title', 'Buat Proyek Baru')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h2 class="mb-4">Buat Proyek Baru</h2>

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

            {{-- Form Tambah Proyek --}}
            <form id="project" action="{{ route('admin.project.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Judul Proyek</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi Proyek</label>
                    {{-- Hidden input untuk menyimpan data dari CKEditor --}}
                    <input type="hidden" name="description" id="description">
                    <div id="document_editor_project">
                        <div class="document-editor-toolbar"></div>
                        <div class="document-editor-editable border p-3 rounded bg-white">
                            {!! old('description') !!}
                        </div>
                    </div>
                </div>
                <div class="mb-3">
    <label for="leader_id" class="form-label">Pilih Leader Proyek</label>
    <select class="form-select" name="leader_id" id="leader_id" required>
        <option value="">-- Pilih Peneliti --</option>
        @foreach($researchers as $researcher)
            @php
                $alreadyLeader = \App\Models\Project::where('leader_id', $researcher->id)->exists();
            @endphp
            <option value="{{ $researcher->id }}"
                {{ old('leader_id') == $researcher->id ? 'selected' : '' }}
                {{ $alreadyLeader ? 'disabled' : '' }}>
                {{ $researcher->user->name ?? 'Tanpa Nama' }} 
                ({{ optional(optional($researcher->department)->institution)->name ?? 'Tanpa Institusi' }})
                {{ $alreadyLeader ? '- Sudah menjadi Leader' : '' }}
            </option>
        @endforeach
    </select>
</div>


                    
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="open_at" class="form-label">Open Registration</label>
                        <input type="date" class="form-control" id="open_at" name="open_at" value="{{ old('open_at') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="close_at" class="form-label">End Registration</label>
                        <input type="date" class="form-control" id="close_at" name="close_at" value="{{ old('close_at') }}" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Buat Proyek</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const CKEditorProject = function() {
        const initCKEditorProject = function() {
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

                form.addEventListener('submit', function () {
                    hiddenInput.value = editor.getData();
                });
            })
            .catch(error => {
                console.error('CKEditor error:', error);
            });
        };

        return {
            init: function() {
                initCKEditorProject();
            }
        };
    }();

    document.addEventListener('DOMContentLoaded', function() {
        CKEditorProject.init();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Ambil tanggal hari ini dalam format yyyy-mm-dd
        const today = new Date().toISOString().split('T')[0];

        // Atur atribut min untuk input tanggal
        document.getElementById('open_at').setAttribute('min', today);
        document.getElementById('close_at').setAttribute('min', today);
    });
</script>
@endpush


