<footer class="main-footer main-footer--one">
    <div class="main-footer__inner">
        <div class="container">
            <div class="row">
                <!-- Logo dan Deskripsi -->
                <div class="col-md-6 col-xl-4">
                    <div class="footer-widget footer-widget--info">
                        <a href="{{ url('/') }}" class="footer-widget__logo">
                            <img src="{{ asset('images/logoo.png') }}" width="300" alt="footer logo">
                        </a>
                        <p class="footer-widget__text">
                            Selamat datang di pusat informasi kami. Terima kasih atas kunjungannya.
                        </p>
                        <form action="#" class="footer-widget__newsletter mc-form">
                            <input type="email" name="EMAIL" placeholder="Email Anda">
                            <button type="submit" class="laboix-btn laboix-btn--submite">
                                <i class="icon-right-arrow"></i>
                            </button>
                        </form>
                        <div class="mc-form__response"></div>
                    </div>
                </div>

                <!-- Link Navigasi -->
                <div class="col-md-6 col-xl-2">
                    <div class="footer-widget footer-widget--link">
                        <h4 class="footer-widget__title">Links</h4>
                        <ul class="list-unstyled footer-widget__links">
                            <li><a href="{{ url('/tentang') }}">Tentang</a></li>
                            <li><a href="{{ url('/kontak') }}">Kontak</a></li>
                            <li><a href="{{ url('/berita') }}">Berita</a></li>
                            <li><a href="{{ url('/layanan') }}">Layanan</a></li>
                            <li><a href="{{ url('/publikasi') }}">Publikasi</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Kontak -->
                <div class="col-md-6 col-xl-3">
                    <div class="footer-widget footer-widget--about">
                        <h4 class="footer-widget__title">Contacts</h4>
                        <ul class="list-unstyled footer-widget__info">
                            @if(isset($groupedContacts['alamat']))
                            <li>{{ $groupedContacts['alamat'][0]->value }}</li>
                            @endif
                            @if(isset($groupedContacts['email']))
                            <li>
                                <i class="icon-email"></i>
                                <a href="mailto:{{ $groupedContacts['email'][0]->value }}">
                                    {{ $groupedContacts['email'][0]->value }}
                                </a>
                            </li>
                            @endif
                            @if(isset($groupedContacts['phone']))
                            <li>
                                <i class="icon-telephone-call-1"></i>
                                <a href="tel:{{ $groupedContacts['phone'][0]->value }}">
                                    {{ $groupedContacts['phone'][0]->value }}
                                </a>
                            </li>
                            @endif
                        </ul>

                        <!-- Sosial Media -->
                        <div class="footer-widget__social">
                            @foreach($groupedContacts as $key => $items)
                            @if(str_contains($key, 'facebook') || str_contains($key, 'twitter') || str_contains($key, 'instagram') || str_contains($key, 'youtube') || str_contains($key, 'pinterest'))
                            @foreach($items as $item)
                            <a href="{{ $item->value }}" target="_blank">
                                <i class="{{ App\Http\Controllers\ContactController::getContactIcon($key) }}"></i>
                                <span class="sr-only">{{ ucfirst($key) }}</span>
                            </a>
                            @endforeach
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Jam Operasional -->
                       <div class="col-md-6 col-xl-3">
                            <div class="footer-widget footer-widget--time">
                                <h4 class="footer-widget__title">Opening hours</h4>
                                <ul class="list-unstyled footer-widget__time">
                                    <li class="footer-widget__time__item">
                                        <p class="footer-widget__day"> <i class="icon-clock1"></i> Saturday</p>
                                        <p>9am - 6pm</p>
                                    </li>
                                    <li class="footer-widget__time__item">
                                        <p class="footer-widget__day"> <i class="icon-clock1"></i> Sunday</p>
                                        <p>9am - 6pm</p>
                                    </li>
                                    <li class="footer-widget__time__item">
                                        <p class="footer-widget__day"> <i class="icon-clock1"></i> Monday</p>
                                        <p>9am - 6pm</p>
                                    </li>
                                    <li class="footer-widget__time__item">
                                        <p class="footer-widget__day"> <i class="icon-clock1"></i> Tuesday</p>
                                        <p>9am - 6pm</p>
                                    </li>
                                </ul><!-- /.list-unstyled footer-widget__links -->
                            </div><!-- /.footer-widget -->
                        </div><!-- /.col-md-6 -->
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="main-footer__bottom">
        <div class="container">
            <div class="main-footer_bottom_inner text-center">
                <p class="main-footer__copyright">
                    &copy; <span class="dynamic-year">{{ date('Y') }}</span> Semua Hak Cipta Dilindungi.
                </p>
            </div>
        </div>
    </div>
</footer>


</div><!-- /.page-wrapper -->



