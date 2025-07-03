@php
    use App\Helpers\Translator;
    $locale = app()->getLocale();
@endphp

@extends('layout.frontend.main', ['activePage' => 'frontend-study-centre.view', 'titlePage' => __('View Pusat Studi')])

@section('css')
    <link rel="stylesheet" href="{{ secure_asset('frontend/gardyn/css/laboix.css') }}">

@endsection
@section('title', 'View Pusat Studi')

@section('content')
<div class="no-bottom no-top" id="content">
    <div id="top"></div>

    <!-- Subheader Parallax -->
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
                        <li class="active">{{ Translator::translate('Tim Peneliti', $locale, 'id') }}</li>                    </ul>
                    <h1 class="text-uppercase">{{ Translator::translate('Tim Peneliti', $locale, 'id') }}</h1>
                    <p class="col-lg-10 lead">
                        {{ Translator::translate('Temukan para peneliti kami yang berkontribusi dalam inovasi dan penelitian ilmiah.', $locale, 'id') }}
                    </p>                
                    </div>
            </div>
        </div>
        <img src="{{ asset('images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
        <div class="de-gradient-edge-top dark"></div>
        <div class="de-overlay"></div>
    </section>

    <!-- Team Grid -->
    <section>
        <div class="container">
            <div class="row g-4">
                @foreach($researchers as $researcher)
                    <div class="col-lg-4 col-md-6">
                        <div class="relative">
                            <div class="abs bottom-0 w-100">
                                <div class="d-flex justify-content-between align-items-center rounded-1 m-4 bg-white p-4">
                                    <div>
                                        <h4 class="mb-0">
                                            <a href="{{ route('frontend-publication.byresearcher', $researcher->id) }}" class="text-dark text-decoration-none">
                                                {{ $researcher->user->name }}
                                            </a>
                                        </h4>
                                        <small class="text-muted">{{ $researcher->department->institution->name ?? 'Tidak Ada Institusi' }}</small>
                                    </div>
                                    <div class="text-end">
                                        <a href="#"><i class="fa-brands fa-facebook-f fs-24 id-color bg-light w-40px h-40px pt-2 circle text-center"></i></a>
                                    </div>
                                </div>
                            </div>
                            <img src="{{ $researcher->image ? asset('storage/' . $researcher->image) : asset('images/default.jpg') }}"
                                 class="w-100 rounded-10px" style="height: 450px; object-fit: cover " alt="{{ $researcher->user->name }}">
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $researchers->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="{{ asset('frontend/gardyn/js/laboix.js') }}"></script>
@endpush