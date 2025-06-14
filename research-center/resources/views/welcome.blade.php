@include('layouts.header')

<!-- main-slider-start -->
<section class="main-slider-one">
    <div class="main-slider-one__carousel laboix-owl__carousel owl-carousel" data-owl-options='{
        "loop": true,
        "animateOut": "fadeOut",
        "animateIn": "fadeIn",
        "items": 1,
        "autoplay": true,
        "autoplayTimeout": 7000,
        "smartSpeed": 1000,
        "nav": false,
        "dots": true,
        "margin": 0
    }'>

        @foreach($sliders as $slider)
            <div class="item">
                <div class="main-slider-one__item">
                    <div class="main-slider-one__bg" style="background-image: url('{{ asset('storage/' . $slider->image) }}')"></div>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="main-slider-one__content">
                                    <h5 class="main-slider-one__sub-title">{{ $slider->title }}</h5>
                                    <h2 class="main-slider-one__title">{{ strip_tags($slider->description) }}</h2>
                                    @if($slider->link)
                                        <div class="main-slider-one__btn">
                                            <a href="{{ $slider->link }}" class="laboix-btn">Get Started</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-slider-one__shape main-slider-one__shape--one">
                        <img src="{{ asset('images/shapes/hero-1-1.png') }}" alt>
                    </div>
                    <div class="main-slider-one__shape main-slider-one__shape--two">
                        <img src="{{ asset('images/shapes/hero-1-2.png') }}" alt>
                    </div>
                    <div class="main-slider-one__shape main-slider-one__shape--three">
                        <img src="{{ asset('images/shapes/hero-1-3.png') }}" alt>
                    </div>
                    <div class="main-slider-one__shape main-slider-one__shape--fore">
                        <img src="{{ asset('images/shapes/hero-1-4.png') }}" alt>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</section>
<!-- main-slider-end -->
        <!-- About Two section start -->
        <section class="about-two">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="about-two__left wow fadeInLeft" data-wow-duration="700ms" data-wow-delay="500ms">
                            <div class="about-two__thumb">
                                <div class="about-two__thumb__item">
                                    <img src="{{ $about && $about->image ? asset('storage/' . $about->image) : asset('assets/images/tstthh2.jpg') }}" alt="about image">
                                </div>
                                <div class="about-two__thumb__item about-two__thumb__item--two">
                                    <div class="about-two__items">
                                        <div class="about-two__box">
                                            <div class="about-two__box__icon">
                                                <i class="icon-chatting"></i>
                                            </div>
                                            <div class="about-two__box__content">
                                                <span class="about-two__box__subtitle">Call to anytime</span>
                                                <a href="tel:92-3080-808" class="about-two__box__text">+92 3080 808</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-two__right">
                            <div class="about-two__top">
                                <div class="sec-title text-start wow fadeInUp" data-wow-duration='1500ms'>
                                    <h6 class="sec-title__tagline">
                                        <img src="{{ asset('images/shapes/sec-title-s-1.png') }}" alt="About Us" class="sec-title__img">
                                        About Us
                                    </h6>
                                    <h3 class="sec-title__title">{{ $about->title ?? 'About Our Institution' }}</h3>
                                </div>

                                <p class="about-two__top__text">
                                    @if ($about)
                                        {!! $about->description !!}
                                    @else
                                        Konten tentang kami belum tersedia.
                                    @endif
                                </p>
                            </div>


                            {{-- <div class="about-two__feature wow fadeInUp" data-wow-duration="700ms" data-wow-delay="500ms">
                                <div class="about-two__feature__item">
                                    <div class="about-two__feature__icon">
                                        <i class="icon-blood-test-1"></i>
                                    </div>
                                    <h4 class="about-two__feature__title"><a href="services.html">Research</a></h4>
                                    <p class="about-two__feature__text">Research on superior agricultural seeds.</p>
                                </div>
                                <div class="about-two__feature__item">
                                    <div class="about-two__feature__icon">
                                        <i class="icon-accuracy-1"></i> 
                                    </div>
                                    <h4 class="about-two__feature__title"><a href="services.html">Cultivation</a></h4>
                                    <p class="about-two__feature__text">International scale herbal plant cultivation.</p>
                                </div>
                            </div> --}}
                            <ul class="about-two__list list-unstyled wow fadeInUp" data-wow-duration="700ms" data-wow-delay="500ms">
                                <li class="about-two__list__item"><i class="fas fa-check-circle"></i> Manya research has been done</li>
                                <li class="about-two__list__item"><i class="fas fa-check-circle"></i> Many plants are cultivated</li>
                                <li class="about-two__list__item"><i class="fas fa-check-circle"></i> Trusted and Professional</li>
                            </ul>
                            <div class="about-two__link">
                                <a href="{{ route('sejarah')}}" class="about-two__link__btn laboix-btn">Discover More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="about-two__shape">
                <img src="assets/images/shapes/about-shape-2-1.png" alt>
            </div>
            <div class="about-two__shape--two">
                <img src="assets/images/shapes/about-shape-1-1.png" alt>
            </div>
        </section>
        <!-- About Two section End -->
        <section class="service-page service-page--one">
            <div class="service-page__bg" style="background-image: url(images/shapes/service-shape-1-1.png);"></div>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="sec-title text-center wow fadeInUp" data-wow-duration='1500ms'>
                            <h6 class="sec-title__tagline"><img src="{{ asset('images/shapes/sec-title-s-1.png')}}" alt="our Service" class="sec-title__img">latest update</h6><!-- /.sec-title__tagline -->
                            <h3 class="sec-title__title">News and Information</h3><!-- /.sec-title__title -->
                        </div><!-- /.sec-title -->
                    </div>
                </div>
