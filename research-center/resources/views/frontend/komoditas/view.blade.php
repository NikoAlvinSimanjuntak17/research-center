@php
    use App\Helpers\Translator;
    $locale = app()->getLocale();
@endphp
@extends('layout.frontend.main', ['activePage' => 'Komoditas', 'titlePage' => $komoditas->name])
@section('title', $komoditas->name)

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
                    <h1 class="text-uppercase">{{ Translator::translate('Detail Komoditas', $locale, 'id') }}</h1>
                    <p class="col-lg-10 lead">
                        {{ Translator::translate('Temukan berbagai komoditas penelitian kami yang inovasi dan terpecaya.', $locale, 'id') }}
                    </p>
                </div>
            </div>
        </div>
        <img src="{{ asset('images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
        <div class="de-gradient-edge-top dark"></div>
        <div class="de-overlay"></div>
    </section>

    <section class="bg-light py-120">
        <div class="container">
            <div class="row">
                <!-- Konten utama -->
                <div class="col-lg-8">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h2 class="mb-3">{{ $komoditas->name }}</h2>
                            <p>{!! $komoditas->description !!}</p>
                            <a href="{{ route('frontend-komoditas.index') }}" class="btn-main mt-4 d-inline-block">
                                ← Kembali ke Daftar Komoditas
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sidebar komoditas lainnya -->
                <div class="col-lg-3 ms-lg-5 mt-5 mt-lg-0">
                    <div class="widget">
                        <h3 class="widget-title">Komoditas Lainnya</h3>
                        <div class="row g-3">
                            @foreach ($komoditas_lain as $item)
                                @if ($item->id !== $komoditas->id)
                                    <div class="col-11">
                                        <div class="bg-color text-light rounded-1 overflow-hidden"
                                            style="max-width: 350px; width: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                                            <div class="hover relative overflow-hidden text-light text-center">
                                                <img src="{{ asset('storage/' . $item->image) }}" class="hover-scale-1-1 w-100"
                                                    style="height: 180px; object-fit: contain;" alt="">

                                                <div class="abs w-100 px-2 hover-op-1 z-4 hover-mt-40 abs-centered">
                                                    <a class="btn-line btn-sm"
                                                        href="{{ route('frontend-komoditas.view', $item->id) }}">
                                                        Lihat Detail
                                                    </a>
                                                </div>

                                                <div class="abs z-2 bottom-0 mb-2 w-100 text-center hover-op-0">
                                                    <h6 class="mb-2 px-2">{{ strtoupper($item->name) }}</h6>
                                                </div>

                                                <div class="abs bg-color z-2 top-0 w-100 h-100 hover-op-1"></div>
                                                <div class="gradient-trans-color-bottom abs w-100 h-40 bottom-0 z-1"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection