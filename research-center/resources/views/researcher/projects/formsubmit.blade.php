@extends('layout.backend.main', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])
@section('title', 'Submit Hasil Proyek')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h3 class="mb-4">Submit Hasil Proyek</h3>

            <div class="card">
                <div class="card-body">

                    {{-- Menampilkan semua error sekaligus (opsional) --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('researcher.projects.store-publication', $project->id) }}" method="POST">
                        @csrf

                        {{-- Judul --}}
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Publikasi</label>
                            <input type="text" name="title" id="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jurnal --}}
                        <div class="mb-3">
                            <label for="journal" class="form-label">Nama Jurnal</label>
                            <input type="text" name="journal" id="journal"
                                class="form-control @error('journal') is-invalid @enderror"
                                value="{{ old('journal') }}" required>
                            @error('journal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tanggal --}}
                        <div class="mb-3">
                            <label for="publication_date" class="form-label">Tahun Publikasi</label>
                            <input type="date" name="publication_date" id="publication_date"
                                class="form-control @error('publication_date') is-invalid @enderror"
                                value="{{ old('publication_date') }}" required>
                            @error('publication_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- DOI --}}
                        <div class="mb-3">
                            <label for="doi" class="form-label">DOI (Opsional)</label>
                            <input type="text" name="doi" id="doi"
                                class="form-control @error('doi') is-invalid @enderror"
                                value="{{ old('doi') }}">
                            @error('doi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('researcher.projects.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Submit Hasil</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
