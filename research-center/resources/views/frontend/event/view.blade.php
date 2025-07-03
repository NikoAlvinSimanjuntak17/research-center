@php
    use App\Helpers\Translator;
    $locale = app()->getLocale();
@endphp
@extends('layout.frontend.main', ['activePage' => 'event', 'titlePage' => __('Detail Event')])
@section('title', Translator::translate('Detail Event', $locale, 'id'))
@section('css')
<style>
.promo-floating-box {
    position: fixed; /* agar tetap saat scroll */
    top: 50%;
    left: 20px;
    transform: translateY(-50%);
    z-index: 1000;
    width: 200px;
    background-color: #f8f9fa;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    border: 1px solid #ddd;
}

@media (max-width: 768px) {
    .promo-floating-box {
        display: none; /* sembunyikan di layar kecil */
    }
}

</style>
    
@endsection
@section('content')
    @if(isset($latestCoupon))
        <div class="promo-floating-box text-center">
            <h6 class="text-uppercase text-primary mb-2" style="font-weight: 600;">🎉 Promo Terbaru</h6>
            <div class="fs-5 fw-bold text-dark">{{ $latestCoupon->code }}</div>
            <div class="text-muted small mb-2">Berlaku hingga <br>{{ \Carbon\Carbon::parse($latestCoupon->expired_at)->translatedFormat('d F Y') }}</div>
        </div>
    @endif
<section id="subheader" class="relative jarallax text-light">
    @php
        use Illuminate\Support\Facades\DB;
        $slider = DB::table('sliders')->where('active', 1)->orderBy('updated_at', 'desc')->first();
    @endphp

    <img src="{{ asset('storage/sliders/' . $slider->image) }}" class="jarallax-img" alt="">
    <div class="container relative z-index-1000">
        <div class="row">
            <div class="col-lg-6">
                <ul class="crumb">
                    <li><a href="{{ url('/') }}">{{ Translator::translate('Beranda', $locale, 'id') }}</a></li>
                    <li class="active">{{ Translator::translate('Acara', $locale, 'id') }}</li>
                </ul>
                <h1 class="text-uppercase">{{ Translator::translate('Pelatihan', $locale, 'id') }}</h1>
                <p class="col-lg-10 lead">{{ Translator::translate('Temukan berbagai acara pelatihan kami.', $locale, 'id') }}</p>
            </div>
        </div>
    </div>
    <img src="{{ asset('images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
    <div class="de-gradient-edge-top dark"></div>
    <div class="de-overlay"></div>
</section>

<div class="container" style="margin-top: 10em; margin-bottom: 7em;">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-lg rounded-4 p-4">
                <h2 class="mb-3">{{ Translator::translate($event->name, $locale, 'id') }}</h2>

                <ul class="list-inline text-muted mb-4">
                    <li class="list-inline-item"><i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($event->date)->translatedFormat('d F Y') }}</li>
                    <li class="list-inline-item"><i class="fas fa-clock me-1"></i> {{ $event->time }}</li>
                    <li class="list-inline-item"><i class="fas fa-users me-1"></i> {{ $event->people }} {{ Translator::translate('orang', $locale, 'id') }}</li>
                </ul>

                @if ($event->image)
                    <img src="{{ asset($event->image) }}" alt="Event Image" class="mb-4 rounded w-100" style="max-height: 1000px; object-fit: cover;">
                @endif

                <p><strong>{{ Translator::translate('Jenis Event', $locale, 'id') }}:</strong> {{ ucfirst($event->event_type) }}</p>
                <p><strong>{{ Translator::translate('Status', $locale, 'id') }}:</strong> {{ ucfirst($event->status) }}</p>
                <p><strong>{{ Translator::translate('Ticket', $locale, 'id') }}:</strong>
                    <span class="text-success fw-bold">
                        {{ $event->price > 0 ? 'Rp ' . number_format($event->price, 0, ',', '.') : Translator::translate('Gratis', $locale, 'id') }}
                    </span>
                </p>

                <p><strong>{{ Translator::translate('Periode Pendaftaran', $locale, 'id') }}:</strong><br>
                    {{ \Carbon\Carbon::parse($event->registration_start_date)->translatedFormat('d F Y') }} {{ Translator::translate('s/d', $locale, 'id') }}
                    {{ \Carbon\Carbon::parse($event->registration_end_date)->translatedFormat('d F Y') }}
                </p>

                <hr>

                <p><strong>{{ Translator::translate('Deskripsi', $locale, 'id') }}:</strong></p>
                <p>{!! nl2br((Translator::translateRich($event->description, $locale, 'id'))) !!}</p>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('frontend-event.index') }}" class="btn-sm btn-secondary">{{ Translator::translate('Kembali', $locale, 'id') }}</a>

                    @auth
                        <form action="{{ route('frontend-cart.add', $event->id) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="type" value="event">
                            <button type="submit" class="btn-sm btn-primary">
                                <i class="fas fa-cart-plus me-1"></i> {{ Translator::translate('Daftar / Beli Ticket', $locale, 'id') }}
                            </button>
                        </form>
                    @endauth

                    @guest
                        <button onclick="showLoginAlert()" class="btn-sm btn-primary">
                            <i class="fas fa-cart-plus me-1"></i> {{ Translator::translate('Daftar / Beli Ticket') }}
                        </button>
                    @endguest
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showLoginAlert() {
        Swal.fire({
            icon: 'warning',
            title: '{{ Translator::translate('Anda belum login!') }}',
            text: '{{ Translator::translate('Silakan login terlebih dahulu untuk mendaftar event atau menambahkannya ke keranjang.') }}',
            confirmButtonText: '{{ Translator::translate('Login Sekarang') }}',
            showCancelButton: true,
            cancelButtonText: '{{ Translator::translate('Batal') }}'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('login') }}";
            }
        });
    }
</script>
@endpush
