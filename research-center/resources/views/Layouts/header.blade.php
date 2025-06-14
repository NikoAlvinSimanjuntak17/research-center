<!DOCTYPE html>
<!-- language -->
<html lang="en">

<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="layerdrops">
    <meta name="description" content="Laboix is beautifully designed laboratory & research HTML template. Which fits for laboratory test, science research, biology, medical research, science technology, chemistry, pharmaceuticals, pharmacy and all other type of science & technology research websites and businesses.">

    <!-- ======== Page title ============ -->
    <title>Taman Sains Teknologi Herbal dan Hortikultura</title>

    <!-- ========== Favicon Icon ========== -->
    <link rel="shortcut icon" href="{{ asset('images/favicons/apple-touch-icon.png') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicons/site.webmanifest') }}">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100;200;300;400;500;600;700;800;900&family=Urbanist:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,900&display=swap" rel="stylesheet">
    <!-- ===========  All Stylesheet ================= -->
    <!--  Bootstrap css plugins -->
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}">
    <!--  bootstrap-select css plugins -->
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap-select/bootstrap-select.min.css') }}">
    <!--  animate css plugins -->
    <link rel="stylesheet" href="{{ asset('vendors/animate/animate.min.css') }}">
    <!--  fontawesome css plugins -->
    <link rel="stylesheet" href="{{ asset('vendors/fontawesome/css/all.min.css') }}">
    <!--  jquery-ui css plugins -->
    <link rel="stylesheet" href="{{ asset('vendors/jquery-ui/jquery-ui.css') }}">
    <!--  jarallax css plugins -->
    <link rel="stylesheet" href="{{ asset('vendors/jarallax/jarallax.css') }}">
    <!--  magnific-popup css plugins -->
    <link rel="stylesheet" href="{{ asset('vendors/jquery-magnific-popup/jquery.magnific-popup.css') }}">
    <!--  nouislider css plugins -->
    <link rel="stylesheet" href="{{ asset('vendors/nouislider/nouislider.min.css') }}">
    <!--  nouislider css plugins -->
    <link rel="stylesheet" href="{{ asset('vendors/nouislider/nouislider.pips.css') }}">
    <!--  nouislider css plugins -->
    <link rel="stylesheet" href="{{ asset('vendors/laboix-icons/style.css') }}">
    <!--  slider css plugins -->
    <link rel="stylesheet" href="{{ asset('vendors/owl-carousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/owl-carousel/css/owl.theme.default.min.css') }}">
    
    <!-- template styles -->
    <link rel="stylesheet" href="{{ asset('css/laboix.css') }}">
   
</head>

