@extends('layout.frontend.main', ['activePage' => 'Partnership', 'titlePage' => $partnership->name])
@section('title', $partnership->name)

@section('content')
<section id="subheader" class="relative jarallax text-light">
    <img src="{{ asset('images/background/9.webp') }}" class="jarallax-img" alt="">
    <div class="container relative z-index-1000">
        <div class="row">
            <div class="col-lg-6">
                <ul class="crumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">Penelitian</li>
                </ul>
                <h1 class="text-uppercase">Detail Kerja Sama</h1>
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
                        <h2 class="mb-3">{{ $partnership->name }}</h2>
                        <img src="{{ asset('storage/' . $partnership->image) }}" class="img-fluid rounded-3 shadow mb-4" alt="{{ $partnership->name }}">
                        <p>{!! $partnership->description !!}</p>
                        <a href="{{ route('frontend-partnership.index') }}" class="btn-main mt-4 d-inline-block">
                            ← Kembali ke Daftar Kerja Sama
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar partnership lainnya (jika ada) -->
            @if (isset($partnerships_lain) && $partnerships_lain->count() > 1)
            <div class="col-lg-3 ms-lg-5 mt-5 mt-lg-0">
                <div class="widget">
                    <h3 class="widget-title">Kerja Sama Lainnya</h3>
                    <div class="row g-3">
                        @foreach ($partnerships_lain as $item)
                        @if ($item->id !== $partnership->id)
                        <div class="col-11">
                            <div class="bg-color text-light rounded-1 overflow-hidden"
                                style="max-width: 350px; width: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                                <div class="hover relative overflow-hidden text-light text-center">
                                    <img src="{{ asset('storage/' . $item->image) }}" class="hover-scale-1-1 w-100"
                                        style="height: 180px; object-fit: contain;" alt="{{ $item->name }}">

                                    <div class="abs w-100 px-2 hover-op-1 z-4 hover-mt-40 abs-centered">
                                        <a class="btn-line btn-sm"
                                            href="{{ route('frontend-partnership.view', $item->id) }}">
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
            @endif
        </div>
    </div>
</section>
@endsection