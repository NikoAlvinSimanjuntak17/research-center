@extends('admin.layouts.app')

@section('content')
<div class="content">
    <!-- Content area -->
    <div class="content pt-0">

        <div class="card">
            <div class="card-header">
            <h1 class="mb-0"><strong>Tambah Sejarah TSTH2</strong></h1>
            </div>
            <div class="card-body">
                <form id="history-form" action="{{ route('admin.history.store') }}" method="POST" novalidate>
                    @csrf

                    <!-- Hidden input buat content -->
                    <input type="hidden" name="content" id="content">

                    <div id="document_editor_history">
                        <div class="document-editor-toolbar"></div>
                        <div class="document-editor-editable">
                            {!! old('content') !!}
                        </div>
                    </div>

                    <!-- Tampilkan error kalau ada -->
                    @error('content')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror

                    <div class="text-end mt-4">
                        <a href="{{ route('admin.history.index') }}" class="btn btn-light">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!-- /content area -->

</div>
@endsection