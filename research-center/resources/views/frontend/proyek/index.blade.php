@php
    use App\Helpers\Translator;
    $locale = app()->getLocale();
@endphp

@extends('layout.frontend.main', ['activePage' => 'index', 'titlePage' => __('Daftar Proyek')])
@section('title', 'Daftar Proyek')

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
                        <li class="active">{{ Translator::translate('Proyek', $locale, 'id') }}</li>                    </ul>
                        <h1 class="text-uppercase">{{ Translator::translate('Proyek', $locale, 'id') }}</h1>
                        <p class="col-lg-10 lead">{{ Translator::translate('Temukan berbagai Proyek penelitian kami yang inovasi dan terpecaya.', $locale, 'id') }}</p>
                </div>
            </div>
        </div>
        <img src="{{ asset('images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
        <div class="de-gradient-edge-top dark"></div>
        <div class="de-overlay"></div>
    </section>

<section class="py-120 bg-light">
    <div class="container">
        <div class="row g-4 mb-3 align-items-center justify-content-center">
            <div class="col-lg-6 text-center">
                <div class="subtitle wow fadeInUp">{{ Translator::translate('Proyek Kolaborasi', $locale, 'id') }}</div>
                <h2 class="text-uppercase wow fadeInUp" data-wow-delay=".2s">
                    {{ Translator::translate('Daftar', $locale, 'id') }} <span class="id-color-2">{{ Translator::translate('Proyek', $locale, 'id') }}</span>
                </h2>
                <p>{{ Translator::translate('Lihat semua proyek yang sedang dibuka untuk kolaborasi bersama Tim Peneliti TSTH2', $locale, 'id') }}</p>
            </div>
        </div>

        <div class="row g-4">
            @forelse ($projects as $i => $project)
                <div class="col-lg-4 col-md-6 wow fadeInUp">
                    <div class="relative h-100 {{ $i % 2 == 0 ? 'bg-color' : 'bg-color-2' }} text-light padding30 rounded-1">
                        <img src="{{ asset('images/logo-icon.webp') }}" class="w-50px mb-3" alt="">
                        <div class="abs m-3 top-0 end-0 p-2 rounded-2 mb-3">{{ sprintf('%02d', $i + 1) }}</div>
                        <div>
                            <h4 class="text-light">{{ $project->title }}</h4>
                            <p class="mb-1"><i class="ph-calendar-blank"></i> {{ Translator::translate('Dibuka', $locale, 'id') }} : {{ \Carbon\Carbon::parse($project->open_at)->format('d M Y') }}</p>
                            <p class="mb-3"><i class="ph-user"></i> {{ Translator::translate('Oleh', $locale, 'id') }} : {{ $project->creator->name ?? 'Admin TSTH2' }}</p>
                            <a href="{{ route('frontend-project.show', ['id' => $project->id]) }}" class="theme-btn text-uppercase">
                                {{ Translator::translate('Lihat Detail', $locale, 'id') }} <i class="fas fa-arrow-right-long"></i><i class="fas fa-arrow-right-long"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>{{ Translator::translate('Tidak ada proyek terbuka saat ini.', $locale, 'id') }}</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="pagination-area mt-5">
            <div aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    {{ $projects->links() }}
                </ul>
            </div>
        </div>

        {{-- Closed Projects --}}
        @if($closedProjects->count())
            <div class="row mt-5 pt-5 border-top">
                <div class="col-lg-12 text-center mb-4">
                <h4>{{ Translator::translate('Proyek Yang Sudah Ditutup', $locale, 'id') }}</h4>    
                </div>
                @foreach ($closedProjects as $i => $project)
                    <div class="col-lg-4 col-md-6 wow fadeInUp">
                        <div class="relative h-100 bg-secondary text-light padding30 rounded-1">
                            <img src="{{ asset('images/logo-icon.webp') }}" class="w-50px mb-3" alt="">
                            <div class="abs m-3 top-0 end-0 p-2 rounded-2 mb-3">{{ sprintf('%02d', $i + 1) }}</div>
                            <div>
                                <h4 class="text-light">{{ $project->title }}</h4>
                                    <p class="mb-1"><i class="ph-calendar-blank"></i> {{ Translator::translate('Ditutup', $locale, 'id') }}: {{ \Carbon\Carbon::parse($project->close_at)->format('d M Y') }}</p>
                                    <span class="badge bg-dark">{{ Translator::translate('Ditutup', $locale, 'id') }}</span>

                                <br><br>
                                <a href="{{ route('frontend-project.show', ['id' => $project->id]) }}" class="theme-btn">
                                    {{ Translator::translate('Lihat Detail', $locale, 'id') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection