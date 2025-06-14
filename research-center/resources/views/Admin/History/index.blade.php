@extends('admin.layouts.app')

@section('title', 'Sejarah')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($history)
        <div class="card">
        <div class="card-header">
            <h1 class="mb-0"><strong>Sejarah TSTH2</strong></h1>
        </div>
            <div class="card-body">
                {!! $history->content !!}
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.history.edit', $history->id) }}" class="btn btn-primary">Edit</a>

                <form action="{{ route('admin.history.destroy', $history->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus sejarah?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    @else
        <p>Belum ada sejarah. <a href="{{ route('admin.history.create') }}">Buat Sejarah</a></p>
    @endif
@endsection
