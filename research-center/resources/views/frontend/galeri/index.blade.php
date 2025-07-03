@extends('layout.frontend.main', ['activePage' => 'Galeri', 'titlePage' => __('Galeri')])
@section('title', 'Galeri')

@section('content')
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
                        <li><a href="{{ url('/') }}">{{ Translator::translate('Beranda', $locale, 'id') }}</a></li>
                        <li class="active">{{ Translator::translate('Galeri', $locale, 'id') }}</li>

                    </ul>
                    <h1 class="text-uppercase">{{ Translator::translate('Galeru', $locale, 'id') }}</h1>
                    <p class="col-lg-10 lead">{{ Translator::translate('Temukan berbagai galeri penelitian kami yang inovasi dan terpecaya.', $locale, 'id') }}</p>
                </div>
            </div>
        </div>
        <img src="{{ asset('images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
        <div class="de-gradient-edge-top dark"></div>
        <div class="de-overlay"></div>
    </section>
<!-- section galeri begin -->
<section class="bg-light py-5">
    <div class="container" style="margin-top:7em; margin-bottom: 10em;">
        <div class="row g-4 mb-3 align-items-center justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="subtitle wow fadeInUp">{{ Translator::translate('Galeri Kegiatan', $locale, 'id') }} </div>
                <h2 class="text-uppercase wow fadeInUp" data-wow-delay=".2s">
                    {{ Translator::translate('DOKUMENTASI', $locale, 'id') }} 
                    <span class="id-color-2">{{ Translator::translate('RISET TSTH2', $locale, 'id') }}</span>
                </h2>

            </div>
        </div>

<div class="row g-4">
    @foreach ($galleries as $item)
        <div class="col-lg-4 col-sm-6 wow fadeInRight" data-wow-delay=".0s">
            <div class="bg-color text-light rounded-1 overflow-hidden" 
                 style="height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                 
                <div class="hover relative overflow-hidden text-light text-center">
                    @php
                        $coverImage = $item->files->first()?->image ?? 'images/default.jpg';
                    @endphp

                    <img src="{{ asset('storage/' . $coverImage) }}" 
                         class="hover-scale-1-1 w-100" 
                         style="height: 300px; object-fit: cover;" 
                         alt="Gambar Galeri {{ $item->title }}">

                    <div class="abs w-100 px-4 hover-op-1 z-4 hover-mt-40 abs-centered">
                        <a class="btn-line" href="{{ route('frontend-gallery.show', $item->id) }}">
                            {{ Translator::translate('Lihat Detailnya', $locale, 'id') }} 
                        </a>
                    </div>

                    <div class="abs bg-color z-2 top-0 w-100 h-100 hover-op-1"></div>

                    <div class="abs z-2 bottom-0 mb-3 w-100 text-center hover-op-0">
                    <h4 class="mb-3">
                        {{ strtoupper(Translator::translate($item->title, $locale, 'id')) }}
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
<!-- section galeri end -->
@endsection
