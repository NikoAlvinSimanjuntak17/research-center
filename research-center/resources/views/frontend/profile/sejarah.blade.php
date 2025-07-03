@php
    use App\Helpers\Translator;
    $locale = app()->getLocale();
@endphp

@extends('layout.frontend.main', ['activePage' => 'index', 'titlePage' => __('View Berita')])
@section('title','View Berita')

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
                    <li><a href="{{ url('/') }}">{{ Translator::translate('Beranda', $locale, 'id') }}</a></li>
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
<div class="blog-single-area pt-120 pb-120">
    <div class="container" style="margin-top: 7em">

        {{-- Daftar Sejarah --}}
    <div class="mb-5">
    <h3 class="text-center mb-4">
        {{ Translator::translate('Taman Sains Teknologi Herbal dan Hortikultura (TSTH2)', $locale, 'id') }}
    </h3>        
    <div class="d-flex flex-wrap justify-content-center gap-2">
            @foreach ($data_all as $value)
                @php
                    $isActive = $value->id == $model->id;
                @endphp
                <a href="{{ route('frontend-profile.view', ['id' => $value->id]) }}"
                style="
                    display: inline-block;
                    padding: 6px 12px;
                    min-width: 200px;
                    text-align: center;
                    border: 2px solid #6c757d;
                    border-radius: 4px;
                    font-size: 0.875rem;
                    text-decoration: none;
                    color: {{ $isActive ? '#fff' : '#6c757d' }};
                    background-color: {{ $isActive ? '#6c757d' : 'transparent' }};
                    font-weight: {{ $isActive ? 'bold' : 'normal' }};
                ">
                {{ Translator::translate($value->title, $locale, 'id') }}
                </a>
            @endforeach
        </div>
    </div>
        {{-- Konten Utama --}}
        @if ($model)
        <div class="blog-single-wrapper">
            <div class="blog-single-content">
                <div class="blog-thumb-img mb-4 text-center">
                    <img src="{{ asset('storage/profiles/' . ($model->image ?? 'default.jpg')) }}"
                         alt="thumb"
                         class="img-fluid"
                         style="width:50%; height: 50%; object-fit:cover; border-radius: 5%;">
                </div>

                <div class="blog-details" style="margin-bottom: 5em;">
                    <h2 class="blog-details-title text-center mb-4">{{ Translator::translate($model->title, $locale, 'id') }}</h2>
                    <div class="content">
                        {!! Translator::translateRich($model->description, $locale, 'id') !!}
                    </div>
                    <hr>
                </div>
                   
            </div>
        </div>
        @else
            <p class="text-center text-muted">{{ Translator::translate('Tidak ada konten sejarah yang tersedia', $locale, 'id') }}</p>
        @endif

    </div>
</div>
@endsection
