<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Research Centre - TSTH2</title>
    <link rel="icon" href="{{ asset('frontend/gardyn/images/icon.webp') }}" type="image/gif" sizes="16x16">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <meta content="Gardyn — Garden and Landscape Website Template" name="description" >
    <meta content="" name="keywords" >
    <meta content="" name="author" >
    <!-- CSS Files
    ================================================== -->
    <link href="{{ asset('frontend/gardyn/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap">
    <link href="{{ asset('frontend/gardyn/css/plugins.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('frontend/gardyn/css/swiper.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('frontend/gardyn/css/style.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('frontend/gardyn/css/coloring.css') }}" rel="stylesheet" type="text/css" >
    <!-- color scheme -->
    <link id="colors" href="{{ asset('frontend/gardyn/css/colors/scheme-01.css') }}" rel="stylesheet" type="text/css" >

</head>

<body>
    <div id="wrapper">
        <a href="#" id="back-to-top"></a>
        
        <!-- preloader begin -->
        <div id="de-loader"></div>
        <!-- preloader end -->

        <!-- header begin -->
        <header class="transparent">
            <div id="topbar">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-between xs-hide">
                                <div class="d-flex">
                                    <div class="topbar-widget me-3"><a href="#"><i class="icofont-bank-alt"></i>Taman Sains Teknologi Herbal dan Hortikultura (TSTH2)</a></div>
                                    <div class="topbar-widget me-3"><a href="#"><i class="icofont-location-pin"></i>Aek Nauli I, Pollung, Humbang Hasundutan, Sumatera Utara</a></div>
                                    <div class="topbar-widget me-3"><a href="#"><i class="icofont-envelope"></i>info@tsth2-pollung.org</a></div>
                                </div>

                                <div class="d-flex">
                                    <div class="social-icons">
                                        <a href="#"><i class="fa-brands fa-facebook fa-lg"></i></a>
                                        <a href="#"><i class="fa-brands fa-youtube fa-lg"></i></a>
                                        <a href="#"><i class="fa-brands fa-instagram fa-lg"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>            
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="de-flex sm-pt10">
                            <div class="de-flex-col">
                                <!-- logo begin -->
                                <div id="logo">
                                    <a href="index.html">
                                        <img class="logo-main" src="{{ asset('frontend/gardyn/images/logo_tsth2.png') }}" alt="" >
                                        <img class="logo-mobile" src="{{ asset('frontend/gardyn/images/logo-white.webp') }}" alt="" >
                                    </a>
                                </div>
                                <!-- logo end -->
                            </div>
                            <div class="de-flex-col header-col-mid">
                                <!-- mainemenu begin -->
                                <ul id="mainmenu">
                                    <li><a class="menu-item" href="#">HOME</a></li>
                                    <li><a class="menu-item" href="#">PROFIL</a>
                                        <ul>
                                            <li><a href="#">SEJARAH TSTH2</a></li>
                                            <li><a href="#">SAMBUTAN DIREKTUR TSTH2</a></li>
                                            <li><a href="#">VISI & MISI</a></li>
                                            <li><a href="#">STRUKTUR ORGANISASI</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="menu-item" href="#">PENELITIAN</a>
                                        <ul>
                                            <li><a href="projects.html">KOMODITAS</a></li>
                                            <li><a href="projects-2.html">RISET PENELITIAN</a></li>
                                            <li><a href="projects-2.html">PUBLIKASI PENELITIAN</a></li>
                                            <li><a href="projects-3.html">FASILITAS PENELITIAN</a></li>
                                            <li><a href="projects-4.html">TIM PENELITI</a></li>
                                            <li><a href="project-single.html">KERJA SAMA</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="menu-item" href="#">BERITA</a></li>
                                    <li><a class="menu-item" href="#">GALERI & VIDEO</a></li>
                                    <li><a class="menu-item" href="#">KONTAK</a></li>
                                    
                                </ul>
                                <!-- mainmenu end -->
                            </div>
                            <div class="de-flex-col">
                                <div class="menu_side_area">          
                                    <a href="#" class="btn-main btn-line">HUBUNGI KAMI</a>
                                    <span id="menu-btn"></span>
                                </div>

                                <div id="btn-extra">
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- header end -->

        <!-- content begin -->
        <div class="no-bottom no-top" id="content">

            <div id="top"></div>
            <section id="section-intro" class="text-light no-top no-bottom relative overflow-hidden z-1000">
                <div class="h-30 de-gradient-edge-top op-5 dark z-2"></div>
                <img src="images/logo-wm.webp" class="abs end-0 bottom-0 z-2 w-20" alt="">
                <div class="v-center relative">

                    <div class="swiper">
                      <!-- Additional required wrapper -->
                      <div class="swiper-wrapper">

                        <!-- Slides -->
                        <div class="swiper-slide">
                            <div class="swiper-inner" data-bgimage="url({{ asset('frontend/gardyn/images/slider/5.jpg') }})">
                                <div class="sw-caption z-1000">
                                    <div class="container">
                                        <div class="row g-4 align-items-center">

                                            <div class="spacer-double"></div>

                                            <div class="col-lg-6">     
                                                <div class="spacer-single"></div>
                                                <div class="sw-text-wrapper">
                                                    {{-- <div class="subtitle">Outdoor Elegance</div> --}}
                                                    <h2 class="slider-title mb-4">Riset dan Inovasi Herbal Tingkatkan Kesehatan Indonesia</h2>
                                                    {{-- <a class="btn-main mb10 mb-3" href="projects.html">Our Services</a> --}}
                                                </div>
                                            </div>

                                            <div class="spacer-single"></div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="sw-overlay op-3"></div>
                            </div>
                        </div>                        
                        <!-- Slides -->

                        <!-- Slides -->
                        <div class="swiper-slide">
                            <div class="swiper-inner" data-bgimage="url({{ asset('frontend/gardyn/images/slider/4.jpg') }})">
                                <div class="sw-caption z-1000">
                                    <div class="container">
                                        <div class="row g-4 align-items-center">

                                            <div class="spacer-double"></div>

                                            <div class="col-lg-6">     
                                                <div class="spacer-single"></div>
                                                <div class="sw-text-wrapper">
                                                    {{-- <div class="subtitle">Outdoor Elegance</div> --}}
                                                    <h2 class="slider-title mb-4">Laboratorium Alam dengan Sentuhan Teknologi</h2>
                                                    {{-- <a class="btn-main mb10 mb-3" href="projects.html">Our Services</a> --}}
                                                </div>
                                            </div>

                                            <div class="spacer-single"></div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="sw-overlay op-3"></div>
                            </div>
                        </div>                        
                        <!-- Slides -->                      
                    </div>

                    <!-- If we need navigation buttons -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>

                    </div>
                </div>
            </section>

            {{-- <section id="section-intro" class="text-light no-top no-bottom relative overflow-hidden z-1000">
                <div class="h-30 de-gradient-edge-top op-5 dark z-2"></div>
                <img src="{{ asset('frontend/gardyn/images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
                <div class="v-center relative">

                    <div class="abs abs-centered z-1000 w-100">
                        <div class="container">
                            <div class="row g-4 justify-content-between align-items-center">
                                <div class="col-lg-8">
                                    <h1 class="text-uppercase wow fadeInUp" data-wow-delay=".3s">Transforming Yards Enriching Lives</h1>
                                    <p class="col-lg-10 wow fadeInUp" data-wow-delay=".6s">Imagine stepping into your own outdoor paradise. Something beautiful is blooming soon! Stay tuned as we unveil the secret to transforming your garden into a lush haven.</p>
                                    <div class="spacer-single"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="abs bottom-0 z-1000 w-100">
                        <div class="container pb-lg-5 pb-3">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="bg-blur rounded-1 padding40 py-4 wow fadeInDown" data-wow-delay=".9s">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-md-12">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h4 class="mb-0">Nature's Palette</h4>
                                                    <div class="">
                                                        <a class="btn-main" href="project-single.html">View Project</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper">
                      <!-- Additional required wrapper -->
                      <div class="swiper-wrapper">
                        <!-- Slides -->
                        <div class="swiper-slide">
                            <div class="swiper-inner" data-bgimage="url({{ asset('frontend/gardyn/images/slider/3.jpg') }})">
                                <div class="sw-overlay op-2"></div>
                            </div>
                        </div>
                        <!-- Slides -->

                        <!-- Slides -->
                        <div class="swiper-slide">
                            <div class="swiper-inner" data-bgimage="url({{ asset('frontend/gardyn/images/slider/4.jpg') }})">
                                <div class="sw-overlay op-2"></div>
                            </div>
                        </div>                        
                        <!-- Slides -->

                        <!-- Slides -->
                        <div class="swiper-slide">
                            <div class="swiper-inner" data-bgimage="url({{ asset('frontend/gardyn/images/slider/5.jpg') }})">
                                <div class="sw-overlay op-2"></div>
                            </div>
                        </div>                        
                        <!-- Slides -->

                      </div>

                    </div>
                </div>
            </section>             --}}

            <section class="pb-50">
                <div class="container">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-6">
                            <div class="relative">
                                <div class="rounded-1 bg-body w-90 overflow-hidden wow zoomIn">
                                    <img src="{{ asset('frontend/gardyn/images/misc/1.webp') }}" class="w-100 jarallax wow scaleIn" alt="">
                                </div>
                                <div class="rounded-1 bg-body w-50 abs mb-min-50 end-0 bottom-0 z-2 overflow-hidden shadow-soft wow zoomIn" data-wow-delay=".2s">
                                    <img src="{{ asset('frontend/gardyn/images/misc/2.webp') }}" class="w-100 wow scaleIn" data-wow-delay=".2s" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="ps-lg-3">
                                <div class="subtitle id-color wow fadeInUp" data-wow-delay=".2s">Welcome to Gardyn</div>
                                <h2 class="text-uppercase wow fadeInUp" data-wow-delay=".4s">Crafting Living <span class="id-color-2">Masterpieces</span></h2>
                                <p class="wow fadeInUp" data-wow-delay=".6s">At Gardyn, we’re passionate about turning your garden into a true reflection of your personal style and a haven for relaxation and enjoyment. Whether you’re dreaming of a vibrant floral display, a serene outdoor retreat, or a stunning landscape transformation.</p>
                                <a class="btn-main wow fadeInUp" href="services.html" data-wow-delay=".6s">Our Services</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- marquee section begin -->
            <section class="pt-2 pb-1 bg-light mt90">
                <div class="wow fadeInRight d-flex">
                  <div class="de-marquee-list relative wow">
                    <span class="fs-36 lh-1 mx-4 text-uppercase title-font">01. Garden Design</span>
                    <span class="fs-36 lh-1 mx-4 text-uppercase title-font">02. Garden Maintenance</span>
                    <span class="fs-36 lh-1 mx-4 text-uppercase title-font">03. Decking and Patio</span>
                    <span class="fs-36 lh-1 mx-4 text-uppercase title-font">04. Plant Selection</span>
                    <span class="fs-36 lh-1 mx-4 text-uppercase title-font">05. Garden Irrigation</span>
                    <span class="fs-36 lh-1 mx-4 text-uppercase title-font">06. Outdoor Lighting</span>
                  </div>
                </div>
            </section>
            <!-- marquee section end -->

            <!-- marquee section begin -->
            <section class="pt-2 pb-1 bg-color mb60">
                <div class="wow fadeInLeft d-flex">
                  <div class="de-marquee-list-2 relative wow">
                    <span class="fs-36 lh-1 mx-4 text-white text-uppercase title-font">01. Garden Design</span>
                    <span class="fs-36 lh-1 mx-4 text-white text-uppercase title-font">02. Garden Maintenance</span>
                    <span class="fs-36 lh-1 mx-4 text-white text-uppercase title-font">03. Decking and Patio</span>
                    <span class="fs-36 lh-1 mx-4 text-white text-uppercase title-font">04. Plant Selection</span>
                    <span class="fs-36 lh-1 mx-4 text-white text-uppercase title-font">05. Garden Irrigation</span>
                    <span class="fs-36 lh-1 mx-4 text-white text-uppercase title-font">06. Outdoor Lighting</span>
                  </div>
                </div>
            </section>   
            <!-- marquee section end -->      

            <section class="p-4">
                <div class="container-fluid">
                    <div class="row g-4">
                        <div class="col-lg-3 col-sm-6 wow fadeInRight" data-wow-delay=".0s">
                            <div class="bg-color text-light rounded-1 overflow-hidden">
                                <div class="hover relative overflow-hidden text-light text-center">
                                    <img src="images/services/1.webp" class="hover-scale-1-1 w-100" alt="">
                                    <div class="abs w-100 px-4 hover-op-1 z-4 hover-mt-40 abs-centered">
                                        <a class="btn-line" href="service-single.html">View Details</a>
                                    </div>
                                    <img src="images/logo-icon.webp" class="abs abs-centered w-20" alt="">
                                    <div class="abs bg-color z-2 top-0 w-100 h-100 hover-op-1"></div>
                                    <div class="abs z-2 bottom-0 mb-3 w-100 text-center hover-op-0">
                                        <h4 class="mb-3">Garden Design</h4>
                                    </div>
                                    <div class="gradient-trans-color-bottom abs w-100 h-40 bottom-0 Z-1"></div>
                                </div>

                                <div class="p-4 py-2">
                                    <p class="mt-3">Imagine stepping into your own private oasis—a garden designed just for you, where every plant, path, and stone tells your story.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 wow fadeInRight" data-wow-delay=".3s">
                            <div class="bg-color text-light rounded-1 overflow-hidden">
                                <div class="hover relative overflow-hidden text-light text-center">
                                    <img src="images/services/2.webp" class="hover-scale-1-1 w-100" alt="">
                                    <div class="abs w-100 px-4 hover-op-1 z-4 hover-mt-40 abs-centered">
                                        <a class="btn-line" href="service-single.html">View Details</a>
                                    </div>
                                    <img src="images/logo-icon.webp" class="abs abs-centered w-20" alt="">
                                    <div class="abs bg-color z-2 top-0 w-100 h-100 hover-op-1"></div>
                                    <div class="abs z-2 bottom-0 mb-3 w-100 text-center hover-op-0">
                                        <h4 class="mb-3">Garden Maintenance</h4>
                                    </div>
                                    <div class="gradient-trans-color-bottom abs w-100 h-40 bottom-0 Z-1"></div>
                                </div>

                                <div class="p-4 py-2">
                                    <p class="mt-3">Imagine stepping into your own private oasis—a garden designed just for you, where every plant, path, and stone tells your story.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 wow fadeInRight" data-wow-delay=".6s">
                            <div class="bg-color text-light rounded-1 overflow-hidden">
                                <div class="hover relative overflow-hidden text-light text-center">
                                    <img src="images/services/3.webp" class="hover-scale-1-1 w-100" alt="">
                                    <div class="abs w-100 px-4 hover-op-1 z-4 hover-mt-40 abs-centered">
                                        <a class="btn-line" href="service-single.html">View Details</a>
                                    </div>
                                    <img src="images/logo-icon.webp" class="abs abs-centered w-20" alt="">
                                    <div class="abs bg-color z-2 top-0 w-100 h-100 hover-op-1"></div>
                                    <div class="abs z-2 bottom-0 mb-3 w-100 text-center hover-op-0">
                                        <h4 class="mb-3">Decking and Patio</h4>
                                    </div>
                                    <div class="gradient-trans-color-bottom abs w-100 h-40 bottom-0 Z-1"></div>
                                </div>

                                <div class="p-4 py-2">
                                    <p class="mt-3">Imagine stepping into your own private oasis—a garden designed just for you, where every plant, path, and stone tells your story.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3 col-sm-6 wow fadeInRight" data-wow-delay=".9s">
                            <div class="bg-color text-light rounded-1 overflow-hidden">
                                <div class="hover relative overflow-hidden text-light text-center">
                                    <img src="images/services/4.webp" class="hover-scale-1-1 w-100" alt="">
                                    <div class="abs w-100 px-4 hover-op-1 z-4 hover-mt-40 abs-centered">
                                        <a class="btn-line" href="service-single.html">View Details</a>
                                    </div>
                                    <img src="images/logo-icon.webp" class="abs abs-centered w-20" alt="">
                                    <div class="abs bg-color z-2 top-0 w-100 h-100 hover-op-1"></div>
                                    <div class="abs z-2 bottom-0 mb-3 w-100 text-center hover-op-0">
                                        <h4 class="mb-3">Plant Selection</h4>
                                    </div>
                                    <div class="gradient-trans-color-bottom abs w-100 h-40 bottom-0 Z-1"></div>
                                </div>

                                <div class="p-4 py-2">
                                    <p class="mt-3">Imagine stepping into your own private oasis—a garden designed just for you, where every plant, path, and stone tells your story.</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </section>
            
            <section class="jarallax text-light relative">
                <img src="images/background/8.webp" class="jarallax-img" alt="">
                <div class="de-overlay"></div>
                <div class="container relative z-1">
                    <div class="row g-4 gx-5 align-items-center">
                        <div class="col-lg-6">
                            <div class="subtitle wow fadeInUp mb-3">Our Story</div>
                            <h2 class="text-uppercase wow fadeInUp" data-wow-delay=".2s">Crafting Beautiful Gardens <span class="id-color-2">Since '99</span></h2>
                            <p class="wow fadeInUp">Established in 1999, our garden service has been transforming outdoor spaces into thriving, beautiful landscapes for over two decades. With a commitment to quality and personalized care, our experienced team offers a full range of services, from design to maintenance, ensuring your garden flourishes in every season.</p>
                            <a class="btn-main btn-line wow fadeInUp" href="projects.html" data-wow-delay=".6s">Our Projects</a>
                        </div>

                        <div class="col-lg-6">
                            <div class="row g-4">
                                <div class="col-sm-6">
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="text-center p-4 bg-blur rounded-1">
                                                <h4 class="mb-1 fs-24">Excellent</h4>
                                                <div class="de-rating-ext fs-18">
                                                    <div class="d-stars">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                    <div class="fs-15 mb-2">Based on 185 reviews</div>
                                                    <img src="images/misc/trustpilot.webp" class="w-120px" alt="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="rounded-1 relative bg-dark-2 p-4">
                                                <img src="images/icons/tree.png" class="abs abs-middle w-60px" alt="">
                                                <div class="de_count ps-80 wow fadeInUp">
                                                    <h2 class="mb-0 fs-32"><span class="timer" data-to="550" data-speed="3000"></span>+</h2>
                                                    <span class="op-7">Garden Designed</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row g-4">
                                        <div class="spacer-single sm-hide"></div>
                                        <div class="col-lg-12">
                                            <div class="rounded-1 relative bg-dark-2 p-4">
                                                <img src="images/icons/happy.png" class="abs abs-middle w-60px" alt="">
                                                <div class="de_count ps-80 wow fadeInUp">
                                                    <h2 class="mb-0 fs-32"><span class="timer" data-to="850" data-speed="3000"></span>+</h2>
                                                    <span class="op-7">Happy Customers</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="text-center p-4 bg-blur rounded-1">
                                                <h4 class="mb-1 fs-24">4.8 out of 5</h4>
                                                <div class="de-rating-ext fs-18">
                                                    <div class="d-stars">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                    <div class="fs-15 mb-2">Based on 200 reviews</div>
                                                    <img src="images/misc/google.webp" class="w-120px" alt="">
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

            <section class="jarallax">
                <img src="images/background/11.webp" class="jarallax-img" alt="">
                <div class="container">
                    <div class="row g-4">
                        <div class="row g-4 mb-3 align-items-center justify-content-center">
                            <div class="col-xl-6 text-center">
                                <div class="subtitle wow fadeInUp">Garden and Landscaping</div>
                                <h2 class="text-uppercase wow fadeInUp" data-wow-delay=".2s">Price <span class="id-color-2">List</span></h2>
                            </div>                        
                        </div>
                    </div>
                    <div class="row justify-content-center g-lg-4 gx-lg-5 wow fadeInUp">
                        <div class="col-xl-8">
                            <div class="d-flex justify-content-between pb-3 mb-3 border-bottom">
                                <div>
                                    <h5 class="mb-1">Lawn Mowing</h5>
                                    Regular mowing of lawn areas
                                </div>
                                <div class="text-end">
                                    <h5 class="fw-500 mb-1">$30 - $60</h5> per visit
                                </div>
                            </div>

                            <div class="d-flex justify-content-between pb-3 mb-3 border-bottom">
                                <div>
                                    <h5 class="mb-1">Hedge Trimming</h5>
                                    Shaping and trimming of hedges
                                </div>
                                <div class="text-end">
                                    <h5 class="fw-500 mb-1">$50 - $150</h5> per visit
                                </div>
                            </div>

                            <div class="d-flex justify-content-between pb-3 mb-3 border-bottom">
                                <div>
                                    <h5 class="mb-1">Garden Design Consultation</h5>
                                    Initial consultation for garden design
                                </div>
                                <div class="text-end">
                                    <h5 class="fw-500 mb-1">$100 - $200</h5> per hour
                                </div>
                            </div>

                            <div class="d-flex justify-content-between pb-3 mb-3 border-bottom">
                                <div>
                                    <h5 class="mb-1">Planting Services</h5>
                                    Planting flowers, shrubs, or trees
                                </div>
                                <div class="text-end">
                                    <h5 class="fw-500 mb-1">$20 - $50</h5> per plant
                                </div>
                            </div>

                            <div class="d-flex justify-content-between pb-3 mb-3 border-bottom">
                                <div>
                                    <h5 class="mb-1">Mulching</h5>
                                    Spreading mulch over garden beds
                                </div>
                                <div class="text-end">
                                    <h5 class="fw-500 mb-1">$40 - $100</h5> per yard
                                </div>
                            </div>

                            <div class="d-flex justify-content-between pb-3 mb-3 border-bottom">
                                <div>
                                    <h5 class="mb-1">Tree Pruning</h5>
                                    Trimming and shaping of trees
                                </div>
                                <div class="text-end">
                                    <h5 class="fw-500 mb-1">$75 - $300</h5> per tree
                                </div>
                            </div>

                            <div class="d-flex justify-content-between pb-3 mb-3 border-bottom">
                                <div>
                                    <h5 class="mb-1">Sodding</h5>
                                    Laying new sod
                                </div>
                                <div class="text-end">
                                    <h5 class="fw-500 mb-1">$1 - $3</h5> per sq. ft.
                                </div>
                            </div>

                            <div class="d-flex justify-content-between pb-3 mb-3 border-bottom">
                                <div>
                                    <h5 class="mb-1">Landscape Lighting</h5>
                                    Installation of outdoor lighting systems
                                </div>
                                <div class="text-end">
                                    <h5 class="fw-500 mb-1">$300 - $1,500</h5> per system
                                </div>
                            </div>

                            <div class="d-flex justify-content-between pb-3 mb-3 border-bottom">
                                <div>
                                    <h5 class="mb-1">Hardscaping</h5>
                                    Installation of patios, walkways, and retaining walls
                                </div>
                                <div class="text-end">
                                    <h5 class="fw-500 mb-1">$2,000 - $10,000+</h5> per project
                                </div>
                            </div>

                            <div class="d-flex justify-content-between pb-3 mb-3 border-bottom">
                                <div>
                                    <h5 class="mb-1">Pest Control</h5>
                                    Treatment for garden pests
                                </div>
                                <div class="text-end">
                                    <h5 class="fw-500 mb-1">$50 - $150</h5> per treatment
                                </div>
                            </div>

                        </div>

                        <div class="col-lg-12 text-center">
                            <a class="btn-main wow fadeInUp" href="price-list.html">View More</a>
                        </div>

                    </div>
                </div>
            </section>

            <section class="bg-light">
                <div class="container">
                    <div class="row g-4 mb-3 align-items-center justify-content-center">
                        <div class="col-lg-6 text-center">
                            <div class="subtitle wow fadeInUp">Why Choose Us</div>
                            <h2 class="text-uppercase wow fadeInUp" data-wow-delay=".2s">Our Commitment to <span class="id-color-2">Excellence</span></h2>
                        </div>                        
                    </div>
                    <div class="row g-4">
                        <div class="col-lg-4 col-md-6 wow fadeInUp">
                            <div class="relative h-100 bg-color text-light padding30 rounded-1">
                                <img src="images/logo-icon.webp" class="w-50px mb-3" alt="">
                                <div class="abs m-3 top-0 end-0 p-2 rounded-2 mb-3">01</div>
                                <div>
                                    <h4>Expertise and Experience</h4>
                                    <p class="mb-0">With years of hands-on experience, our team of professional gardeners and landscapers bring a wealth of knowledge to every project.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-6 wow fadeInUp">
                            <div class="relative h-100 bg-color text-light padding30 rounded-1">
                                <img src="images/logo-icon.webp" class="w-50px mb-3" alt="">
                                <div class="abs m-3 top-0 end-0 p-2 rounded-2 mb-3">02</div>
                                <div>
                                    <h4>Personalized Service</h4>
                                    <p class="mb-0">We believe that every garden is unique, just like its owner. We take the time to understand your vision, preferences, and the specific needs.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-6 wow fadeInUp">
                            <div class="relative h-100 bg-color text-light padding30 rounded-1">
                                <img src="images/logo-icon.webp" class="w-50px mb-3" alt="">
                                <div class="abs m-3 top-0 end-0 p-2 rounded-2 mb-3">03</div>
                                <div>
                                    <h4>Comprehensive Solutions</h4>
                                    <p class="mb-0">From garden design and installation to regular maintenance and specialty services, we offer a full range of garden services.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-6 wow fadeInUp">
                            <div class="relative h-100 bg-color-2 text-light padding30 rounded-1">
                                <img src="images/logo-icon.webp" class="w-50px mb-3" alt="">
                                <div class="abs m-3 top-0 end-0 p-2 rounded-2 mb-3">04</div>
                                <div>
                                    <h4>Quality Workmanship</h4>
                                    <p class="mb-0">Our commitment to quality is evident in every service we provide. We use only the best materials, plants, and tools to your garden.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-6 wow fadeInUp">
                            <div class="relative h-100 bg-color-2 text-light padding30 rounded-1">
                                <img src="images/logo-icon.webp" class="w-50px mb-3" alt="">
                                <div class="abs m-3 top-0 end-0 p-2 rounded-2 mb-3">05</div>
                                <div>
                                    <h4>Eco-Friendly Practices</h4>
                                    <p class="mb-0">We are dedicated to environmentally sustainable practices. Our organic gardening methods, water-wise landscaping, and  waste management.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-6 wow fadeInUp">
                            <div class="relative h-100 bg-color-2 text-light padding30 rounded-1">
                                <img src="images/logo-icon.webp" class="w-50px mb-3" alt="">
                                <div class="abs m-3 top-0 end-0 p-2 rounded-2 mb-3">06</div>
                                <div>
                                    <h4>Satisfaction Guarantee</h4>
                                    <p class="mb-0">Our top priority is your satisfaction. We take pride in our work, and our many happy customers are a testament to the quality and care.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="container">
                    <div class="row g-4 mb-3 align-items-center justify-content-center">
                        <div class="col-xl-6 text-center">
                            <div class="subtitle wow fadeInUp">Garden and Landscaping</div>
                            <h2 class="text-uppercase wow fadeInUp" data-wow-delay=".2s">Pricing <span class="id-color-2">Plan</span></h2>
                        </div>                        
                    </div>
                    <div class="row g-4">
                        <div class="col-lg-4 col-sm-6 wow fadeInRight" data-wow-delay=".0s" >
                            <div class="relative bg-light p-30 pb-80 rounded-1 h-100">
                                <div class="text-center mb-3">
                                    <img src="images/logo-icon-color.webp" class="w-80px mb-3" alt="">
                                    <h4>Standard Plan</h4>
                                    <div class="spacer-30"></div>
                                    <div class=""></div>
                                    <span class="fs-64 fw-500 text-dark">$19</span>
                                    <div class="fw-600">/visit</div>
                                    <div class="spacer-20"></div>
                                </div>

                                <h5 class="mb-2">Services Included</h5>
                                <ul class="ul-style-2">
                                    <li>Mowing and edging</li>
                                    <li>Seasonal pruning of shrubs and trees</li>
                                    <li>Mulching of garden beds</li>
                                    <li>Fertilization (lawn and plants)</li>
                                    <li>Weed control</li>
                                    <li>Irrigation system checks and adjustments</li>
                                </ul>
                                <div class="spacer-20"></div>

                                <div class="abs abs-center w-100 bottom-0 mb-5 px-5">
                                    <a class="btn-main w-100" href="#">Select Plan</a>
                                </div>
                                <div class="spacer-20"></div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6 wow fadeInRight" data-wow-delay=".3s" >
                            <div class="relative overflow-hidden bg-light p-30 pb-80 rounded-1 h-100 jarallax text-light">
                                <img src="images/misc/5.webp" class="jarallax-img" alt="">
                                <div class="de-overlay op-5"></div>
                                <div class="text-center mb-3 relative z-2">
                                    <img src="images/logo-icon-color.webp" class="w-80px mb-3" alt="">
                                    <h4>Premium Plan</h4>
                                    <div class="spacer-30"></div>
                                    <div class=""></div>
                                    <span class="fs-64 fw-500">$250</span>
                                    <div class="fw-600">/visit</div>
                                    <div class="spacer-20"></div>
                                </div>

                                <h5 class="mb-2 relative z-2">Services Included</h5>
                                <ul class="ul-style-2">
                                    <li>All services from the Standard Plan</li>
                                    <li>Seasonal flower planting and bed re-design</li>
                                    <li>Plant health care (pest and disease control)</li>
                                    <li>Soil testing and amendments</li>
                                    <li>Aeration and dethatching of lawns</li>
                                    <li>Customized garden care based on client preferences</li>
                                </ul>
                                <div class="spacer-20"></div>

                                <div class="abs abs-center w-100 bottom-0 mb-5 px-5">
                                    <a class="btn-main w-100" href="#">Select Plan</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6 wow fadeInRight" data-wow-delay=".6s" >
                            <div class="relative bg-light p-30 pb-80 rounded-1 h-100">
                                <div class="text-center mb-3">
                                    <img src="images/logo-icon-color.webp" class="w-80px mb-3" alt="">
                                    <h4>Deluxe Plan</h4>
                                    <div class="spacer-30"></div>
                                    <div class=""></div>
                                    <span class="fs-64 fw-500 text-dark">$400</span>
                                    <div class="fw-600">/visit</div>
                                    <div class="spacer-20"></div>
                                </div>

                                <h5 class="mb-2">Services Included</h5>
                                <ul class="ul-style-2">
                                    <li>All services from the Premium Plan</li>
                                    <li>Weekly garden visits for ongoing care</li>
                                    <li>Detailed hand-weeding and deadheading</li>
                                    <li>Organic fertilization and pest control options</li>
                                    <li>Custom seasonal decor (holiday lighting, planters)</li>
                                    <li>Personalized garden consultation each season</li>
                                </ul>
                                <div class="spacer-20"></div>

                                <div class="abs abs-center w-100 bottom-0 mb-5 px-5">
                                    <a class="btn-main w-100" href="#">Select Plan</a>
                                </div>
                                <div class="spacer-20"></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </section>

            <section class="p-4" aria-label="section">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <a class="d-block hover popup-youtube" href="https://www.youtube.com/watch?v=C6rf51uHWJg">
                                <div class="relative overflow-hidden rounded-1">
                                    <div class="absolute start-0 w-100 abs-middle fs-36 text-white text-center z-2">
                                        <div class="player wow scaleIn"><span></span></div>
                                    </div> 
                                    <div class="absolute w-100 h-100 top-0 bg-dark hover-op-05"></div>
                                    <img src="images/background/1.webp" class="w-100 hover-scale-1-1" alt="">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="jarallax">
                <img src="images/background/4.webp" class="jarallax-img" alt="">
                <div class="container relative z-2">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 text-center">
                            <div class="owl-single-dots owl-carousel owl-theme">
                                <div class="item">
                                    <i class="icofont-quote-left fs-40 mb-4 wow fadeInUp id-color-2"></i>
                                    <h3 class="mb-4 wow fadeInUp fs-32">We hired Gardyn to transform our backyard, and the results were beyond our expectations. The team was professional, punctual, and incredibly knowledgeable about plants and landscaping.</h3>
                                    <span class="wow fadeInUp">Donette Fondren</span>
                                </div>

                                <div class="item">
                                    <i class="icofont-quote-left fs-40 mb-4 wow fadeInUp id-color-2"></i>
                                    <h3 class="mb-4 wow fadeInUp fs-32">We hired Gardyn to transform our backyard, and the results were beyond our expectations. The team was professional, punctual, and incredibly knowledgeable about plants and landscaping.</h3>
                                    <span class="wow fadeInUp">Donette Fondren</span>
                                </div>

                                <div class="item">
                                    <i class="icofont-quote-left fs-40 mb-4 wow fadeInUp id-color-2"></i>
                                    <h3 class="mb-4 wow fadeInUp fs-32">We hired Gardyn to transform our backyard, and the results were beyond our expectations. The team was professional, punctual, and incredibly knowledgeable about plants and landscaping.</h3>
                                    <span class="wow fadeInUp">Donette Fondren</span>
                                </div>

                                <div class="item">
                                    <i class="icofont-quote-left fs-40 mb-4 wow fadeInUp id-color-2"></i>
                                    <h3 class="mb-4 wow fadeInUp fs-32">We hired Gardyn to transform our backyard, and the results were beyond our expectations. The team was professional, punctual, and incredibly knowledgeable about plants and landscaping.</h3>
                                    <span class="wow fadeInUp">Donette Fondren</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="px-4">
                <div class="container-fluid">
                    <div class="row g-4 align-items-center justify-content-center">
                        <div class="col-lg-8 text-center">
                            <div class="subtitle wow fadeInUp">Our Works</div>
                            <h2 class="text-uppercase mb-4 wow fadeInUp" data-wow-delay=".2s">Latest <span class="id-color-2">Works</span></h2>
                        </div>                        
                    </div>

                    <div class="row g-4">

                        <div class="col-lg-6">
                            <div class="hover rounded-1 overflow-hidden relative text-light wow fadeInRight" data-wow-delay=".3s">
                                <a href="project-single.html" class="abs w-100 h-100 z-5"></a>
                                <img src="images/projects/1.jpg" class="hover-scale-1-1 w-100" alt="">
                                <div class="abs w-100 px-4 hover-op-1 z-4 hover-mt-40 abs-centered">
                                    <div class="mb-3">A beautiful garden is more than just a space—it's a living, breathing part of your home. But maintaining that beauty takes time and expertise.</div>
                                </div>
                                <div class="abs bg-color z-2 top-0 w-100 h-100 hover-op-1"></div>
                                <div class="abs z-2 bottom-0 w-100 hover-op-0">
                                    <div class="bg-blur d-flex m-4 p-3 px-4 rounded-1 justify-content-between align-items-center">
                                        <div class="d-flex">
                                            <div class="me-5">
                                                Name
                                                <h5>Garden Beauty</h5>
                                            </div>
                                            <div>
                                                Location
                                                <h5>California</h5>
                                            </div>
                                        </div>

                                        <div class="w-40px">
                                            <img src="images/misc/right-arrow.webp" class="w-100" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="gradient-trans-color-bottom abs w-100 h-40 bottom-0"></div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="hover rounded-1 overflow-hidden relative text-light wow fadeInRight" data-wow-delay=".6s">
                                <a href="project-single.html" class="abs w-100 h-100 z-5"></a>
                                <img src="images/projects/2.jpg" class="hover-scale-1-1 w-100" alt="">
                                <div class="abs w-100 px-4 hover-op-1 z-4 hover-mt-40 abs-centered">
                                    <div class="mb-3">Create an inviting space for entertaining, or a functional extension of your home, our expert team can craft the outdoor area of your dreams.</div>
                                </div>
                                <div class="abs bg-color z-2 top-0 w-100 h-100 hover-op-1"></div>
                                <div class="abs z-2 bottom-0 w-100 hover-op-0">
                                    <div class="bg-blur d-flex m-4 p-3 px-4 rounded-1 justify-content-between align-items-center">
                                        <div class="d-flex">
                                            <div class="me-5">
                                                Name
                                                <h5>Garden Beauty</h5>
                                            </div>
                                            <div>
                                                Location
                                                <h5>California</h5>
                                            </div>
                                        </div>

                                        <div class="w-40px">
                                            <img src="images/misc/right-arrow.webp" class="w-100" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="gradient-trans-color-bottom abs w-100 h-40 bottom-0"></div>
                            </div>
                        </div>

                        <div class="col-lg-12 text-center">
                            <a class="btn-main wow fadeInUp" href="projects.html">View All Projects</a>
                        </div>

                    </div>
                </div>
            </section>

        </div>
        <!-- content end -->
        
        <!-- footer begin -->
        <footer class="section-dark">
            <div class="container relative z-2">
                <div class="row gx-5">
                    <div class="col-lg-4 col-sm-6">
                        <img src="images/logo-white.webp" class="w-150px" alt="" >
                        <div class="spacer-20"></div>
                        <p align="justify"><b>Taman Sains Teknologi Herbal dan Hortikultura</b> adalah Pusat Penelitian dan Sumber Produksi Bibit Unggul Pertanian Berkualitas Tinggi & Bertaraf Internasional Untuk Mempercepat Terwujudnya Kemandirian Pangan Nasional</p>

                        <div class="social-icons mb-sm-30">
                            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#"><i class="fa-brands fa-youtube"></i></a>
                            <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 order-lg-1 order-sm-2">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                                <div class="widget">
                                    <h5>Organisasi</h5>
                                    <ul>                                        
                                        <li><a href="#">Home</a></li>
                                        <li><a href="#">Tentang Kami</a></li>
                                        <li><a href="#">Visi & Misi</a></li>
                                        <li><a href="#">Struktur Organisasi</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="widget">
                                    <h5>Penelitian</h5>
                                    <ul>
                                        <li><a href="#">Komoditas Penelitian</a></li>
                                        <li><a href="#">Fasilitas Penelitian</a></li>
                                        <li><a href="#">Tim Peneliti</a></li>
                                        <li><a href="#">Kerja Sama Penelitian</a></li>    
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 order-lg-2 order-sm-1">
                        <div class="widget">
                            

                            <div class="spacer-20"></div>

                            <div class="fw-bold text-white"><i class="icofont-location-pin me-2 id-color-2"></i>Lokasi</div>
                            Aek Nauli I, Pollung, Humbang Hasundutan, Sumatera Utara

                            <div class="spacer-20"></div>

                            <div class="fw-bold text-white"><i class="icofont-envelope me-2 id-color-2"></i>Kirim Pesan</div>
                            info@tsth2-pollung.org                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="subfooter">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="de-flex">
                                <div class="de-flex-col">
                                    Copyright 2025
                                </div>
                                <ul class="menu-simple">
                                    <li><a href="#">Terms &amp; Conditions</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <img src="images/misc/silhuette-1-black.webp" class="abs bottom-0 op-3" alt="">
        </footer>
        <!-- footer end -->
    </div>

    <!-- overlay content begin -->
    <div id="extra-wrap" class="text-light">
        <div id="btn-close">
            <span></span>
            <span></span>
        </div>

        <div id="extra-content">
            <img src="images/logo-white.webp" class="w-150px" alt="">

            <div class="spacer-30-line"></div>

            <h5>Our Services</h5>
            <ul class="no-style">
                <li><a href="service-single.html">Garden Design</a></li>
                <li><a href="service-single.html">Garden Maintenance</a></li>
                <li><a href="service-single.html">Planting Services</a></li>
                <li><a href="service-single.html">Tree Care</a></li>
                <li><a href="service-single.html">Irrigation Services</a></li>
                <li><a href="service-single.html">Specialty Services</a></li>
            </ul>

            <div class="spacer-30-line"></div>

            <h5>Contact Us</h5>
            <div><i class="icofont-clock-time me-2 op-5"></i>Monday - Friday 08.00 - 18.00</div>
            <div><i class="icofont-location-pin me-2 op-5"></i>100 S Main St, New York, </div>
            <div><i class="icofont-envelope me-2 op-5"></i>contact@gardyn.com</div>    

            <div class="spacer-30-line"></div>

            <h5>About Us</h5>
            <p>Transform your outdoor space with our expert garden services! From design to maintenance, we create beautiful, thriving gardens tailored to your vision. Let us bring your dream garden to life—professional, reliable, and passionate about nature.</p>

            <div class="social-icons">
                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-youtube"></i></a>
                <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
            </div>
        </div>
    </div>
    <!-- overlay content end -->


    <!-- Javascript Files
    ================================================== -->
    <script src="{{ asset('frontend/gardyn/js/plugins.js') }}"></script>
    <script src="{{ asset('frontend/gardyn/js/designesia.js') }}"></script>
    <script src="{{ asset('frontend/gardyn/js/swiper.js') }}"></script>
    <script src="{{ asset('frontend/gardyn/js/custom-swiper-3.js') }}"></script>
    <script src="{{ asset('frontend/gardyn/js/custom-marquee.js') }}"></script>
    
</body>

</html>