<div class="row gutter-y-30">
    @foreach ($news as $item)
        <div class="col-md-6 col-lg-4">
            <div class="blog-card wow fadeInUp" data-wow-duration='1500ms'>
                <div class="blog-card__image">
                    <div class="blog-card__image__item">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                        <a href="" class="blog-card__image__link"></a>
                    </div>
                    <div class="blog-card__date">
                        <span class="blog-card__date__day">{{ $item->created_at->format('d') }}</span>
                        {{ strtoupper($item->created_at->format('M')) }}
                    </div>
                </div>
                <div class="blog-card__content">
                    <div class="blog-card__author">
                        <div class="blog-card__author__item">
                            
                            <div class="blog-card__author__content">
                            <h6 class="blog-card__author__name">{{ $item->category->name ?? 'Tanpa Kategori' }}</h6>
                                <span class="blog-card__author__deg">TSTH</span>
                            </div>
                        </div>
                    </div>
                    <h3 class="blog-card__title">
                        <a href="">{{ \Illuminate\Support\Str::limit($item->title, 60) }}</a>
                    </h3>
                    <div class="blog-card__content__btn">
                        <a href="" class="blog-card__content__btn__link">Read More<i class="icon-arrow"></i></a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

</div>
</section>

<section class="our-work">
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="sec-title text-center wow fadeInUp" data-wow-duration='700ms'>
                <h6 class="sec-title__tagline">
                    <img src="{{ asset('images/shapes/sec-title-s-1.png') }}" alt="Our work Steps" class="sec-title__img">
                    Vision Mission
                </h6>
                <h3 class="sec-title__title">Our work-steps<br> vision to action</h3>
            </div>
        </div>
    </div>
    <div class="row gutter-y-30 justify-content-center gx-4 gy-4">
        @foreach($visiMisi as $item)
            <div class="col-lg-6 col-md-6">
                <div class="our-work__item">
                    <div class="our-work__item__step"></div>
                    <div class="our-work__item__content">
                        <h4 class="our-work__item__title">
                            <a href="#">{{ \Illuminate\Support\Str::limit($item->title, 40) }}</a>
                        </h4>
                        <p class="our-work__item__text">
                            {!! $item->description !!}
                        </p>

                        <div class="our-work__item__shape">
                            <img src="{{ asset('assets/images/shapes/work-teps.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</section>

        <section class="team-one team-one--home" style="margin-bottom: 200px">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="sec-title text-center wow fadeInUp" data-wow-duration='1500ms'>
                            <h6 class="sec-title__tagline"><img src="images/shapes/sec-title-s-1.png" alt="Our Specialist" class="sec-title__img">Our Specialist</h6><!-- /.sec-title__tagline -->
                            <h3 class="sec-title__title">Meet Our experience <br> specialist</h3><!-- /.sec-title__title -->
                        </div><!-- /.sec-title -->
                    </div>
                </div>
