@extends('layout.frontend.main', ['activePage' => 'event', 'titlePage' => __('Event')])
@section('title', 'Event')
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
 {{-- Box Promo Floating --}}
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
        use App\Helpers\Translator;
        $locale = app()->getLocale();
        $slider = DB::table('sliders')
        ->where('active', 1)
        ->orderBy('updated_at', 'desc')
        ->first(); // ganti get() dengan first()

        @endphp
        <img src="{{ asset(asset('storage/sliders/' . $slider->image)) }}" class="jarallax-img" alt="">
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

<div class="container" style="margin-top: 7em; margin-bottom: 7em;">

    <div class="text-center mb-4">
        <h2 class="fw-bold">{{ Translator::translate('Pelatihan & Event', $locale, 'id') }}</h2>
        <p>{{ Translator::translate('Ikuti berbagai kegiatan menarik yang kami selenggarakan', $locale, 'id') }}</p>
    </div>

    {{-- Filter --}}
    <div class="d-flex justify-content-center mb-4 gap-2">
        <a href="{{ route('frontend-event.index') }}" class="btn-sm btn-primary">{{ Translator::translate('All', $locale, 'id') }}</a>
        <a href="{{ route('frontend-event.index', ['event_type' => 'workshop']) }}" class="btn-sm btn-primary">Workshop</a>
        <a href="{{ route('frontend-event.index', ['event_type' => 'seminar']) }}" class="btn-sm btn-primary">Seminar</a>
        <a href="{{ route('frontend-event.index', ['event_type' => 'conference']) }}" class="btn-sm btn-primary">Conference</a>
    </div>


    {{-- Event List --}}
    <div class="row">
        @forelse($events as $event)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm rounded-4">
                    @if ($event->image)
                        <img src="{{ asset($event->image) }}" class="card-img-top" style="height: 30em; object-fit: cover;" alt="Event Image">
                    @endif

                    <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title text-truncate" style="max-width: 100%;">
                        <a href="{{route('frontend-event.view', ['id' => $event->id])}}">
                        {{ Translator::translate($event->name, $locale, 'id') }}
                        </a>
                    </h5>
                        <p class="mb-2 text-muted">
                            <i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($event->date)->translatedFormat('d F Y') }}<br>
                            <i class="fas fa-clock"></i> {{ $event->time }}
                        </p>
                        <p class="text-muted"><i class="fas fa-users"></i> {{ Translator::translate('Kuota', $locale, 'id') }}: {{ $event->people }}</p>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="fw-bold text-success">
                            {{ $event->price > 0 ? 'Rp ' . number_format($event->price, 0, ',', '.') : Translator::translate('Gratis', $locale, 'id') }}
                        </span>                            
                        <div class="d-flex gap-2">
                            <a href="{{route('frontend-event.view',['id'=>$event->id])}}" class="btn-sm btn-secondary">
                                {{ Translator::translate('Detail', $locale, 'id') }}
                            </a>                            
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
                                    <i class="fas fa-cart-plus me-1"></i> {{ Translator::translate('Daftar / Beli Ticket', $locale, 'id') }}
                                </button>
                            @endguest

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">{{ Translator::translate('Tidak ada event ditemukan.', $locale, 'id') }}</p>
        @endforelse
    </div>

    {{-- Pagination --}}
<div class="mt-4">
    {{ $events->withQueryString()->links() }}
</div>

{{-- Latest Events --}}
<div class="mt-5 text-center">
<h4 class="mb-4">{{ Translator::translate('Event Terbaru', $locale, 'id') }}</h4>
    <div class="d-flex justify-content-center flex-wrap gap-3">
        @foreach ($latestEvents as $item)
            <div class="card shadow-sm border-0" style="width: 220px;">
                @if ($item->image)
                    <img src="{{ asset($item->image) }}" class="card-img-top" style="height: 120px; object-fit: cover;" alt="Latest Event">
                @endif
                <div class="card-body p-2">
                    <h6 class="card-title mb-1" style="font-size: 15px;">{{ Str::limit(Translator::translate($item->name, $locale, 'id'), 20) }}</h6>
                    <small class="text-muted">
                        <i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($item->date)->translatedFormat('d M Y') }}
                    </small>
                </div>
            </div>
        @endforeach
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
            title: 'Anda belum login!',
            text: 'Silakan login terlebih dahulu untuk mendaftar event atau menambahkannya ke keranjang.',
            confirmButtonText: 'Login Sekarang',
            showCancelButton: true,
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('login') }}";
            }
        });
    }
</script>
@endpush
