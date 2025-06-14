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

<section class="team-details">
    <div class="container">
        <div class="team-details__inner">
            <div class="row">
                <div class="col-md-5">
                    <div class="team-details__image wow fadeInLeft" data-wow-delay='500ms'>
                        <img src="{{ $researcher->image ? asset('storage/' . $researcher->image) : asset('images/team/default.jpg') }}" 
                        alt="{{ $researcher->user->name }}" 
                        style="width: 100%; object-fit: cover; aspect-ratio: 370 / 431;">
                    </div>
                </div>
                
                <div class="col-md-7">
                    <div class="team-details__content">
                        <h6 class="team-details__content__subtitle wow fadeInUp" data-wow-delay='500ms'>
                            Peneliti
                        </h6>
                        <h3 class="team-details__content__title wow fadeInUp" data-wow-delay='500ms'>
                            {{ $researcher->user->name }}
                        </h3>
                        <p class="team-details__content__text wow fadeInUp" data-wow-delay='500ms'>
                            {{ $researcher->bio ?? 'Belum ada deskripsi singkat.' }}
                        </p>
                        <div class="team-details__content__highlight wow fadeInUp" data-wow-delay='500ms'>
                            @if($researcher->department && $researcher->department->institution)
                            <a href="{{ route('affiliations.detail', ['institution' => $researcher->department->institution->id]) }}">
                                <span class="team-details__content__highlight__text">
                                {{ $researcher->department->institution->name ?? 'Belum ditentukan' }}
                                </span>
                            </a>
                            @else
                            <span class="team-details__content__highlight__text">Belum ditentukan</span>
                            @endif
                            @if($researcher->department)
                            <p class="text-muted mb-3 wow fadeInUp" data-wow-delay='500ms'>
                                Departemen: {{ $researcher->department->name }}
                            </p>
                            @endif
                        </div>
                            
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
                    <h6 class="sec-title__tagline"><img src="{{ asset('images/shapes/sec-title-s-1.png')}}" alt="Pricing Plane" class="sec-title__img">Daftar Publikasi</h6>
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

@include('layouts.footer')