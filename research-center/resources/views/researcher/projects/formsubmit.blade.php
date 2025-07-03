@extends('layout.backend.main', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])
@section('title', 'Submit Hasil Proyek')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h3 class="mb-4">Submit Hasil Proyek</h3>

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('researcher.projects.store-publication', $project->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Publikasi</label>
                            <input type="text" name="title" id="title" class="form-control" required value="{{ old('title') }}">
                        </div>

                        <div class="mb-3">
                            <label for="journal" class="form-label">Nama Jurnal</label>
                            <input type="text" name="journal" id="journal" class="form-control" required value="{{ old('journal') }}">
                        </div>

                        <div class="mb-3">
                            <label for="publication_date" class="form-label">Tahun Publikasi</label>
                            <input type="date"class="form-control" id="publication_date" name="publication_date" value="{{ old('publication_date') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="doi" class="form-label">DOI (Opsional)</label>
                            <input type="text" name="doi" id="doi" class="form-control" value="{{ old('doi') }}">
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