<div class="row gutter-y-30 justify-content-center">
    @foreach ($researchers as $researcher)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center">
            <div class="team-card wow fadeInUp" data-wow-duration="1200ms" data-wow-delay="{{ 400 + $loop->index * 100 }}ms" 
                style="width: 100%; max-width: 400px; border-radius: 12px; overflow: hidden;">
                <div class="team-card__inner">
                    <div class="team-card__image">
                        <img 
                            src="{{ $researcher->image ? asset('storage/' . $researcher->image) : asset('assets/images/team/team-1-1.jpg') }}" 
                            alt="{{ $researcher->user->name ?? 'Researcher' }}"
                            style="height: 400px; object-fit: cover; width: 100%;">
                    </div>
                    <div class="team-card__content" style="padding: 16px;">
                        <div class="team-card__content__inner">
                            <div class="team-card__content__item">
                                <h4 class="team-card__content__title" style="font-size: 16px; margin-bottom: 4px;">
                                    <a href="#">{{ $researcher->user->name ?? 'No Name' }}</a>
                                </h4>
                                <h6 class="team-card__content__designation" style="font-size: 13px; color: #666;">
                                    {{ $researcher->academic_position ?? 'Researcher' }}
                                </h6>
                            </div>
                            <div class="team-card__content__hover mt-2">
                                <div class="team-card__content__hover__social">
                                    @if ($researcher->orcid_id)
                                        <a href="https://orcid.org/{{ $researcher->orcid_id }}" target="_blank">
                                            <i class="fab fa-orcid"></i>
                                        </a>
                                    @endif
                                    @if ($researcher->googlescholar_id)
                                        <a href="https://scholar.google.com/citations?user={{ $researcher->googlescholar_id }}" target="_blank">
                                            <i class="fab fa-google"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div><!-- /.team-card__content -->
                </div>
            </div>
        </div>
    @endforeach
</div>




            </div><!-- /.container -->
        </section>

        <section class="case-studies">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="sec-title text-center wow fadeInUp" data-wow-duration='700ms'>
                            <h6 class="sec-title__tagline"><img src="{{ asset('images/shapes/sec-title-s-1.png')}}" alt="Case studies" class="sec-title__img">Galleries</h6><!-- /.sec-title__tagline -->
                            <h3 class="sec-title__title">Latest Capture Moment</h3><!-- /.sec-title__title -->
                        </div><!-- /.sec-title -->
                    </div>
                </div>
<ul class="case-studies__list list-unstyled">
    @foreach($galleries as $index => $gallery)
        <li class="case-studies__list__item wow fadeInUp" data-wow-duration="700ms" data-wow-delay="{{ 500 + ($index * 100) }}ms">
            <div class="case-studies__list__item__content">
                {{-- Bootstrap Carousel --}}
                <div id="carouselGallery{{ $gallery->id }}" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($gallery->files as $i => $file)
                            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $file->image) }}" class="d-block w-100" alt="{{ $gallery->title }}">
                            </div>
                        @endforeach
                    </div>
                    {{-- @if($gallery->files->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselGallery{{ $gallery->id }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselGallery{{ $gallery->id }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    @endif --}}
                </div>

                {{-- Text --}}
                <div class="case-studies__list__item__hover mt-3">
                    <h4 class="case-studies__list__item__title">
                        <a href="#">{{ $gallery->title }}</a>
                    </h4><br>
                    <p class="case-studies__list__item__text">{!! $gallery->description !!}</p>
                </div>
            </div>
        </li>
    @endforeach
</ul>



            </div>
        </section>




        @include('layouts.footer')