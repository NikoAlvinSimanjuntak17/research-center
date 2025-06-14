@extends('admin.layouts.app')
@section('title', 'Visi dan Misi')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Visi dan Misi</h5>
        </div>

        <div class="card-body">
            <div class="mb-4">
                <h4><strong>Visi:</strong></h4>
                <div class="mb-2">{!! $visi?->content ?? '<em>Belum ada visi</em>' !!}</div>

                @if($visi)
                    <form action="{{ route('admin.visimisi.destroy', ['type' => 'visi']) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin mau hapus Visi?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus Visi</button>
                    </form>
                @endif
            </div>

            <hr>

            <div class="mb-4">
                <h4><strong>Misi:</strong></h4>
                <div class="mb-2">{!! $misi?->content ?? '<em>Belum ada misi</em>' !!}</div>

                @if($misi)
                    <form action="{{ route('admin.visimisi.destroy', ['type' => 'misi']) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin mau hapus Misi?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus Misi</button>
                    </form>
                @endif
            </div>

            @if(!$visi || !$misi)
            <a href="{{ route('admin.visimisi.create') }}" class="btn btn-warning">
                Tambah Visi & Misi
            </a>
            @else
            <a href="{{ route('admin.visimisi.edit') }}" class="btn btn-warning">
                Edit Visi & Misi
            </a>
            @endif
            
        </div>
    </div>
@endsection