<div class="mobile-nav__wrapper">
    <div class="mobile-nav_overlay mobile-nav_toggler"></div>
    <!-- /.mobile-nav__overlay -->
    <div class="mobile-nav__content">
        <span class="mobile-nav_close mobile-nav_toggler"><i class="fa fa-times"></i></span>

        <div class="logo-box">
            <a href="index.html" aria-label="logo image"><img src="" width="155" alt="labiox"></a>
        </div>
        <!-- /.logo-box -->
        <div class="mobile-nav__container"></div>
        <!-- /.mobile-nav__container -->

        <ul class="mobile-nav__contact list-unstyled">
            <li>
                <i class="fa fa-envelope"></i>
                <a href="mailto:needhelp@laboix.com">needhelp@laboix.com</a>
            </li>
            <li>
                <i class="fa fa-phone-alt"></i>
                <a href="tel:666-888-0000">666 888 0000</a>
            </li>
        </ul><!-- /.mobile-nav__contact -->
        <div class="mobile-nav__social">
            <a href="https://twitter.com"> <i class="fab fa-twitter" aria-hidden="true"></i> <span class="sr-only">Twitter</span> </a>
            <a href="https://facebook.com"> <i class="fab fa-facebook-f" aria-hidden="true"></i> <span class="sr-only">Facebook</span> </a>
            <a href="https://pinterest.com"> <i class="fab fa-pinterest-p" aria-hidden="true"></i> <span class="sr-only">Pinterest</span></a>
            <a href="https://instagram.com"> <i class="fab fa-instagram" aria-hidden="true"></i> <span class="sr-only">Instagram</span></a>
        </div><!-- /.mobile-nav__social -->
    </div>
    <!-- /.mobile-nav__content -->
</div>

<!-- /.mobile-nav__wrapper -->
<div class="search-popup">
    <div class="search-popup__overlay search-toggler"></div>
    <!-- /.search-popup__overlay -->
    <div class="search-popup__content">
        <form role="search" method="GET" class="search-popup__form" action="{{ route('publications.search') }}">
            <input type="text" name="query" id="search" placeholder="Cari nama peneliti..." required>
            <button type="submit" aria-label="search submit" class="laboix-btn laboix-btn--submite">
                <span><i class="icon-search"></i></span>
            </button>
        </form>
    </div>
    <!-- /.search-popup__content -->
</div>

<!-- /.search-popup -->

<a href="#" data-target="html" class="scroll-to-target scroll-to-top">
    <span class="scroll-to-top__text">back top</span>
    <span class="scroll-to-top_wrapper"><span class="scroll-to-top_inner"></span></span>
</a>


<!--  ALl JS Plugins =====================
        ====================================== -->
<!--  jquery-3.7.0 js plugins -->
<script src="{{ asset('vendors/jquery/jquery-3.7.0.min.js') }}"></script>
<!--  Bootstrap js plugins -->
<script src="{{ asset('vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendors/bootstrap-select/bootstrap-select.min.js') }}"></script>
<!--  jarallax js plugins -->
<script src="{{ asset('vendors/jarallax/jarallax.min.js') }}"></script>
<!--  jquery-ui js plugins -->
<script src="{{ asset('vendors/jquery-ui/jquery-ui.js') }}"></script>
<!--  jquery-ajaxchimp js plugins -->
<script src="{{ asset('vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js') }}"></script>
<!--  jquery-appear js plugins -->
<script src="{{ asset('vendors/jquery-appear/jquery.appear.min.js') }}"></script>
<!-- jquery-circle-progress js plugins -->
<script src="{{ asset('vendors/jquery-circle-progress/jquery.circle-progress.min.js') }}"></script>
<!--  magnific-popup js plugins -->
<script src="{{ asset('vendors/jquery-magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<!--  validate js plugins -->
<script src="{{ asset('vendors/jquery-validate/jquery.validate.min.js') }}"></script>
<!--  nouislider js plugins -->
<script src="{{ asset('vendors/nouislider/nouislider.min.js') }}"></script>
<!--  wnumb js plugins -->
<script src="{{ asset('vendors/wnumb/wNumb.min.js') }}"></script>
<!--  owl-carousel js plugins -->
<script src="{{ asset('vendors/owl-carousel/js/owl.carousel.min.js') }}"></script>
<!--  Bootstrap js plugins -->
<script src="{{ asset('vendors/wow/wow.js') }}"></script>
<!--  wow js plugins -->
<script src="{{ asset('vendors/imagesloaded/imagesloaded.min.js') }}"></script>
<!--  isotope js plugins -->
<script src="{{ asset('vendors/isotope/isotope.js') }}"></script>
<!--  countdown js plugins -->
<script src="{{ asset('vendors/countdown/countdown.min.js') }}"></script>
<!--  Chart.js js plugins -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js') }}"></script>
<!--  jquery-circleType js plugins -->
<script src="{{ asset('vendors/jquery-circleType/jquery.circleType.js') }}"></script>
<script src="{{ asset('vendors/jquery-lettering/jquery.lettering.min.js') }}"></script>
<!-- template js -->
<script src="{{ asset('js/laboix.js') }}"></script>
</body>

</html>