<?php
use Carbon\Carbon;
?>
@extends('layout.frontend.main', ['activePage' => 'index', 'titlePage' => __('View Berita')])
@section('title', 'View Berita')

@section('content')
    <!-- Header -->
    <section id="subheader" class="relative jarallax text-light">
        @php
        use Illuminate\Support\Facades\DB;
        use App\Helpers\Translator;
        $locale = app()->getLocale();
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
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li class="active">Berita</li>
                    </ul>
                    <h1 class="text-uppercase">{{ Translator::translate('BERITA DAN INFORMASI', $locale, 'id') }}</h1>
                    <p class="col-lg-10 lead">{{ Translator::translate('Temukan berbagai kerja sama penelitian kami yang inovasi dan terpecaya.', $locale, 'id') }}</p>
                </div>
            </div>
        </div>
        <img src="{{ asset('images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
        <div class="de-gradient-edge-top dark"></div>
        <div class="de-overlay"></div>
    </section>

    <!-- Blog Area -->
    <section class="blog-area py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto mb-5 text-center">
                    <div class="site-heading">
                        <h2 class="site-title">{{ Translator::translate('Berita & Informasi', $locale, 'id') }}</h2>
                        <p>{{ Translator::translate('Lihat semua berita dan informasi mengenai TSTH2', $locale, 'id') }}</p>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                @foreach ($news as $value)
                    <div class="col-lg-6">
                        <div class="rounded-1 bg-light overflow-hidden shadow-sm">
                            <div class="row g-0">
                                <div class="col-sm-6">
                                    <div class="auto-height relative" style="background-image: url('{{ asset('storage/news/'.$value->image) }}'); background-size: cover; background-position: center; height: 100%;">
                                        <div class="abs start-0 top-0 bg-color-2 text-white p-3 pb-2 m-3 text-center fw-bold rounded-5px">
                                            <div class="fs-36 mb-0">{{ date('d', strtotime($value->updated_at)) }}</div>
                                            <span>{{ date('M', strtotime($value->updated_at)) }} {{ date('y', strtotime($value->updated_at)) }}</span>
                                        </div>
                                    </div>
                                </div>   

                                <div class="col-sm-6">
                                    <div class="p-30 pb-60">
                                        <h4>
                                            <a class="text-dark text-decoration-none" href="{{ route('frontend-news.view', ['id' => $value->id]) }}">
                                                {!! Str::words(strip_tags(Translator::translate($value->title, $locale, 'id')), 10, '...') !!}
                                            </a>
                                        </h4>
                                        <p class="mb-0">
                                            {!! Str::limit(strip_tags(Translator::translate($value->description, $locale, 'id')), 150, '...') !!}
                                            <a href="{{ route('frontend-news.view', ['id' => $value->id]) }}" class="text-decoration-none">Read More</a>
                                        </p>
                                    </div>
                                </div>                             
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination-area mt-5 d-flex justify-content-center">
                {!! $news->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </section>
@endsection
