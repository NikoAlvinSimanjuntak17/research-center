@extends('admin.layouts.app')
@section('title', 'Edit Visi dan Misi')

@section('content')
    <h2>Edit Visi & Misi</h2>

    <form id="visimisi-form" action="{{ route('admin.visimisi.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Visi Editor -->
        <div class="mb-3">
            <label for="visi" class="form-label">Visi</label>
            <div id="document_editor_visi">
                <div class="document-editor-toolbar"></div>
                <div class="document-editor-container">
                    <div class="document-editor-editable" id="visi" name="visi">
                        {!! old('visi', $visi?->content) !!}
                    </div>
                </div>
            </div>
            <!-- Hidden input for form submission -->
            <input type="hidden" name="visi" id="visi-hidden">
        </div>

        <!-- Misi Editor -->
        <div class="mb-3">
            <label for="misi" class="form-label">Misi</label>
            <div id="document_editor_misi">
                <div class="document-editor-toolbar"></div>
                <div class="document-editor-container">
                    <div class="document-editor-editable" id="misi" name="misi">
                        {!! old('misi', $misi?->content) !!}
                    </div>
                </div>
            </div>
            <!-- Hidden input for form submission -->
            <input type="hidden" name="misi" id="misi-hidden">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.visimisi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('admin/assets2/demo/pages/editor_ckeditor_visi.js') }}"></script>

    <script>
        // Menangani pengambilan data dari editor dan mengisinya ke input hidden
        document.getElementById('visimisi-form').addEventListener('submit', function (e) {
            // Mengambil data dari editor visi
            document.getElementById('visi-hidden').value = document.getElementById('visi').innerHTML;

            // Mengambil data dari editor misi
            document.getElementById('misi-hidden').value = document.getElementById('misi').innerHTML;
        });
    </script>
@endpush
