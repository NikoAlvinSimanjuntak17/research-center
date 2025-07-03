@extends('layout.frontend.main', ['activePage' => 'Galeri', 'titlePage' => __('Galeri Detail')])
@section('title', 'Galeri Detail')

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
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="#">Galeri</a></li>
                    <li class="active">{{ $gallery->title }}</li>
                </ul>
                <h1 class="text-uppercase">{{ $gallery->title }}</h1>
                <p class="col-lg-10 lead">{!! $gallery->description !!}</p>
            </div>
        </div>
    </div>
    <img src="{{ asset('images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
    <div class="de-gradient-edge-top dark"></div>
    <div class="de-overlay"></div>
</section>

<section class="relative pt-120 pb-120 bg-light">
    <div class="container">
        <div class="row g-4">
            @forelse($gallery->files as $file)
                <div class="col-lg-4 col-md-6 text-center">
                    <a href="{{ asset('storage/' . $file->image) }}" class="image-popup d-block hover">
                        <div class="relative overflow-hidden rounded-10">
                            <div class="absolute start-0 w-100 abs-middle fs-36 text-white text-center z-2">
                                <h4 class="mb-0 hover-scale-in-3">View</h4>
                            </div> 
                            <div class="absolute w-100 h-100 top-0 bg-dark hover-op-05"></div>
                            <img src="{{ asset('storage/' . $file->image) }}"
                                 class="img-fluid hover-scale-1-2"
                                 alt="Gambar dari galeri {{ $gallery->title }}">
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Tidak ada gambar dalam galeri ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('frontend/gardyn/js/laboix.js') }}"></script>
{{-- Jika pakai lightbox seperti Magnific Popup, tambahkan inisialisasi --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        $('.image-popup').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    });
</script>
@endpush