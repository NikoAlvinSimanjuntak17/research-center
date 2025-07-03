@php
    use App\Helpers\Translator;
    $locale = app()->getLocale();

@endphp

@extends('layout.frontend.main', ['activePage' => 'Partnership', 'titlePage' => __('Kerja Sama')])
@section('title', 'Kerja Sama')

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
                        <li class="active">{{ Translator::translate('Kerja Sama', $locale, 'id') }}</li>
                    </ul>
                    <h1 class="text-uppercase">{{ Translator::translate('Kerja Sama', $locale, 'id') }}</h1>
                    <p class="col-lg-10 lead">
                        {{ Translator::translate('Temukan berbagai kerja sama penelitian kami yang inovasi dan terpecaya.', $locale, 'id') }}
                    </p>                </div>
            </div>
        </div>
        <img src="{{ asset('images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
        <div class="de-gradient-edge-top dark"></div>
        <div class="de-overlay"></div>
    </section>
    <!-- section kerja sama begin -->
    <section>
        <div class="container" style="margin-top: 7em">
            <div class="row g-4 mb-3 align-items-center justify-content-center">
                <div class="col-lg-6 text-center">
                <h2 class="text-uppercase wow fadeInUp" data-wow-delay=".2s">
                    {{ Translator::translate('KERJA SAMA', $locale, 'id') }}
                </h2>                
            </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-lg-12">
                    <div class="owl-custom-nav menu-" data-target="#best-seller-carousel">
                        <div class="d-flex justify-content-between">
                            <h3 class="text-uppercase mb-4"></h3>
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
                                                    src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                                    style="width: 320px; height: 320px; object-fit: contain; ">
                                                <img class="atr__image-hover object-fit-cover"
                                                    src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                                    style="width: 320px; height: 320px; object-fit: contain; ">
                                            </a>
                                        </div>
                                        <h3>{{ $item->name }}</h3>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- section kerja sama end -->
@endsection