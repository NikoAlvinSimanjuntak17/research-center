@php
    use App\Helpers\Translator;
    $locale = app()->getLocale();
@endphp

@extends('layout.frontend.main', ['activePage' => 'frontend-study-centre.view', 'titlePage' => __('View Pusat Studi')])
@section('css')
<link rel="stylesheet" href="{{ asset('frontend/gardyn/css/laboix.css') }}">

@section('title', 'View Pusat Studi')

@section('content')
        <section id="subheader" class="relative jarallax text-light">
        @php
        use Illuminate\Support\Facades\DB;
        $slider = DB::table('sliders')
        ->where('active', 1)
        ->orderBy('updated_at', 'desc')
        ->first(); // ganti get() dengan first()

        @endphp
        <img src="{{ asset(asset('storage/sliders/' . $slider->image)) }}" class="jarallax-img" alt="">
        <div class="container relative z-index-1000">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="crumb">
                        <li><a href="{{ url('/') }}">{{ Translator::translate('Home', $locale, 'id') }}</a></li>
                        <li class="active">{{ Translator::translate('Penelitian', $locale, 'id') }}</li>
                    </ul>
                    <h1 class="text-uppercase">{{ Translator::translate('PUBLIKASI PENELITIAN', $locale, 'id') }}</h1>
                    <p class="col-lg-10 lead">{{ Translator::translate('Temukan hasil publikasi penelitian kami yang inovasi dan terpecaya.', $locale, 'id') }}</p>
                </div>
            </div>
        </div>
        <img src="{{ asset('images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
        <div class="de-gradient-edge-top dark"></div>
        <div class="de-overlay"></div>
    </section>

    {{-- ======================== SUMMARY ======================== --}}
    <section class="about-fore">
        <div class="container">
            <div class="row g-4 mb-3 align-items-center justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="subtitle wow fadeInUp">{{ Translator::translate('PENELITIAN', $locale, 'id') }}</div>
                    <h2 class="text-uppercase wow fadeInUp" data-wow-delay=".2s">{{ Translator::translate('PUBLIKASI', $locale, 'id') }}</h2>
                </div>
            </div>
            {{-- ======================== DAFTAR PUBLIKASI ======================== --}}
            <div class="row">
                <div class="about-fore__left">
                    <ul class="about-fore__feature list-unstyled">
                        @foreach ($publications as $pub)
                            <li class="about-fore__feature__item">
                                <div class="about-fore__feature__content">
                                    {{-- Judul Publikasi --}}
                                    @if($pub->source == 'scopus' || $pub->source == 'orcid')
                                        <a href="https://doi.org/{{ $pub->doi }}" target="_blank">
                                            <h4 class="about-fore__feature__title">{{ $pub->title }}</h4>
                                        </a>
                                    @elseif($pub->source == 'googlescholar')
                                        <a href="https://scholar.google.com/scholar?q=intitle:'{{ urlencode($pub->title) }}'"
                                            target="_blank">
                                            <h4 class="about-fore__feature__title">{{ $pub->title }}</h4>
                                        </a>
                                    @else
                                        <h4 class="about-fore__feature__title text-muted">Judul tidak tersedia</h4>
                                    @endif

                                    {{-- Detail Publikasi --}}
                                    <p class="about-fore__feature__text"><strong>Author:</strong>
                                        {!! $pub->authors ?? 'Anonim' !!}</p>
                                    <p class="about-fore__feature__text"><strong>Date:</strong>
                                        {{ \Carbon\Carbon::parse($pub->publication_date)->format('d M, Y') }}</p>
                                    <p class="about-fore__feature__text"><strong>Source:</strong> {{ ucfirst($pub->source) }}
                                    </p>
                                    <p class="about-fore__feature__text"><strong>Journal:</strong>
                                        {{ $pub->journal ?? 'Tidak Diketahui' }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- ======================== PAGINATION ======================== --}}
                <!-- Pagination -->
            <div class="pagination-area mt-5 d-flex justify-content-center">
                {!! $publications->links('pagination::bootstrap-5') !!}
            </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('frontend/gardyn/js/laboix.js') }}"></script>
@endpush