<!DOCTYPE html>

<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="{{ URL::asset('vuexy/assets') }}/"
    data-template="horizontal-menu-template"
>
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>{{ $titlePage }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet"
    />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/tagify/tagify.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />

    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/pickr/pickr-themes.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/quill/typography.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/highlight/highlight.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/quill/editor.css') }}" />
  

    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    
    <!-- Row Group CSS -->
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css') }}">
    <!-- Form Validation -->
    {{-- <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/libs/form-validation/form-validation.css') }}" /> --}}

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ URL::asset('vuexy/assets/vendor/css/pages/cards-advance.css') }}" />
    <!-- Helpers -->
    <script src="{{ URL::asset('vuexy/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ URL::asset('vuexy/assets/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ URL::asset('vuexy/assets/js/config.js') }}"></script>
</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        @include('vuexy.layouts.menu')
        <!-- / Menu -->
        

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->
            @include('vuexy.layouts.header')
            <!-- / Navbar -->
        
            <!-- Content wrapper -->
            <div class="content-wrapper">
                

                <!-- Content -->

                <div class="container-xxl flex-grow-1 container-p-y">
                    @yield('content')


                </div>
                <!--/ Content -->

                <!-- Footer -->
                @include('vuexy.layouts.footer')
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!--/ Content wrapper -->
        </div>

        <!--/ Layout container -->
    </div>
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>

<!-- Drag Target Area To SlideIn Menu On Small Screens -->
<div class="drag-target"></div>

<!--/ Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ URL::asset('vuexy/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/node-waves/node-waves.js') }}"></script>

<script src="{{ URL::asset('vuexy/assets/vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/i18n/i18n.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

<script src="{{ URL::asset('vuexy/assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ URL::asset('vuexy/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/swiper/swiper.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/datatables-responsive/datatables.responsive.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/tagify/tagify.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/bloodhound/bloodhound.js') }}"></script>

<!-- Main JS -->
<script src="{{ URL::asset('vuexy/assets/js/main.js') }}"></script>

<!-- Page JS -->
<script src="{{ URL::asset('vuexy/assets/js/dashboards-analytics.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/js/forms-selects.js') }}"></script>
{{-- <script src="{{ URL::asset('vuexy/assets/js/forms-tagify.js') }}"></script> --}}
<script src="{{ URL::asset('vuexy/assets/js/forms-typeahead.js') }}"></script>

<script src="{{ URL::asset('vuexy/assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/jquery-timepicker/jquery-timepicker.js') }}"></script>
<script src="{{ URL::asset('vuexy/assets/vendor/libs/pickr/pickr.js') }}"></script>

{{-- <script src="{{ URL::asset('vuexy/assets/js/tables-datatables-basic.js') }}"></script> --}}

</body>
</html>
