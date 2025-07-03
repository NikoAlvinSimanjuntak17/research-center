@extends('layout.backend.main', ['activePage' => 'research-facility.index', 'titlePage' => 'Detail Fasilitas Riset'])

@section('title', 'Detail Fasilitas Riset')
@section('content')

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $research_facility->name }}</h4>
                <p class="text-muted">{{ $research_facility->description }}</p>

                @if($research_facility->image)
                    <img src="{{ asset('storage/' . $research_facility->image) }}" class="" alt="Fasilitas Gambar">
                @else
                    <p class="text-muted">Gambar tidak tersedia.</p>
                @endif

                <a href="{{ route('admin.research-facility.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar</a>
            </div>
        </div>
    </div>
</div>
@endsection
