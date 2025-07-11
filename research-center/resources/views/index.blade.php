@php
    use App\Helpers\Translator;
    $locale = app()->getLocale(); // 'id' atau 'en'
@endphp


@extends('layout.frontend.main', ['activePage' => 'index', 'titlePage' => __('Home')])
@section('title','Home')
@section('css')
<style>
    .swiper-inner {
        background-size: cover background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
    }
    .responsive-video {
  position: relative;
  padding-bottom: 56.25%; /* 16:9 ratio */
  height: 0;
  overflow: hidden;
  max-width: 100%;
  background: #000;
}

.responsive-video iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

</style>
@endsection
@section('content')
<!-- section slider begin -->

<section id="section-intro" class="text-light no-top no-bottom relative overflow-hidden z-1000">
    @php
    use Illuminate\Support\Facades\DB;
    $sliders = DB::table('sliders')
    ->where('active', 1)
    ->orderBy('updated_at', 'desc')
    ->get();
    @endphp

    <div class="h-30 de-gradient-edge-top op-5 dark z-2"></div>
    <img src="{{ asset('images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
    <div class="v-center relative">

        <div class="swiper">
            <div class="swiper-wrapper">

                @foreach($sliders as $slider)
                <div class="swiper-slide">
                    <div class="swiper-inner" data-bgimage="url({{ asset('storage/sliders/' . $slider->image) }})">
                        <div class="sw-caption z-1000">
                            <div class="container">
                                <div class="row g-4 align-items-center">
                                    <div class="spacer-double"></div>
                                    <div class="col-lg-6">
                                        <div class="spacer-single"></div>
                                        <div class="sw-text-wrapper">
                                            <h2 class="slider-title mb-4">
                                                {!! Translator::translate($slider->title, $locale, 'id') !!}
                                            </h2>
                                            @if($slider->description)
                                                <p class="text-light">
                                                    {!! Translator::translate($slider->description, $locale, 'id') !!}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="spacer-single"></div>
                                </div>
                            </div>
                        </div>
                        <div class="sw-overlay op-3"></div>
                    </div>
                </div>
                @endforeach

            </div>

            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>

        </div>
    </div>
</section>


<!-- section slider end -->
<p class="text-danger text-center mt-3">[LOCALE: {{ app()->getLocale() }}]</p>

<!-- section about begin -->
<section class="pb-50">
    @php
    $about = DB::table('profiles')
    ->where('key', 'tentang')
    ->first();
    @endphp
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-6">
                <div class="relative">
                    <div class="rounded-1 bg-body w-90 overflow-hidden wow zoomIn">
                        <img src="{{ asset('storage/profiles/' . ($about->image ?? 'default.jpg')) }}" class="w-100 jarallax wow scaleIn" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ps-lg-3">
                <div class="subtitle id-color wow fadeInUp" data-wow-delay=".2s">
                    {{ Translator::translate('SELAMAT DATANG DI Taman Sains Teknologi Herbal dan Hortikultura (TSTH2)', $locale, 'id') }}
                </div>                    
                <h2 class="text-uppercase wow fadeInUp" data-wow-delay=".4s">
                    {{ strtoupper(Translator::translate($about->title ?? '', $locale, 'id')) }}
                </h2>                    
                @php
                    $fullText = strip_tags($about->description ?? '');
                    $maxLength = 500;

                    $truncated = Str::limit($fullText, $maxLength, '');

                    // Cari posisi titik terakhir
                    $lastPeriodPos = strrpos($truncated, '.');

                    // Ambil sampai titik terakhir, jika ada
                    $finalText = $lastPeriodPos !== false ? substr($truncated, 0, $lastPeriodPos + 1) : $truncated;
                    @endphp

                    <p class="wow fadeInUp" data-wow-delay=".6s">
                        {{ Translator::translate($finalText, $locale, 'id') }}
                    </p>


                    <a class="btn-main wow fadeInUp" href="{{route(name: 'frontend-profile.view')}}" data-wow-delay=".6s">{{ Translator::translate('LIHAT SELENGKAPNYA', $locale, 'id') }}</a>
                </div>
            </div>
        </div>
    </div>
    <br><br>
</section>

<!-- section about end -->

