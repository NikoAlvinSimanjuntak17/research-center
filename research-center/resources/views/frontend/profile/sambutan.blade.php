@php
    use App\Helpers\Translator;
    $locale = app()->getLocale();
@endphp

@extends('layout.frontend.main', ['activePage' => 'sambutan', 'titlePage' => __('Sambutan Direktur')])
@section('title', 'Sambutan Direktur')

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
                        <li class="active">{{ Translator::translate('Profil', $locale, 'id') }}</li>
                    </ul>
                    <h1 class="text-uppercase">{{ Translator::translate('Profil', $locale, 'id') }}</h1>
                    <p class="col-lg-10 lead">
                        {{ Translator::translate('Temukan berbagai profile penelitian kami yang inovasi dan terpecaya.', $locale, 'id') }}
                    </p>
                </div>
            </div>
        </div>
        <img src="{{ asset('images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
        <div class="de-gradient-edge-top dark"></div>
        <div class="de-overlay"></div>
    </section>
<div class="blog-single-area pt-120 pb-120" style="margin-bottom:7em;">
    <div class="container" style="margin-top: 10em">
        <div class="text-center mb-5">
        <h2 class="mb-3">{{ Translator::translate('Sambutan Direktur TSTH2', $locale, 'id') }}</h2>
        <p class="text-muted">{{ Translator::translate('Kata sambutan dari Direktur kami', $locale, 'id') }}</p>
        </div>

        @if ($sambutan)
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="blog-single-wrapper">
                    <div class="blog-single-content">
                        <div class="blog-thumb-img mb-4 text-center">
                            <img src="{{ asset('storage/profiles/' . ($sambutan->image ?? 'default.jpg')) }}"
                                alt="thumb" class="img-fluid" style="max-width: 100%; max-height: 500px; object-fit: cover; border-radius: 5%;">
                        </div>
                        <div class="blog-details">
                            <h3 class="text-center">{{ Translator::translate($sambutan->title, $locale, 'id') }}</h3>
                            <div class="mt-4">
                                {!! Translator::translateRich($sambutan->description, $locale, 'id') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
            <p class="text-center text-muted">{{ Translator::translate('Tidak ada konten sambutan yang tersedia', $locale, 'id') }}</p>
        @endif
        <hr>
    </div>
</div>
@endsection
