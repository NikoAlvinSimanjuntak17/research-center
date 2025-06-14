@include('layouts.header')

<section class="page-header">
    <div class="page-header__bg" style="background-image: url('{{ asset('images/bg.jpg') }}');"></div>
    <div class="container">
    <!-- /.page-header__bg -->
        <h2 class="page-header__title">Publication</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="index.html">Home</a></li>
            <li><span></span></li>
        </ul><!-- /.thm-breadcrumb list-unstyled -->
    </div><!-- /.container -->
</section><!-- /.page-header -->

<section class="about-fore">
    <div class="container">
        <div class="row gutter-y-30">
            <div class="col-md-3">
                <div class="service-details__inner-item wow fadeInUp " data-wow-delay="300ms">
                    <div class="item-icon">
                        <div class="icon">
                            <i class="icon-chemistry-1"></i>
                        </div>
                    </div>
                    <div class="item-content">
                        <h4 class="item__title">Total Publications</h4>
                        <p class="item__dec">{{ $totalPublications }} Publications</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="service-details__inner-item wow fadeInUp " data-wow-delay="300ms">
                    <div class="item-icon">
                        <div class="icon">
                            <i class="icon-safe"></i>
                        </div>
                    </div>
                    <div class="item-content">
                        <h4 class="item__title">ORCID Publications</h4>
                        <p class="item__dec">{{ $orcidCount }} Publications</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="service-details__inner-item wow fadeInUp " data-wow-delay="300ms">
                    <div class="item-icon">
                        <div class="icon">
                            <i class="icon-safe"></i>
                        </div>
                    </div>
                    <div class="item-content">
                        <h4 class="item__title">Scopus Publications</h4>
                        <p class="item__dec">{{ $scopusCount }} Publications</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="service-details__inner-item wow fadeInUp " data-wow-delay="300ms">
                    <div class="item-icon">
                        <div class="icon">
                            <i class="icon-safe"></i>
                        </div>
                    </div>
                    <div class="item-content">
                        <h4 class="item__title">Google Scholar</h4>
                        <p class="item__dec">{{ $googleScholarCount }} Publications</p>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="">
                <div class="about-fore__left"> 
                    <ul class="about-fore__feature list-unstyled">
                        @foreach ($publications as $pub)
                        <li class="about-fore__feature__item">  
                            <div class="about-fore__feature__content">
                                
                                @if($pub->source == 'scopus' || $pub->source == 'orcid')
                                <!-- Jika Scopus atau ORCID, tampilkan DOI -->
                                <a href="https://doi.org/{{ $pub->doi }}" target="_blank"><h4 class="about-fore__feature__title">{{ $pub->title }}</h4></a>
                                @elseif($pub->source == 'googlescholar')
                                <!-- Jika Google Scholar, buat URL pencarian berdasarkan judul -->
                                <a href="https://scholar.google.com/scholar?q=intitle:'{{ urlencode($pub->title) }}'" target="_blank"><h4 class="about-fore__feature__title">{{ $pub->title }}</h4></a>
                                @else
                                <!-- Jika tidak ada URL yang tersedia -->
                                Tidak tersedia
                                @endif
                                
                                <p class="about-fore__feature__text"><strong>Author:</strong> {{ $pub->authors ?? 'Anonim' }}</p>
                                <p class="about-fore__feature__text"><strong>Date:</strong> {{ \Carbon\Carbon::parse($pub->publication_date)->format('d M, Y') }}</p>
                                <p class="about-fore__feature__text"><strong>Source: </strong> {{ $pub->source}}</p>
                                <p class="about-fore__feature__text"><strong>Journal:</strong> {{ $pub->journal ?? 'Tidak Diketahui' }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            @if ($publications->hasPages())
            <div class="col-12">
                <div class="pronation_widget wow fadeInUp" data-wow-delay="300ms">
                    <ul class="d-flex justify-content-center list-unstyled">
                        {{-- Previous --}}
                        @if ($publications->onFirstPage())
                        <li><span class="disabled"><i class="fas fa-angle-left"></i></span></li>
                        @else
                        <li><a href="{{ $publications->previousPageUrl() }}"><i class="fas fa-angle-left"></i></a></li>
                        @endif
                        
                        {{-- Pages --}}
                        @foreach ($publications->getUrlRange(1, $publications->lastPage()) as $page => $url)
                        <li>
                            <a href="{{ $url }}" class="{{ $page == $publications->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                        </li>
                        @endforeach
                        
                        {{-- Next --}}
                        @if ($publications->hasMorePages())
                        <li><a href="{{ $publications->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a></li>
                        @else
                        <li><span class="disabled"><i class="fas fa-angle-right"></i></span></li>
                        @endif
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@include('layouts.footer')


