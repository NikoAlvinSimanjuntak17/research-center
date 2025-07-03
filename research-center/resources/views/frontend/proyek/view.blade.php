@php
    use App\Helpers\Translator;
    $locale = app()->getLocale();
@endphp

@extends('layout.frontend.main', ['activePage' => 'index', 'titlePage' => __('Detail Proyek')])
@section('title', 'Detail Proyek')

@section('content')
<section id="subheader" class="relative jarallax text-light">
    <img src="{{ asset('images/background/12.webp') }}" class="jarallax-img" alt="">
    <div class="container relative z-index-1000">
        <div class="row">
            <div class="col-lg-6">
                <ul class="crumb">
                    <li><a href="{{ url('/') }}">{{ Translator::translate('Home', $locale, 'id') }}</a></li>
                    <li><a href="{{ route('frontend-project.index') }}">{{ Translator::translate('Proyek Penelitian', $locale, 'id') }}</a></li>
                    <li class="active">{{ Translator::translate('Detail', $locale, 'id') }}</li>
                </ul>
                <h1 class="text-uppercase">{{ Translator::translate('Detail Proyek', $locale, 'id') }}</h1>
            </div>
        </div>
    </div>
    <img src="{{ asset('images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
    <div class="de-gradient-edge-top dark"></div>
    <div class="de-overlay"></div>
</section>

<section class="pt-120 pb-120">
    <div class="container">
        <div class="row g-4">
            <!-- Detail Proyek -->
            <div class="col-lg-8">
                <div class="me-lg-3">
                    <div class="mb-3">
                       <span class="badge {{ $isClosed ? 'bg-danger' : 'bg-success' }}">
                            {{ $isClosed ? Translator::translate('Ditutup', $locale, 'id') : Translator::translate('Sedang Dibuka', $locale, 'id') }}
                        </span>

                    </div>

                    <h3 class="mb-2">{{ $project->title }}</h3>
                    <p class="text-muted mb-2">
                        {{ Translator::translate('Dibuat oleh', $locale, 'id') }}:
                        <strong>{{ $project->creator->name ?? Translator::translate('Tidak diketahui', $locale, 'id') }}</strong>
                    </p>                    
                    <p class="mb-4">{!!Translator::translateRich($project->description) !!}</p>

                    <div class="mt-5">
                        @auth
                        @if($hasApplied)
                            <div class="alert alert-info">
                                {{ Translator::translate('Kamu sudah mendaftar sebagai kolaborator pada proyek ini.', $locale, 'id') }}
                            </div>
                        @elseif(!$isClosed)
                            <a href="{{ route('frontend-project.apply', $project->id) }}" class="btn-main mt-4 d-inline-block">
                                {{ Translator::translate('Daftar Sebagai Kolaborator', $locale, 'id') }}
                            </a>
                        @endif

                        @else
                        @if(!$isClosed)
                        <a href="{{ route('login') }}" class="btn-main mt-4 d-inline-block"
                        onclick="return confirm('{{ Translator::translate('Silakan login terlebih dahulu untuk mendaftar sebagai kolaborator.', $locale, 'id') }}')">
                        {{ Translator::translate('Daftar Sebagai Kolaborator', $locale, 'id') }}
                        </a>

                        @endif
                        @endauth
                    </div>

                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4 text-dark">
            <h5 class="text-uppercase mb-4">{{ Translator::translate('Detail Proyek', $locale, 'id') }}</h5>
            <div class="d-flex justify-content-between mb-3">
                <div class="fw-bold">{{ Translator::translate('Dibuka', $locale, 'id') }}</div>
                <div>{{ $project->open_at->format('F d, Y') }}</div>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <div class="fw-bold">{{ Translator::translate('Ditutup', $locale, 'id') }}</div>
                <div>{{ $project->close_at->format('F d, Y') }}</div>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <div class="fw-bold">{{ Translator::translate('Tahun', $locale, 'id') }}</div>
                <div>{{ $project->open_at->format('Y') }}</div>
            </div>
                <div class="spacer-double"></div>

            <h5 class="text-uppercase mb-4">{{ Translator::translate('Proyek Lainnya', $locale, 'id') }}</h5>
                @foreach ($recentProjects as $value)
                <div class="mb-3">
                    <a href="{{ route('frontend-project.show', ['id' => $value->id]) }}" class="fw-semibold">
                        {{ Translator::translate($value->title) }}
                    </a>
                    <br>
                    <small><i class="far fa-calendar"></i> {{ $value->open_at->format('F d, Y') }}</small>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection