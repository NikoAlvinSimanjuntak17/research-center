@extends('admin.layouts.app')
@section('title', 'Create Visi dan Misi')

@section('content')
    <h2>Create Visi & Misi</h2>

    <form id="visimisi-form" action="{{ route('admin.visimisi.store') }}" method="POST">
        @csrf

        <!-- VISI -->
        <div class="mb-3">
            <label for="visi" class="form-label">Visi</label>
            <div id="document_editor_visi">
                <div class="document-editor-toolbar"></div>
                <div class="document-editor-container">
                    <div class="document-editor-editable">{!! old('visi') !!}</div>
                </div>
            </div>
            <input type="hidden" name="visi" id="visi-hidden">
            @error('visi')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <!-- MISI -->
        <div class="mb-3">
            <label for="misi" class="form-label">Misi</label>
            <div id="document_editor_misi">
                <div class="document-editor-toolbar"></div>
                <div class="document-editor-container">
                    <div class="document-editor-editable">{!! old('misi') !!}</div>
                </div>
            </div>
            <input type="hidden" name="misi" id="misi-hidden">
            @error('misi')
                <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.visimisi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection

@push('scripts')
    <script src="{{ asset('admin/assets2/demo/pages/editor_ckeditor_visi.js') }}"></script>
@endpush