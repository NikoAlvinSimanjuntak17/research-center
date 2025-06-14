@extends('admin.layouts.app')
@section('title', 'Detail Berita')

@section('content')
    <h2 class="mb-4">Detail Berita</h2>

    <div class="card">
        <div class="card-body">
            <h4>{{ $news->title }}</h4>

            <p class="text-muted mb-1">
                <strong>Kategori:</strong> {{ $news->category->name ?? '-' }}
            </p>

            <p class="text-muted mb-3">
                <strong>Status:</strong>
                @if ($news->active)
                    <span class="badge bg-success">Aktif</span>
                @else
                    <span class="badge bg-secondary">Tidak Aktif</span>
                @endif
            </p>

            @if ($news->image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $news->image) }}" width="300" class="img-thumbnail" alt="News Image">
                </div>
            @endif

            <div class="mb-3">
                {!! $news->description !!}
            </div>

            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
