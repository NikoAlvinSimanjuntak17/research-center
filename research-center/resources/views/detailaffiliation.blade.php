@include('layouts.header')

<section class="page-header">
    <div class="page-header__bg" style="background-image: url('{{ asset('images/bg.jpg') }}');"></div>
    <!-- /.page-header__bg -->
    <div class="container">
        <h2 class="page-header__title">Affiliation: {{ $institution->name ?? 'Tidak Diketahui' }}</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ route('affiliation') }}">Institutions</a></li>
            <li><span>{{ $institution->name ?? '-' }}</span></li>
        </ul>
    </div>
</section>

<!-- -->
<section class="service-details">
    <div class="container">
        <div class="row gutter-y-30">
            <div class="col">
                <div class="service-details__single">
                    <div class="service-details__single-inner">
                        
                        <div class="row gutter-y-30">
                            
                            <!-- Jumlah Departemen -->
                            <div class="col-md-6">
                                <div class="service-details__inner-item wow fadeInUp" data-wow-delay="300ms">
                                    <div class="item-icon">
                                        <div class="icon">
                                            <i class="icon-clients"></i>
                                        </div>
                                    </div>
                                    <div class="item-content">
                                        <a href="{{ route('department', $institution->id) }}">
                                            <h4 class="item__title">Departments</h4>
                                        </a>
                                        <p class="item__dec">{{ $totalDepartments }} Departments</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Jumlah Publikasi -->
                            <div class="col-md-6">
                                <div class="service-details__inner-item wow fadeInUp" data-wow-delay="300ms">
                                    <div class="item-icon">
                                        <div class="icon">
                                            <i class="icon-research-1"></i>
                                        </div>
                                    </div>
                                    <div class="item-content">
                                        <h4 class="item__title">Publications</h4>
                                        <p class="item__dec">{{ $totalPublications }} Publications</p>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="">
    <div class="container">
        <div class="sec-title text-center">
            <h3 class="sec-title__title">{{ $institution->name }}</h3>
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
                <div class="tab active-tab" id="orcid">
                    <div class="row">
                        @forelse($orcidPublications as $pub)
                            <div class="col-md-12 mb-3">
                            <a href="https://doi.org/{{ $pub->doi }}" target="_blank"><h4 class="about-fore__feature__title">{{ $pub->title }}</h4></a>
                                <small>{{ $pub->authors }}</small><br>
                                <small>{{ $pub->publication_date }}</small>
                            </div>
                            <hr>
                        @empty
                            <p class="text-center">Tidak ada publikasi ORCID.</p>
                        @endforelse
                    </div>
                </div>

                {{-- SCOPUS --}}
                <div class="tab" id="scopus">
                    <div class="row">
                        @forelse($scopusPublications as $pub)
                            <div class="col-md-12 mb-3">
                            <a href="https://doi.org/{{ $pub->doi }}" target="_blank"><h4 class="about-fore__feature__title">{{ $pub->title }}</h4></a>
                                <small>{{ $pub->authors }}</small><br>
                                <small>{{ $pub->publication_date }}</small>
                            </div>
                        @empty
                            <p class="text-center">Tidak ada publikasi SCOPUS.</p>
                        @endforelse
                    </div>
                </div>

                {{-- GOOGLE SCHOLAR --}}
                <div class="tab" id="googlescholar">
                    <div class="row">
                        @forelse($googleScholarPublications as $pub)
                            <div class="col-md-12 mb-3">
                            <a href="https://scholar.google.com/scholar?q=intitle:'{{ urlencode($pub->title) }}'" target="_blank"><h4 class="about-fore__feature__title">{{ $pub->title }}</h4></a>
                                <small>{{ $pub->authors }}</small><br>
                                <small>{{ $pub->publication_date }}</small>
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