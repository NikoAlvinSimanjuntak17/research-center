@php

        use App\Helpers\Translator;
        $locale = app()->getLocale();
@endphp
<!-- footer begin -->
<footer class="section-dark">
    <div class="container relative z-2">
        <div class="row gx-5">
            <div class="col-lg-4 col-sm-6">
                <div class="spacer-20"></div>
                <p align="justify">
                    <b>{{ Translator::translate('Taman Sains Teknologi Herbal dan Hortikultura', $locale, 'id') }}</b>
                    {{ Translator::translate('adalah Pusat Penelitian dan Sumber Produksi Bibit Unggul Pertanian Berkualitas Tinggi & Bertaraf Internasional Untuk Mempercepat Terwujudnya Kemandirian Pangan Nasional', $locale, 'id') }}
                </p>

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
                            <h5>{{ Translator::translate('Organisasi', $locale, 'id') }}</h5>
                            <ul>
                                <li><a href="#">{{ Translator::translate('Beranda', $locale, 'id') }}</a></li>
                                <li><a href="#">{{ Translator::translate('Tentang Kami', $locale, 'id') }}</a></li>
                                <li><a href="#">{{ Translator::translate('Visi & Misi', $locale, 'id') }}</a></li>
                                <li><a href="#">{{ Translator::translate('Struktur Organisasi', $locale, 'id') }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <div class="widget">
                            <h5>{{ Translator::translate('Penelitian', $locale, 'id') }}</h5>
                            <ul>
                                <li><a href="#">{{ Translator::translate('Komoditas Penelitian', $locale, 'id') }}</a></li>
                                <li><a href="#">{{ Translator::translate('Fasilitas Penelitian', $locale, 'id') }}</a></li>
                                <li><a href="#">{{ Translator::translate('Tim Peneliti', $locale, 'id') }}</a></li>
                                <li><a href="#">{{ Translator::translate('Kerja Sama Penelitian', $locale, 'id') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-sm-6 order-lg-2 order-sm-1">
                <div class="widget">
                    <div class="spacer-20"></div>
                    <div class="fw-bold text-white">
                        <i class="icofont-location-pin me-2 id-color-2"></i>{{ Translator::translate('Lokasi', $locale, 'id') }}
                    </div>
                    Aek Nauli I, Pollung, Humbang Hasundutan, Sumatera Utara

                    <div class="spacer-20"></div>
                    <div class="fw-bold text-white">
                        <i class="icofont-envelope me-2 id-color-2"></i>{{ Translator::translate('Kirim Pesan', $locale, 'id') }}
                    </div>
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
                            {{ Translator::translate('Hak Cipta 2025', $locale, 'id') }}
                        </div>
                        <ul class="menu-simple">
                            <li><a href="#">{{ Translator::translate('Syarat & Ketentuan', $locale, 'id') }}</a></li>
                            <li><a href="#">{{ Translator::translate('Kebijakan Privasi', $locale, 'id') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <img src="images/misc/silhuette-1-black.webp" class="abs bottom-0 op-3" alt="">
</footer>
<!-- footer end -->
