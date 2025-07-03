@php
    use App\Helpers\Translator;
    $locale = app()->getLocale();
@endphp

@extends('layout.frontend.main', ['activePage' => 'struktur-organisasi', 'titlePage' => __('Struktur Organisasi')])
@section('title','Struktur Organisasi')

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
                        <li class="active">{{ Translator::translate('Profile', $locale, 'id') }}</li>
                    </ul>
                    <h1 class="text-uppercase">{{ Translator::translate('Profile', $locale, 'id') }}</h1>
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
<div class="blog-single-area pt-120 pb-120" style="margin-bottom: 7em">
    <div class="container" style="margin-top: 10em">
        <div class="text-center mb-5">
            <h2 class="mb-3">{{ Translator::translate('Struktur Organisasi TSTH2', $locale, 'id') }}</h2>
            <p class="text-muted">{{ Translator::translate('Struktur organisasi lembaga kami secara formal', $locale, 'id') }}</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                @if ($data)
                    {{-- Gambar struktur organisasi --}}
                    @if ($data->image)
                        <div class="mb-4">
                            <img src="{{ asset('storage/profiles/' . $data->image) }}"
                                 alt="Struktur Organisasi"
                                 class="img-fluid rounded"
                                 style="max-height: 600px; object-fit: contain;">
                        </div>
                    @endif

                    {{-- Deskripsi (jika ada) --}}
                    @if ($data->description)
                        <div class="text-justify" style="max-width: 800px; margin: auto; line-height: 1.7;">
                            {!! Translator::translateRich($data->description, $locale, 'id') !!}
                        </div>
                    @endif
                @else
                    <p class="text-muted">{{ Translator::translate('Tidak ada konten struktur yang tersedia', $locale, 'id') }}.</p>
                @endif
            </div>
        </div>
        <hr>
    </div>
</div>
@endsection