<!-- section komoditas begin -->
<section class="bg-light">
    <div class="container">
        <div class="row g-4 mb-3 align-items-center justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="subtitle wow fadeInUp"> {{ Translator::translate('Komoditas kami', $locale, 'id') }}</div>
                <h2 class="text-uppercase wow fadeInUp" data-wow-delay=".2s">
                    {{ Translator::translate('FOKUS KOMODITAS', $locale, 'id') }} <span class="id-color-2">{{ Translator::translate('RISET TSTH2', $locale, 'id') }}</span>
                </h2>
            </div>
        </div>

        @php
        $komoditas = DB::table('commodities')->latest()->take(6)->get(); // Sesuaikan limit dan urutan sesuai kebutuhan
        @endphp

        <div class="row g-4">
            @foreach ($komoditas as $item)
            <div class="col-lg-4 col-sm-6 wow fadeInRight" data-wow-delay=".0s">
                <div class="bg-color text-light rounded-1 overflow-hidden" style="height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                    <div class="hover relative overflow-hidden text-light text-center">
                        <img src="{{ asset('storage/' . $item->image) }}"
                            class="hover-scale-1-1 w-100"
                            style="height: 400px; object-fit: contain;"
                            alt="{{ $item->name }}">

                        <div class="abs w-100 px-4 hover-op-1 z-4 hover-mt-40 abs-centered">
                            <a class="btn-line" href="{{ route('frontend-komoditas.view', $item->id) }}"> {{ Translator::translate('Lihat Detail', $locale, 'id') }}</a>
                        </div>

                        <img src="{{ asset('images/logo-icon.webp') }}" class="abs abs-centered w-20" alt="">

                        <div class="abs bg-color z-2 top-0 w-100 h-100 hover-op-1"></div>

                        <div class="abs z-2 bottom-0 mb-3 w-100 text-center hover-op-0">
                        <h4 class="mb-3">
                            {{ strtoupper(Translator::translate($item->name, $locale, 'id')) }}
                        </h4>                        
                        </div>

                        <div class="gradient-trans-color-bottom abs w-100 h-40 bottom-0 Z-1"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
<!-- section komoditas end -->

<!-- section maps begin -->
<section class="relative">
    <div class="container">
        <div class="row g-4 mb-3 align-items-center justify-content-center">
            <div class="col-lg-6 text-center">
                <h2 class="text-uppercase wow fadeInUp" data-wow-delay=".2s">{{ Translator::translate('PETA KHDTK dan TSTH2', $locale, 'id') }}</h2>
            </div>                        
        </div>
        <div class="row g-4">
            @php
                $petaImages = DB::table('profiles')->where('key', 'peta')->latest()->take(6)->get();
            @endphp
            @foreach($petaImages as $img)
            <div class="col-lg-4 text-center">
                <a href="{{ asset('storage/profiles/' . $img->image) }}" class="image-popup d-block hover">
                    <div class="relative overflow-hidden rounded-10" style="height: 400px;">
                        <div class="absolute start-0 w-100 abs-middle fs-36 text-white text-center z-2">
                            <h4 class="mb-0 hover-scale-in-3">{{ Translator::translate('Lihat', $locale, 'id') }}</h4>
                        </div> 
                        <div class="absolute w-100 h-100 top-0 bg-dark hover-op-05"></div>
                        <img src="{{ asset('storage/profiles/' . $img->image) }}"
                             class="img-fluid hover-scale-1-2"
                             alt=""
                             style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- section maps end -->

