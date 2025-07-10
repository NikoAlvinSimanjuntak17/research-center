@php
    use App\Helpers\Translator;
    $locale = app()->getLocale();
@endphp

@extends('layout.frontend.main', ['activePage' => 'Fasilitas', 'titlePage' => __('Fasilitas')])
@section('title', 'Fasilitas Riset')

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
                        <li class="active">{{ Translator::translate('Fasilitas', $locale, 'id') }}</li>                    </ul>
                        <h1 class="text-uppercase">{{ Translator::translate('Fasilitas', $locale, 'id') }}</h1>
                        <p class="col-lg-10 lead">{{ Translator::translate('Temukan fasilitas penelitian kami yang inovasi dan terpecaya.', $locale, 'id') }}</p>                </div>
            </div>
        </div>
        <img src="{{ asset('images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
        <div class="de-gradient-edge-top dark"></div>
        <div class="de-overlay"></div>
    </section>
    <!-- section fasilitas begin -->
    <section class="bg-light">
        <div class="container">
            <div class="row g-4 mb-3 align-items-center justify-content-center">
                <div class="col-lg-6 text-center">
                <div class="subtitle wow fadeInUp">{{ Translator::translate('Fasilitas Kami', $locale, 'id') }}</div>
                <h2 class="text-uppercase wow fadeInUp" data-wow-delay=".2s">
                    {{ Translator::translate('FASILITAS', $locale, 'id') }}
                    <span class="id-color-2">{{ Translator::translate('RISET TSTH2', $locale, 'id') }}</span>
                </h2>
                </div>
            </div>

            <div class="row g-4">
                @foreach ($facilities as $item)
                    <div class="col-lg-4 col-sm-6 wow fadeInRight" data-wow-delay=".0s">
                        <div class="bg-color text-light rounded-1 overflow-hidden">
                            <div class="hover relative overflow-hidden text-light text-center">
                                <img src="{{ asset('storage/' . $item->image) }}" class="hover-scale-1-1 w-100" alt="">
                                <div class="abs w-100 px-4 hover-op-1 z-4 hover-mt-40 abs-centered">
                                    <a class="btn-line" href="{{ route('frontend-fasilitas.view', $item->id) }}">{{ Translator::translate('Lihat Detailnya', $locale, 'id') }}</a>
                                </div>
                                <img src="{{ asset('images/logo-icon.webp') }}" class="abs abs-centered w-20" alt="">
                                <div class="abs bg-color z-2 top-0 w-100 h-100 hover-op-1"></div>
                                <div class="abs z-2 bottom-0 mb-3 w-100 text-center hover-op-0">
                                    <h4 class="mb-3">{{ Translator::translate (strtoupper($item->name), $locale, 'id') }}</h4>
                                </div>
                                <div class="gradient-trans-color-bottom abs w-100 h-40 bottom-0 Z-1"></div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
    <!-- section fasilitas end -->

@endsection
