@php
    use App\Helpers\Translator;
    $locale = app()->getLocale();
@endphp

@extends('layout.frontend.main', ['activePage' => 'visi-misi', 'titlePage' => __('Visi dan Misi')])
@section('title','Visi dan Misi')

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
<div class="blog-single-area pt-120 pb-120" style="margin-bottom: 7em;">
    <div class="container" style="margin-top: 12em">
        <div class="text-center mb-5">
            <h2 class="mb-3">{{ Translator::translate('Visi dan Misi', $locale, 'id') }}</h2>
            <p class="text-muted">{{ Translator::translate('Pedoman untuk setiap langkah TSTH2', $locale, 'id') }}</p>
        </div>

        @if($visi && $misi)
        <div class="card shadow overflow-hidden" style="border-radius: 12px;">
            <div class="row g-0">
                {{-- Kiri: VISI --}}
                <div class="col-md-6 text-white" style="
                    background-image: url('{{ asset('storage/profiles/' . $visi->image) }}');
                    background-size: contain;
                    background-position: center;
                    position: relative;
                    height: 500px;
                ">
                    <div style="
                    background-color: rgba(0,0,0,0.6); 
                    height: 100%; 
                    padding: 40px; 
                    display: flex; 
                    align-items: center; 
                    justify-content: center; 
                    flex-direction: column;">
                        <h3 class="fw-bold mb-3 text-uppercase text-light">{{ Translator::translate('VISI', $locale, 'id') }}</h3>
                        <p style="line-height: 1.8; text-align: center; font-size: 16px;">
                            {!! strip_tags($visi->description) !!}
                            {!! Translator::translateRich (strip_tags($visi->description), $locale, 'id') !!}
                        </p>
                    </div>
                </div>

                {{-- Kanan: MISI --}}
                <div class="col-md-6 text-white" style="
                    background-image: url('{{ asset('storage/profiles/' . $misi->image) }}');
                    background-size: contain;
                    background-position: center;
                    position: relative;
                    height: 500px;
                ">
                    <div style="
                        background-color: rgba(0, 0, 0, 0.6);
                        height: 100%;
                        padding: 40px;
                        display: flex;
                        align-items: center; 
                        justify-content: center; 
                        flex-direction: column;
                    ">
                    <h3 class="fw-bold mb-3 text-uppercase text-light">{{ Translator::translate('MISI', $locale, 'id') }}</h3>
                    <div style="line-height: 1.8; text-align: center; font-size: 16px;">
                        {!! Translator::translateRich($misi->description, $locale, 'id') !!}
                    </div>

                    </div>
                </div>

                </div>
            </div>
                <hr>

        </div>
        @else
        <div class="alert alert-warning text-center"> {{ Translator::translate('Konten visi atau misi belum tersedia.', $locale, 'id') }}</div>
        @endif
        
    </div>
</div>
@endsection