<body class="custom-cursor">
    
    <!-- Custom Cursor -->
    <div class="custom-cursor__cursor"></div>
    <div class="custom-cursor__cursor-two"></div>
    
    <!-- Preloader Start-->
    <div class="preloader">
        <div class="preloader__image" style="background-image: url({{ asset('images/loader.png);') }}"></div>
    </div>
    <!-- Preloader End-->
    
    <div class="page-wrapper">
        <div class="topbar-one">
            <div class="container-fluid">
                <div class="topbar-one__inner">
                    <ul class="list-unstyled topbar-one__info">
                        <li class="topbar-one__info__item">
                            <i class="icon-pin topbar-one__info__icon"></i>
                            <span class="topbar-one__info__item__location">Indonesia</span>
                        </li>
                        <li class="topbar-one__info__item">
                            <i class="icon-email topbar-one__info__icon"></i>
                            <a class="topbar-one__info__item__email" href="mailto:needhelp@company.com">needhelp@company.com</a>
                        </li>
                    </ul><!-- /.list-unstyled topbar-one__info -->
                    <div class="topbar-one__right">
                        {{-- <p class="topbar-one__text">
                            <i class="icon-clock1 topbar-one__right__icon"></i>
                            <a href="{{ url('lang/en') }}">English</a> |
                            <a href="{{ url('lang/id') }}">Bahasa Indonesia</a>
                            <span></span>
                        </p><!-- /.topbar-one__text --> --}}
                        <div class="topbar-one__social">
                            <a href="https://twitter.com"> <i class="fab fa-twitter" aria-hidden="true"></i> <span class="sr-only">Twitter</span> </a>
                            <a href="https://facebook.com"> <i class="fab fa-facebook-f" aria-hidden="true"></i> <span class="sr-only">Facebook</span> </a>
                            <a href="https://pinterest.com"> <i class="fab fa-pinterest-p" aria-hidden="true"></i> <span class="sr-only">Pinterest</span></a>
                            <a href="https://instagram.com"> <i class="fab fa-instagram" aria-hidden="true"></i> <span class="sr-only">Instagram</span></a>
                        </div><!-- /.topbar-one__social -->
                    </div><!-- /.topbar-one__right -->
                </div><!-- /.topbar-one__inner -->
            </div><!-- /.container-fluid -->
        </div><!-- /.topbar-one -->
        
        <header class="main-header sticky-header sticky-header--normal">
            <div class="container-fluid">
                <div class="main-header__inner">
                    <div class="main-header__logo logo-laboix">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('images/logo.jpg')}}" alt="Laboix HTML" width="300">
                        </a>
                    </div>
                    <!-- /.main-header__logo -->
                    
                    <nav class="main-header__nav main-menu">
                        <ul class="main-menu__list">
                            <li>
                                <a href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="dropdown">
                                <a href="#">About</a>
                                <ul>
                                    <li><a href="{{ route('sejarah')}}">Sejarah TSTH2</a></li>
                                    <li><a href="{{ route('organisasi')}}">Struktur organisasi</a></li>
                                    {{-- <li><a href="{{ route('visimisi')}}">Visi dan Misi</a></li> --}}
                                </ul>
                            </li>
                            
                            <li class="dropdown">
                                <a href="#">Source</a>
                                <ul>
                                    <li><a href="{{route ('researchers')}}">Researcher</a></li>
                                    <li><a href="{{route ('affiliation')}}">Affiliation</a></li>
                                    <li><a href="{{route ('publications.index')}}">Publication</a></li>
                                </ul>
                            </li>
                            {{-- <li>
                                <a href="{{ route('projects.index')}}">Project</a>
                            </li> --}}

                            {{-- <li>
                                <a href="#">Datasets</a>
                            </li> --}}
                            
                            <li>
                                <a href="{{ route('news.index')}}">News</a>
                            </li>
                            {{-- <li>
                                <a href="#">Event</a>
                            </li> --}}
                            <li>
                                <a href="{{ route('galleries')}}">Galeri</a>
                            </li>
                            <li>
                                <a href="{{ route('contact')}}">Contact</a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.main-header__nav -->
                    
                    <div class="main-header__right">
                        <div class="main-header__link">
                            @auth
                            <div class="dropdown">
                                <button class="laboix-btn main-header__btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile') }}">Profile</a>
                                    </li>
                                    <li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            @else
                            <a href="{{ route('login') }}" class="laboix-btn main-header__btn">Login</a>
                            @endauth
                        </div>
                        <div class="main-header__right__info">
                            <a href="#" class="search-toggler main-header__right__info__item"> <i class="icon-search" aria-hidden="true"></i> <span class="sr-only">Search</span> </a>
                            <a href="{{ route('Buyer.cart') }}" class="main-header__right__info__item"> <i class="icon-trolley" aria-hidden="true"></i> <span class="sr-only">Cart</span> </a>
                        </div>
                        
                        <div class="mobile-nav__btn mobile-nav__toggler">
                            <span></span><span></span><span></span>
                        </div><!-- /.mobile-nav__toggler -->
                        
                        <a href="tel:+92-3800-8060" class="main-header__right__call">
                            <div class="main-header__right__icon">
                                <i class="icon-telephone-call-1"></i>
                            </div>
                            <div class="main-header__right__content">
                                <span class="main-header__right__content__text">Call to Anytime</span>
                                <h6 class="main-header__right__content__number">+92 3800 8060</h6>
                            </div>
                        </a>
                        
                    </div><!-- /.main-header__right -->
                </div><!-- /.main-header__inner -->
            </div><!-- /.container-fluid -->
        </header><!-- /.main-header -->

        