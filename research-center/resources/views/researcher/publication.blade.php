@extends('layout.backend.main', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('title', 'Daftar Publikasi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Publikasi Saya</h2>
</div>
{{-- Tampilkan notifikasi --}}
@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('info'))
<div class="alert alert-info">{{ session('info') }}</div>
@endif

@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif


<ul class="nav nav-tabs" id="publicationTabs" role="tablist">
    @foreach (['orcid' => 'ORCID', 'scopus' => 'Scopus', 'google' => 'Google Scholar', 'TSTH2' => 'TSTH2'] as $id => $label)
    <li class="nav-item" role="presentation">
        <button class="nav-link @if ($loop->first) active @endif" id="{{ $id }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $id }}" type="button" role="tab">
            {{ $label }}
        </button>
    </li>
    @endforeach

    {{-- Tombol Sinkronisasi --}}
    <li class="nav-item" role="presentation">
        {{-- Button Syncronize --}}
        <form action="{{ route('researcher.publications.sync', ['researcherId' => auth()->user()->researcher->id]) }}" method="POST" class="mb-4">
            @csrf
            <button type="submit" class="btn btn-primary">
                🔄
            </button>
        </form>
    </li>
</ul>

{{-- Konten Tab --}}



<div class="tab-content mt-3">
    {{-- ORCID --}}
    <div class="tab-pane fade show active" id="orcid" role="tabpanel">
        @if(!empty($orcidPublications))
        <ul class="list-group">
            @foreach($orcidPublications as $pub)
            <li class="list-group-item">
                <strong>{{ $pub['title'] ?? 'Tanpa Judul' }}</strong>
                <div><small>Penulis: {{ $pub['authors'] ?? 'Tidak Diketahui' }}</small></div>
                <div><small>Tahun: {{ $pub['year'] ?? (!empty($pub['publication_date']) ? \Carbon\Carbon::parse($pub['publication_date'])->year : 'Tanpa Tahun') }}</small></div>
                <div><small>DOI:
                        @if(!empty($pub['doi']))
                        <a href="https://doi.org/{{ $pub['doi'] }}" target="_blank">{{ $pub['doi'] }}</a>
                        @else
                        Tidak Ada
                        @endif
                    </small></div>
            </li>
            @endforeach
        </ul>
        @else
        <p class="text-muted">Tidak ada publikasi dari ORCID.</p>
        @endif
    </div>

    {{-- SCOPUS --}}
    <div class="tab-pane fade" id="scopus" role="tabpanel">
        @if(!empty($scopusPublications))
        <ul class="list-group">
            @foreach($scopusPublications as $pub)
            <li class="list-group-item">
                <strong>{{ $pub['title'] ?? 'Tanpa Judul' }}</strong>
                <div><small>Penulis: {{ $pub['authors'] ?? 'Tidak Diketahui' }}</small></div>
                <div><small>Tahun: {{ \Carbon\Carbon::parse($pub['publication_date'] ?? '')->format('d M, Y') }}</small></div>
                <div><small>DOI:
                        @if(!empty($pub['doi']))
                        <a href="https://doi.org/{{ $pub['doi'] }}" target="_blank">{{ $pub['doi'] }}</a>
                        @else
                        Tidak Ada
                        @endif
                    </small></div>
                <div><small>Jurnal: {{ $pub['journal'] ?? 'Tidak Diketahui' }}</small></div>
            </li>
            @endforeach
        </ul>
        @else
        <p class="text-muted">Tidak ada publikasi dari Scopus.</p>
        @endif
    </div>

    {{-- GARUDA --}}
    <div class="tab-pane fade" id="garuda" role="tabpanel">
        @if(!empty($garudaPublications))
        <ul class="list-group">
            @foreach($garudaPublications as $pub)
            <li class="list-group-item">
                <strong>{{ $pub['title'] ?? 'Tanpa Judul' }}</strong>
                <div><small>Penulis: {{ $pub['authors'] ?? 'Tidak Diketahui' }}</small></div>
                <div><small>Tahun: {{ \Carbon\Carbon::parse($pub['publication_date'] ?? '')->format('d M, Y') }}</small></div>
                <div><small>Sitasi: {{ $pub['citation'] ?? 'N/A' }}</small></div>
                <div><small>Jurnal: {{ $pub['journal'] ?? 'Tidak Diketahui' }}</small></div>
                <div><small>DOI: {{ $pub['doi'] ?? 'Tidak Ada' }}</small></div>
                <div><small>Akreditasi: {{ $pub['accreditation'] ?? 'Tidak Diketahui' }}</small></div>
            </li>
            @endforeach
        </ul>
        @else
        <p class="text-muted">Tidak ada publikasi dari Garuda.</p>
        @endif
    </div>

    {{-- GOOGLE SCHOLAR --}}
    <div class="tab-pane fade" id="google" role="tabpanel">
        @if(!empty($googleScholarPublications))
        <ul class="list-group">
            @foreach($googleScholarPublications as $pub)
            <li class="list-group-item">
                <strong>
                    @if(!empty($pub['title']))
                    <a href="https://scholar.google.com/scholar?q=intitle:'{{ urlencode($pub['title']) }}'" target="_blank">
                        {{ $pub['title'] }}
                    </a>
                    @else
                    Tanpa Judul
                    @endif
                </strong>
                <div><small>Penulis: {{ $pub['authors'] ?? 'Tidak Diketahui' }}</small></div>
                <div><small>Tahun: {{ \Carbon\Carbon::parse($pub['publication_date'] ?? '')->format('d M, Y') }}</small></div>

                <div><small>Jurnal: {{ $pub['journal'] ?? 'Tidak Diketahui' }}</small></div>
            </li>
            @endforeach
        </ul>
        @else
        <p class="text-muted">Tidak ada publikasi dari Google Scholar.</p>
        @endif
    </div>

    {{-- TSTH2 --}}
    <div class="tab-pane fade" id="TSTH2" role="tabpanel">
        @if(!empty($tsth2Publications))
        <ul class="list-group">
            @foreach($tsth2Publications as $pub)
            <li class="list-group-item">
                <strong>{{ $pub['title'] ?? 'Tanpa Judul' }}</strong>
                <div><small>Penulis: {{ $pub['authors'] ?? 'Tidak Diketahui' }}</small></div>
                <div><small>Tahun: {{ \Carbon\Carbon::parse($pub['publication_date'] ?? '')->format('d M, Y') }}</small></div>
                <div><small>DOI:
                        @if(!empty($pub['doi']))
                        <a href="https://doi.org/{{ $pub['doi'] }}" target="_blank">{{ $pub['doi'] }}</a>
                        @else
                        Tidak Ada
                        @endif
                    </small></div>
                <div><small>Jurnal: {{ $pub['journal'] ?? 'Tidak Diketahui' }}</small></div>
            </li>
            @endforeach
        </ul>
        @else
        <p class="text-muted">Tidak ada publikasi dari TSTH2.</p>
        @endif
    </div>
</div>
@endsection