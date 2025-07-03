<!DOCTYPE html>
<html lang="zxx">

<head>
  <title>Research Centre - TSTH2</title>
  <link rel="icon" href="{{ asset('frontend/gardyn/images/icon.webp') }}" type="image/gif" sizes="16x16">
  <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="Gardyn — Garden and Landscape Website Template" name="description">
  <meta content="" name="keywords">
  <meta content="" name="author">
  <link href="{{ URL::asset('backend/assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('backend/assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('backend/assets/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('backend/assets/icons/fontawesome/styles.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ URL::asset('backend/assets/icons/material/styles.min.css') }}" rel="stylesheet" type="text/css">

  <!-- CSS Files
    ================================================== -->
  <link href="{{ asset('frontend/gardyn/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap">
  <link href="{{ asset('frontend/gardyn/css/plugins.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('frontend/gardyn/css/swiper.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('frontend/gardyn/css/style.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('frontend/gardyn/css/coloring.css') }}" rel="stylesheet" type="text/css">
  
  <!-- color scheme -->
  <link id="colors" href="{{ asset('frontend/gardyn/css/colors/scheme-01.css') }}" rel="stylesheet" type="text/css">
  @yield('css')
</head>

<body>
  <div id="wrapper">
    <a href="#" id="back-to-top"></a>

    <!-- preloader begin -->
    <div id="de-loader"></div>
    <!-- preloader end -->

    <!-- header begin -->
    @include('layout.frontend.header')
    <!-- header end -->

    <!-- content begin -->
    <div class="no-bottom no-top" id="content">

      <div id="top"></div>

      @yield('content')


    </div>
    <!-- content end -->

    <!-- footer begin -->
    @include('layout.frontend.footer')
    <!-- footer end -->
  </div>

  <!-- overlay content begin -->
  @include('layout.frontend.overlay')
  <!-- overlay content end -->


  <!-- Javascript Files
    ================================================== -->
  <script src="{{ asset('frontend/gardyn/js/plugins.js') }}"></script>
  <script src="{{ asset('frontend/gardyn/js/designesia.js') }}"></script>
  <script src="{{ asset('frontend/gardyn/js/swiper.js') }}"></script>
  <script src="{{ asset('frontend/gardyn/js/custom-swiper-3.js') }}"></script>
  <script src="{{ asset('frontend/gardyn/js/custom-marquee.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  

  @stack('js')
  @stack('scripts')
  @yield('scripts')

</body>

</html>