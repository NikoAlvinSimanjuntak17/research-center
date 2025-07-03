<!-- header begin -->
@php
    use App\Helpers\Translator;
    $locale = app()->getLocale();
@endphp


<style>
    .dropdown,
    .dropdown * {
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
    }
    .btn-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 6px;
    height: 35px;
    width: 35px;
}
</style>

<header class="transparent">
    {{-- TOPBAR --}}
    <div id="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-between xs-hide">
                        <div class="d-flex">
                            <div class="topbar-widget me-3">
                                <a href="#"><i class="icofont-bank-alt"></i> Taman Sains Teknologi Herbal dan Hortikultura (TSTH2)</a>
                            </div>
                            <div class="topbar-widget me-3">
                                <a href="#"><i class="icofont-location-pin"></i> Aek Nauli I, Pollung, Humbang Hasundutan, Sumatera Utara</a>
                            </div>
                            <div class="topbar-widget me-3">
                                <a href="#"><i class="icofont-envelope"></i> info@tsth2-pollung.org</a>
                            </div>
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

    {{-- HEADER NAVIGATION --}}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="de-flex sm-pt10">
                    <div class="de-flex-col">
                        <div id="logo">
                            <a href="{{ route('index') }}">
                                <img class="logo-main" src="{{ asset('frontend/gardyn/images/logo_tsth2.png') }}" alt="">
                                <img class="logo-mobile" src="{{ asset('frontend/gardyn/images/logo_tsth2.png') }}" alt="">
                            </a>
                        </div>
                    </div>

                    {{-- MENU --}}
                    <div class="de-flex-col header-col-mid">
                        <ul id="mainmenu">
                            <li><a class="menu-item" href="{{ route('index') }}">{{ Translator::translate('Beranda', $locale, 'id') }}</a></li>
                            <li>
                                <a class="menu-item" href="#">{{ Translator::translate('Profil', $locale, 'id') }}</a>
                                <ul>
                                    <li><a href="{{ route('frontend-profile.view') }}">{{ Translator::translate('Sejarah TSTH2', $locale, 'id') }}</a></li>
                                    <li><a href="{{ route('frontend-profile.sambutan') }}">{{ Translator::translate('Sambutan Direktur TSTH2', $locale, 'id') }}</a></li>
                                    <li><a href="{{ route('frontend-profile.visiMisi') }}">{{ Translator::translate('Visi & Misi', $locale, 'id') }}</a></li>
                                    <li><a href="{{ route('frontend-profile.struktur') }}">{{ Translator::translate('Struktur Organisasi', $locale, 'id') }}</a></li>
                                </ul>
                            </li>
                            <li>
                                <a class="menu-item" href="#">{{ Translator::translate('Penelitian', $locale, 'id') }}</a>
                                <ul>
                                    <li><a href="{{ route('frontend-komoditas.index') }}">{{ Translator::translate('Komoditas', $locale, 'id') }}</a></li>
                                    <li><a href="{{ route('frontend-dataset.index') }}">{{ Translator::translate('Data Riset Penelitian', $locale, 'id') }}</a></li>
                                    <li><a href="{{ route('frontend-publication.index') }}">{{ Translator::translate('Publikasi Penelitian', $locale, 'id') }}</a></li>
                                    <li><a href="{{ route('frontend-fasilitas.index') }}">{{ Translator::translate('Fasilitas Penelitian', $locale, 'id') }}</a></li>
                                    <li><a href="{{ route('frontend-researchers.list') }}">{{ Translator::translate('Tim Peneliti', $locale, 'id') }}</a></li>
                                    <li><a href="{{ route('frontend-project.index') }}">{{ Translator::translate('Proyek Penelitian', $locale, 'id') }}</a></li>
                                    <li><a href="{{ route('frontend-partnership.index') }}">{{ Translator::translate('Kerja Sama', $locale, 'id') }}</a></li>
                                </ul>
                            </li>
                            <li><a class="menu-item" href="{{ route('frontend-event.index') }}">{{ Translator::translate('Acara', $locale, 'id') }}</a></li>
                            <li><a class="menu-item" href="{{ route('frontend-news.index') }}">{{ Translator::translate('Berita', $locale, 'id') }}</a></li>
                            <li><a class="menu-item" href="{{ route('frontend-gallery.index') }}">{{ Translator::translate('Galeri', $locale, 'id') }}</a></li>
                        <li class="d-block d-lg-none">
                            <div class="d-flex flex-column gap-2 p-2">
                                <a href="{{ route('set.locale', 'id') }}" class="btn-sm {{ $locale == 'id' ? 'btn-primary' : 'btn-outline-secondary' }}">🇮🇩 ID</a>
                                <a href="{{ route('set.locale', 'en') }}" class="btn-sm {{ $locale == 'en' ? 'btn-primary' : 'btn-outline-secondary' }}">🇺🇸 EN</a>
                            </div>
                        </li>

                        </ul>
                    </div>

                    {{-- KANAN HEADER --}}
                    <div class="de-flex-col">
                        <div class="menu_side_area d-flex align-items-center">
                            @if(Auth::check())
                                <a href="{{ route('frontend-cart.index') }}" class="btn-icon position-relative">
                                    <i class="fas fa-shopping-cart secondary" style="font-size: 20px;"></i>
                                    @if(session('cart_count', 0) > 0)
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ session('cart_count') }}
                                        </span>
                                    @endif
                                </a>
                            @else
                                <a href="#" class="btn-icon position-relative" onclick="handleLoginAlert(event)">
                                    <i class="fas fa-shopping-cart secondary" style="font-size: 20px;"></i>
                                </a>
                            @endif

                        {{-- AVATAR / LOGIN --}}
                        <div class="user-auth d-flex align-items-center justify-content-end ms-3 flex-shrink-0" style="min-width: auto;">
                            @if(auth()->check())
