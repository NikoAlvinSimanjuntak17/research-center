@extends('layout.frontend.main', ['activePage' => 'frontend-study-centre.view', 'titlePage' => __('View Pusat Studi')])
@section('css')
<link rel="stylesheet" href="{{ asset('frontend/gardyn/css/laboix.css') }}">

@section('title','View Pusat Studi')

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
                        <li class="active">Publikasi</li>
                    </ul>
                    <h1 class="text-uppercase">Publikasi Peneliti</h1>
                    <p class="col-lg-10 lead">Temukan berbagai Publikasi penelitian kami yang inovasi dan terpecaya.</p>
                </div>
            </div>
        </div>
        <img src="{{ asset('frontend/gardyn/images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
        <div class="de-gradient-edge-top dark"></div>
        <div class="de-overlay"></div>
    </section>

<section class="team-details">
    <div class="container">
        <div class="team-details__inner">
            <div class="row">
                <div class="col-md-5">
                    <div class="team-details__image wow fadeInLeft" data-wow-delay='500ms'>
                        <img src="{{ $researcher->image ? asset('storage/' . $researcher->image) : asset('images/default.jpg') }}" 
                        alt="{{ $researcher->user->name }}" 
                        style="width: 100%; object-fit: cover; aspect-ratio: 370 / 431;">
                    </div>
                </div>
                
                <div class="col-md-7">
                    <div class="team-details__content">
                        <h6 class="team-details__content__subtitle wow fadeInUp" data-wow-delay='500ms'>
                            {{ $researcher->academic_position ?? 'Peneliti' }}
                        </h6>
                        <h3 class="team-details__content__title wow fadeInUp" data-wow-delay='500ms'>
                            {{ $researcher->user->name }}
                        </h3>
                        
                            
                            <ul class="list-unstyled team-details__list wow fadeInUp" data-wow-delay='500ms'>
                                <li><span class="team-details__list__item__name">Email:</span> 
                                    <a href="mailto:{{ $researcher->user->email }}">{{ $researcher->user->email }}</a>
                                </li>
                                <li><span class="team-details__list__item__name">Telepon:</span> 
                                    {{ $researcher->phone ?? '-' }}
                                </li>
                                <li><span class="team-details__list__item__name">ORCID ID:</span> 
                                    <a href="https://orcid.org/{{ $researcher->orcid_id }}" target="_blank">
                                    {{ $researcher->orcid_id ?? 'Tidak ada ORCID' }}
                                    </a>
                                </li>
                                <li><span class="team-details__list__item__name">Scopus ID:</span> 
                                    <a href="https://www.scopus.com/authid/detail.uri?authorId={{ $researcher->scopus_id }}" target="_blank">
                                    {{ $researcher->scopus_id ?? 'Tidak ada Scopus ID' }}
                                    </a>
                                </li>
                                <li><span class="team-details__list__item__name">Google Scholar ID:</span> 
                                    <a href="https://scholar.google.com/citations?user={{ $researcher->googlescholar_id }}" target="_blank">
                                    {{ $researcher->googlescholar_id ?? 'Tidak ada Google Scholar ID' }}
                                    </a>
                                </li>
                            </ul>
                            
                            <div class="team-details__social wow fadeInUp" data-wow-delay='500ms'>
                            @if($researcher->twitter)
                                <a href="{{ $researcher->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a>
                            @endif
                            @if($researcher->linkedin)
                                <a href="{{ $researcher->linkedin }}" target="_blank"><i class="fab fa-linkedin"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="team-details">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="sec-title text-center wow fadeInUp" data-wow-duration='700ms'>
                    <h6 class="sec-title__tagline">Daftar Publikasi</h6>
                    <h3 class="sec-title__title">Pilih Sumber Publikasi</h3>
                </div>
            </div>
        </div>
        <div class="tabs-box">
            <div class="price-page wow fadeInUp" data-wow-delay='500ms'>
                <div class="price-page__inner__filter text-center">
                    <button data-tab="#orcid" class="price-page__inner__btn laboix-btn tab-btn active-btn">ORCID</button>
                    <button data-tab="#scopus" class="price-page__inner__btn laboix-btn tab-btn">SCOPUS</button>
                    <button data-tab="#googlescholar" class="price-page__inner__btn laboix-btn tab-btn">Google Scholar</button>
                </div>
            </div>
            <div class="tabs-content">
                {{-- ORCID --}}
                <div class="price-page__inner__item fadeInUp animated tab active-tab" id="orcid">
                    <div class="row">
                        <div class="col-12">
                            <div class="faq-page__accordion" data-grp-name="laboix-accrodion">
                                @foreach($orcidPublications as $pub)
                                <div class="accrodion">
                                    <div class="accrodion-title">
                                    <a href="https://doi.org/{{ $pub->doi }}" target="_blank"><h4 class="about-fore__feature__title">{{ $pub->title }}</h4></a>
                                    </div>
                                    <div class="accrodion-content">
                                        <div class="inner">
                                            <p class="inner__text">
                                                <strong>Author:</strong> {{ $pub['authors'] ?? 'Tidak Diketahui' }} <br>
                                                
                                                <strong>Tahun:</strong> {{ \Carbon\Carbon::parse($pub['publication_date'] ?? '')->format('d M, Y') }} <br>
                                                
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SCOPUS --}}
                <div class="price-page__inner__item fadeInUp animated tab" id="scopus">
                    <div class="row">
                        <div class="col-12">
                            <div class="faq-page__accordion" data-grp-name="laboix-accrodion">
                                @foreach($scopusPublications as $pub)
                                <div class="accrodion">
                                    <div class="accrodion-title">
                                    <a href="https://doi.org/{{ $pub->doi }}" target="_blank"><h4 class="about-fore__feature__title">{{ $pub->title }}</h4></a>
                                    </div>
                                    <div class="accrodion-content">
                                        <div class="inner">
                                            <p class="inner__text">
                                                <strong>Author:</strong> {{ $pub['authors'] ?? 'Tidak Diketahui' }} <br>
                                                <strong>Journal:</strong> {{ $pub['journal'] ?? 'Tidak Diketahui' }} <br>
                                                <strong>Tahun:</strong> {{ \Carbon\Carbon::parse($pub['publication_date'] ?? '')->format('d M, Y') }} <br>
                                                
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Google Scholar --}}
                <div class="price-page__inner__item fadeInUp animated tab" id="googlescholar">
                    <div class="row">
                        <div class="col-12">
                            <div class="faq-page__accordion" data-grp-name="laboix-accrodion">
                                @foreach($googleScholarPublications as $pub)
                                <div class="accrodion">
                                    <div class="accrodion-title">
                                    <a href="https://scholar.google.com/scholar?q=intitle:'{{ urlencode($pub->title) }}'" target="_blank"><h4 class="about-fore__feature__title">{{ $pub->title }}</h4></a>  
                                    </div>
                                    <div class="accrodion-content">
                                        <div class="inner">
                                            <p class="inner__text">
                                                <strong>Author:</strong> {{ $pub['authors'] ?? 'Tidak Diketahui' }} <br>
                                                <strong>Journal:</strong> {{ $pub['journal'] ?? 'Tidak Diketahui' }} <br>
                                                <strong>Tahun:</strong> {{ \Carbon\Carbon::parse($pub['publication_date'] ?? '')->format('d M, Y') }} <br>
                                                
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script src="{{ asset('frontend/gardyn/js/laboix.js') }}"></script>
@endpush