<!-- section news begin -->
<section>
    <div class="container">
        <div class="row g-4 mb-3 align-items-center justify-content-center">
            <div class="col-lg-6 text-center">
                <h2 class="text-uppercase wow fadeInUp" data-wow-delay=".2s">{{ Translator::translate('BERITA', $locale, 'id') }}</span></h2>
            </div>
        </div>
        <div class="row g-4">
            @php
            $news = DB::table('news')
            ->join('news_categories', 'news.news_category_id', '=', 'news_categories.id')
            ->select('news.*', 'news_categories.name as news_category_name')
            ->orderBy('news.updated_at','DESC')
            ->take(4)->get();
            @endphp
            @foreach ($news as $value)
            <div class="col-lg-6">
                <div class="rounded-1 bg-light overflow-hidden">
                    <div class="row g-2">
                        <div class="col-sm-6">
                            <div class="auto-height relative" data-bgimage="url({{ asset('storage/news/'.$value->image) }})">
                                <div class="abs start-0 top-0 bg-color-2 text-white p-3 pb-2 m-3 text-center fw-600 rounded-5px">
                                    <div class="fs-36 mb-0">{{date('d', strtotime($value->updated_at));}}</div>
                                    <span>{{date('M', strtotime($value->updated_at));}} {{date('y', strtotime($value->updated_at));}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 relative">
                            <div class="p-30 pb-60">
                                <h4><a class="text-dark" href="#">{!! Str::words(strip_tags( strtoupper(Translator::translate($value->title, $locale, 'id'))),9, '...') !!}</a></h4>
                                <p class="mb-0">
                                    {!! Str::limit(strip_tags(Translator::translate($value->description, $locale, 'id')), 150, '...') !!}
                                    <a href="{{route('frontend-news.view',['id'=>$value->id])}}" class="text-decoration-none">{{ Translator::translate('Baca Selengkapnya', $locale, 'id') }}</a>
                                </p>

                                <div class="abs bottom-0 pb-20">
                                    {{-- <div class="d-inline fs-14 fw-600 me-3"><i class="icofont-chat id-color-2 me-2"></i>10 Comments</div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="col-12 text-center mt-5">
                <a href="{{ route('frontend-news.index') }}" class="btn-main">
                    {{ Translator::translate('Lihat Semua Berita', $locale, 'id') }}
                </a>
            </div>

        </div>
    </div>
</section>
<!-- section news end -->

<!-- section maps begin -->
@php
$videos = DB::table('profiles')->where('key', 'video')->get();
@endphp

<section class="relative  bg-light">
    <div class="container">
        <div class="row g-4 mb-3 align-items-center justify-content-center">
            <div class="col-lg-6 text-center">
                <h2 class="text-uppercase wow fadeInUp" data-wow-delay=".2s">{{ Translator::translate('VIDEO TERKAIT TSTH2', $locale, 'id') }}</h2>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach ($videos as $video)
            @php
            // Ambil teks murni dari <p>...</p>
            $link = strip_tags($video->description); // Hasil: https://www.youtube.com/watch?v=...

            // Ambil ID video dari link YouTube
            preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/', $link, $matches);
            $videoId = $matches[1] ?? null;
            @endphp

            @if ($videoId)
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="responsive-video mx-auto">
                    <iframe
                        src="https://www.youtube.com/embed/{{ $videoId }}"
                        title="{{ $video->title }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>

            @endif
            @endforeach
        </div>
    </div>
</section>

<!-- section maps end -->

<!-- section kerja sama begin -->
<section>
    <div class="container">
        <div class="row g-4 mb-3 align-items-center justify-content-center">
            <div class="col-lg-6 text-center">
                <h2 class="text-uppercase wow fadeInUp" data-wow-delay=".2s">{{ Translator::translate('KERJA SAMA', $locale, 'id') }}</span></h2>
            </div>
        </div>
        @php
        $partnerships = DB::table('partnerships')->latest()->get(); // Ganti 'cooperations' jika nama tabel berbeda
        @endphp

        <div class="row g-4 mb-4">
            <div class="col-lg-12">
                <div class="owl-custom-nav menu-" data-target="#best-seller-carousel">
                    <div class="d-flex justify-content-between">
                        <h3 class="text-uppercase mb-4">{{ Translator::translate('Kerja Sama', $locale, 'id') }}</h3>
                        <div class="arrow-simple">
                            <a class="btn-prev"></a>
                            <a class="btn-next"></a>
                        </div>
                    </div>

                    <div id="best-seller-carousel" class="owl-carousel owl-4-cols">
                        @foreach ($partnerships as $item)
                        <div class="item">
                            <div class="de__pcard text-center">
                                <div class="atr__images">
                                    <a href="{{ route('frontend-partnership.view', $item->id) }}">
                                        <img class="atr__image-main object-fit-cover"
                                            src="{{ asset('storage/' . $item->image) }}"
                                            alt="{{ strtoupper(Translator::translate($item->name, $locale, 'id')) }}"
                                            style="width: 320px; height: 320px; object-fit: contain;">

                                        <img class="atr__image-hover object-fit-cover"
                                            src="{{ asset('storage/' . $item->image) }}"
                                            alt="{{ strtoupper(Translator::translate($item->name, $locale, 'id')) }}"
                                            style="width: 320px; height: 320px; object-fit: contain;">
                                    </a>
                                </div>
                                <h3>{{ strtoupper(Translator::translate($item->name, $locale, 'id')) }}</h3>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

</section>
<!-- section kerja sama end -->


@endsection