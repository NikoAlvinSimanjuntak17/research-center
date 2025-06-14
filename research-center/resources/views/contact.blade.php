@include('layouts.header')

<section class="page-header">
    <div class="page-header__bg" style="background-image: url('{{ asset('images/bg.jpg') }}');"></div>
    <div class="container">
        <h2 class="page-header__title">Contact</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><span>Contact</span></li>
        </ul>
    </div>
</section>

<section class="contact-one section-padding">
    <div class="container">
        <div class="row g-5 align-items-stretch">

            {{-- KIRI: Google Map --}}
            <div class="col-lg-6" data-aos="fade-right">
                <div class="h-100 w-100 rounded-3 overflow-hidden shadow-sm" style="min-height: 100%; height: 100%;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4562.753041141002!2d-118.80123790098536!3d34.152323469614075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80e82469c2162619%3A0xba03efb7998eef6d!2sCostco+Wholesale!5e0!3m2!1sbn!2sbd!4v1562518641290!5m2!1sbn!2sbd"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            {{-- KANAN: Info Kontak --}}
            <div class="col-lg-6 d-flex align-items-center" data-aos="fade-left">
                <div class="contact-one__content w-100">

                    {{-- Kontak Info --}}
                    <ul class="list-unstyled contact-one__info mb-5">
                        @foreach($groupedContacts as $key => $items)
                            @foreach($items as $item)
                                @php
                                    $icon = App\Http\Controllers\ContactController::getContactIcon($key);
                                    $value = $item->value;
                                    $title = $item->title;
                                @endphp
                                <li class="contact-one__info__item mb-4 d-flex align-items-start">
                                    <div class="contact-one__info__icon me-3">
                                        <i class="{{ $icon }}"></i>
                                    </div>
                                    <div class="contact-one__info__content text-start">
                                        <p class="contact-one__info__text">{{ $title }}</p>
                                        <h4 class="contact-one__info__title">
                                            @if (str_contains(strtolower($key), 'email'))
                                                <a href="mailto:{{ $value }}">{{ $value }}</a>
                                            @elseif (str_contains(strtolower($key), 'phone') || str_contains(strtolower($key), 'hp') || str_contains(strtolower($key), 'wa'))
                                                <a href="tel:{{ $value }}">{{ $value }}</a>
                                            @elseif (filter_var($value, FILTER_VALIDATE_URL))
                                                <a href="{{ $value }}" target="_blank">{{ $value }}</a>
                                            @else
                                                {{ $value }}
                                            @endif
                                        </h4>
                                    </div>
                                </li>
                            @endforeach
                        @endforeach
                    </ul>

                    {{-- Sosial Media --}}
                    <div class="contact-one__content__social mt-3 text-center">
                        @php
                            $socialKeys = ['instagram', 'facebook', 'twitter', 'youtube', 'pinterest'];
                        @endphp
                        @foreach($groupedContacts as $key => $items)
                            @if(collect($socialKeys)->contains(strtolower($key)))
                                @foreach($items as $item)
                                    <a href="{{ $item->value }}" class="mx-2" target="_blank">
                                        <i class="{{ App\Http\Controllers\ContactController::getContactIcon($key) }}"></i>
                                    </a>
                                @endforeach
                            @endif
                        @endforeach
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

@include('layouts.footer')
