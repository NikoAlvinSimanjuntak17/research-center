@extends('admin.layouts.app')
@section('title', 'Edit Berita')

@section('content')
    <h2 class="mb-4">Edit Berita</h2>

    <div class="card">
        <div class="card-body">
            <form id="news-form" action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" class="form-control" name="title" value="{{ old('title', $news->title) }}" required>
                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="news_category_id" class="form-label">Kategori</label>
                    <select name="news_category_id" class="form-select">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('news_category_id', $news->news_category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('news_category_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Isi Berita</label>
                    <div id="ckeditor-wrapper" class="border rounded p-2">
                        <div id="toolbar-container" class="mb-2"></div>
                        <div id="editor" class="document-editor-editable" style="min-height: 300px;"></div>
                    </div>
                    <input type="hidden" name="description" id="description" data-old-content="{{ old('description', $news->description) }}">
                    @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Gambar (opsional)</label><br>
                    @if ($news->image)
                        <img src="{{ asset('storage/' . $news->image) }}" width="150" class="mb-2 rounded" alt="Image Preview">
                    @endif
                    <input type="file" class="form-control" name="image" accept="image/*">
                    @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3">
                    <label for="active" class="form-label">Status</label>
                    <select name="active" class="form-select">
                        <option value="1" {{ old('active', $news->active) == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('active', $news->active) == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('active') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Update</button>
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
            const form = document.getElementById('news-form');
            const hiddenInput = document.getElementById('description');

            DecoupledEditor.create(editorElement, {
                placeholder: 'Tulis isi berita di sini...',
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                    ]
                }
            }).then(editor => {
                window.editor = editor;
                toolbarContainer.appendChild(editor.ui.view.toolbar.element);

                // Isi CKEditor dengan old value atau value dari DB
                const oldContent = hiddenInput.dataset.oldContent;
                if (oldContent) editor.setData(oldContent);

                form.addEventListener('submit', function (e) {
                    const data = editor.getData().trim();
                    if (!data) {
                        e.preventDefault();
                        alert('Isi berita tidak boleh kosong.');
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