<div class="dropdown position-relative">
    <a href="#" class="dropdown-toggle d-flex align-items-center p-0 bg-transparent border-0"
        id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
        @if(Auth::user()->user_img && file_exists(public_path('storage/' . Auth::user()->user_img)))
            <img src="{{ asset('storage/' . Auth::user()->user_img) }}"
                alt="Profile" width="35" height="35"
                class="rounded-circle" style="object-fit: cover;">
        @else
            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                style="width: 35px; height: 35px; font-size: 16px; font-weight: bold;">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @endif
    </a>
    <ul class="dropdown-menu dropdown-menu-end mt-2 shadow-sm"
        aria-labelledby="dropdownUser"
        style="min-width: 130px; max-width: 10px; z-index: 999;">
        <li><a class="dropdown-item" href="{{ route('user.profile.show') }}">{{ Translator::translate('Profil', $locale, 'id') }}</a></li>
        <li><a class="dropdown-item" href="{{ route('frontend-orders.index') }}">{{ Translator::translate('Pesanan', $locale, 'id') }}</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item text-danger">{{ Translator::translate('Logout', $locale, 'id') }}</button>
            </form>
        </li>
    </ul>
</div>

                            @else
                            <a href="{{ route('login') }}"
                            style="
                                    display: inline-block;
                                    padding: 6px 14px;
                                    font-size: 15px;
                                    color: #ffffff;
                                    border: 1px solid #859f81;
                                    border-radius: 30px;
                                    text-decoration: none;
                                    background-color: transparent;
                                    transition: background-color 0.3s, color 0.3s;
                                "
                            onmouseover="this.style.backgroundColor='#384c34'; this.style.color='#859f81';"
                            onmouseout="this.style.backgroundColor='transparent'; this.style.color='#fff';">
                                LOGIN
                            </a>
                            @endif
                        </div>

                        <div id="btn-extra">
                                    <span></span>
                                    <span></span>
                                </div>

                            {{-- Language switcher --}}
                            @php $locale = app()->getLocale(); @endphp
                           <div class="language-switcher d-none d-lg-flex align-items-center gap-1 ms-3">
                                <a href="{{ route('set.locale', 'id') }}" class="btn-sm {{ $locale == 'id' ? 'btn-primary' : 'btn-outline-secondary' }}">🇮🇩 ID</a>
                                <a href="{{ route('set.locale', 'en') }}" class="btn-sm {{ $locale == 'en' ? 'btn-primary' : 'btn-outline-secondary' }}">🇺🇸 EN</a>
                            </div>

                        </div>

                        {{-- MENU TOGGLE BUTTON --}}
                        <span id="menu-btn" class="ms-3">
                            <span></span>
                            <span></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function handleLoginAlert(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Anda Belum Login',
            text: 'Silakan login terlebih dahulu untuk mengakses keranjang.',
            icon: 'warning',
            confirmButtonText: 'Login Sekarang',
            confirmButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('login') }}";
            }
        });
    }
</script>


<!-- header end -->