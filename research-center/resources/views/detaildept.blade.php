@include('layouts.header')

<section class="page-header">
    <div class="page-header__bg" style="background-image: url('{{ asset('images/bg.jpg') }}');"></div>
    <!-- /.page-header__bg -->
    <div class="container">
        <h2 class="page-header__title">
            Departemen: {{ $department->name }} - {{ $department->institution->name }}
        </h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ route('affiliation') }}">Institutions</a></li>
            <li><span>{{ $department->name }}</span></li>
        </ul>
    </div>
</section>

<section class="team-details mt-5">
    <div class="container">
        <div class="sec-title text-center">
            <h6 class="sec-title__tagline">Publikasi Departemen</h6>
            <h3 class="sec-title__title">{{ $department->name }}</h3>
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
                <div class="tab price-page__inner__item fadeInUp animated active-tab" id="orcid">
                    <div class="row">
                        @forelse($orcidPublications as $pub)
                            <div class="col-md-12 mb-3">
                                        <a href="https://doi.org/{{ $pub->doi }}" target="_blank"><h4 class="about-fore__feature__title">{{ $pub->title }}</h4></a>
                                <small>{{ $pub->authors }}</small><br>
                                <small>{{ \Carbon\Carbon::parse($pub->publication_date)->format('d M Y') }}</small><br>
                                @if($pub->url)
                                    <a href="{{ $pub->url }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">Lihat Detail</a>
                                @endif
                                <hr>
                            </div>
                        @empty
                            <p class="text-center">Tidak ada publikasi ORCID.</p>
                        @endforelse
                    </div>
                </div>

                {{-- SCOPUS --}}
                <div class="tab price-page__inner__item fadeInUp animated" id="scopus">
                    <div class="row">
                        @forelse($scopusPublications as $pub)
                            <div class="col-md-12 mb-3">
                          
                                        <!-- Jika Scopus atau ORCID, tampilkan DOI -->
                                        <a href="https://doi.org/{{ $pub->doi }}" target="_blank"><h4 class="about-fore__feature__title">{{ $pub->title }}</h4></a>
                                    
                                <small>{{ $pub->authors }}</small><br>
                                <small>{{ \Carbon\Carbon::parse($pub->publication_date)->format('d M Y') }}</small><br>
                                @if($pub->url)
                                    <a href="{{ $pub->url }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">Lihat Detail</a>
                                @endif
                                <hr>
                            </div>
                        @empty
                            <p class="text-center">Tidak ada publikasi SCOPUS.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Google Scholar --}}
                <div class="tab price-page__inner__item fadeInUp animated" id="googlescholar">
                    <div class="row">
                        @forelse($googleScholarPublications as $pub)
                            <div class="col-md-12 mb-3">
                                <!-- Jika Google Scholar, buat URL pencarian berdasarkan judul -->
                                <a href="https://scholar.google.com/scholar?q=intitle:'{{ urlencode($pub->title) }}'" target="_blank"><h4 class="about-fore__feature__title">{{ $pub->title }}</h4></a>  
                                <small>{{ $pub->authors }}</small><br>
                                <small>{{ \Carbon\Carbon::parse($pub->publication_date)->format('d M Y') }}</small><br>
                                @if($pub->url)
                                <a href="{{ $pub->url }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">Lihat Detail</a>
                                @endif
                                <hr>
                            </div>
                            @empty
                            <p class="text-center">Tidak ada publikasi Google Scholar.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('layouts.footer')
