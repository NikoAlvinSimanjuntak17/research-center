@php
    use App\Helpers\Translator;
    $locale = app()->getLocale();
@endphp
@extends('layout.frontend.main', ['activePage' => 'datasets', 'titlePage' => 'Detail Dataset'])
@section('title', Translator::translate('Detail Dataset', $locale, 'id'))

@section('css')
<style>
    .preview-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        padding: 1em;
        background-color: rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
    }
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
                    <li class="active">{{ Translator::translate('Data Riset', $locale, 'id') }}</li>
                </ul>
                <h1 class="text-uppercase">{{ Translator::translate('Data Riset', $locale, 'id') }}</h1>
                <p class="col-lg-10 lead">{{ Translator::translate('Temukan hasil data penelitian kami yang inovasi dan terpecaya.', $locale, 'id') }}</p>
            </div>
        </div>
    </div>
    <img src="{{ asset('images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
    <div class="de-gradient-edge-top dark"></div>
    <div class="de-overlay"></div>
</section>

<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-lg rounded-4 p-4" style="margin-top: 10em;">
                <h2 class="mb-3">{{ Translator::translate($dataset->research_title, $locale, 'id') }}</h2>

                <ul class="list-inline text-muted mb-4">
                    <li class="list-inline-item"><i class="fas fa-user me-1"></i> {{ $dataset->researcher_name }}</li>
                    <li class="list-inline-item"><i class="fas fa-flask me-1"></i> {{ Translator::translate($dataset->research_category_name, $locale, 'id') }}</li>
                    <li class="list-inline-item"><i class="fas fa-calendar me-1"></i> {{ \Carbon\Carbon::parse($dataset->created_at)->translatedFormat('d F Y') }}</li>
                </ul>

                {{-- Preview --}}
                @php
                    $fileName = $dataset->preview_path ? basename($dataset->preview_path) : null;
                    $ext = $fileName ? strtolower(pathinfo($fileName, PATHINFO_EXTENSION)) : null;
                @endphp

                <div class="mb-4">
                    @if ($ext === 'pdf')
                        <div class="preview-wrapper" style="position: relative; height: 1000px; border-radius:12px; overflow: hidden;">
                            <img src="{{ url('/preview-image/' . $fileName) }}" style="width: 100%; height: 100%; object-fit: cover;" alt="Preview PDF">
                            <div class="preview-overlay">
                                <h3 style="font-size: 2em; font-weight: bold;">{{ Translator::translate("Anda Membaca Pratinjau", $locale, 'id') }}</h3>
                                <p style="font-size: 1.2em;">{{ Translator::translate('Beli untuk akses penuh', $locale, 'id') }}</p>
                            </div>
                        </div>
                    @elseif(in_array($ext, ['fastq', 'fq']))
                        <div class="preview-wrapper" style="position: relative; height: 1000px; border-radius:12px; overflow: hidden;">
                            <iframe src="{{ url('/preview-image/' . $fileName . '?bytes=9000') }}"
                                    style="width:100%; height:100%; border:none; background:#f8f8f8;"
                                    scrolling="no"
                                    seamless
                                    onload="this.contentWindow.document.body.style.overflow='hidden';"
                            ></iframe>
                            <div class="preview-overlay">
                                <h3 style="font-size: 2em; font-weight: bold;">{{ Translator::translate("Anda Membaca Pratinjau", $locale, 'id') }}</h3>
                                <p style="font-size: 1.2em;">{{ Translator::translate('Beli untuk akses penuh', $locale, 'id') }}</p>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-muted" style="height: 1000px; background:#f0f0f0; border-radius:12px; display: flex; align-items: center; justify-content: center;">
                            {{ Translator::translate('Preview tidak tersedia', $locale, 'id') }}
                        </div>
                    @endif
                </div>

                {{-- Detail --}}
                <p><strong>{{ Translator::translate('Abstrak', $locale, 'id') }}:</strong><br>{{ Translator::translate($dataset->abstract, $locale, 'id') }}</p>
                <p><strong>{{ Translator::translate('Tahun', $locale, 'id') }}:</strong> {{ $dataset->year }}</p>
                <p><strong>{{ Translator::translate('DOI', $locale, 'id') }}:</strong> {{ $dataset->doi }}</p>
                <p><strong>{{ Translator::translate('Harga', $locale, 'id') }}:</strong>
                    <span class="text-success fw-bold">
                        {{ $dataset->price > 0 ? 'Rp ' . number_format($dataset->price, 0, ',', '.') : Translator::translate('Free', $locale, 'id') }}
                    </span>
                </p>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-between mt-3">
                    <a href="{{ route('frontend-dataset.index', $dataset->id) }}" class="btn-sm btn-secondary">
                        {{ Translator::translate('Kembali', $locale, 'id') }}
                    </a>
                    @auth
                        <form method="POST" action="{{ route('frontend-cart.add', $dataset->id) }}">
                            @csrf
                            <button type="submit" class="btn-sm btn-primary">
                                <i class="fas fa-shopping-cart me-1"></i> {{ Translator::translate('Tambah Keranjang', $locale, 'id') }}
                            </button>
                        </form>
                    @endauth

                    @guest
                        <button class="btn-sm btn-primary" onclick="showLoginAlert()">
                            <i class="fas fa-shopping-cart me-1"></i> {{ Translator::translate('Tambah Keranjang', $locale, 'id') }}
                        </button>
                    @endguest
                </div>
            </div>
        </div>
                    {{-- Bagian Review --}}
@if ($dataset->reviews->count() > 0)
<section class="mt-4 mb-3">
    <div class="container">
        <center><h3 class="mb-4">{{ Translator::translate('Ulasan Pengguna', $locale, 'id') }}</h3></center>

        @foreach ($dataset->reviews as $review)
            <div class="d-flex mb-4 border-bottom pb-3 align-items-start">
                {{-- Foto Profil / Inisial --}}
                <div class="me-3">
                    @if ($review->user->user_img && file_exists(public_path('storage/' . $review->user->user_img)))
                        <img src="{{ asset('storage/' . $review->user->user_img) }}"
                             alt="Profile" width="45" height="45"
                             class="rounded-circle" style="object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                             style="width: 45px; height: 45px; font-size: 18px; font-weight: bold;">
                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                {{-- Isi Review --}}
                <div>
                    <strong>{{ $review->user->name }}</strong><br>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($review->created_at)->translatedFormat('d F Y') }}</small>
                    <p class="mt-2 mb-0" style="white-space: pre-wrap; max-width: 100%; line-height: 1.6;">{{ $review->review }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif


    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showLoginAlert() {
        Swal.fire({
            icon: 'warning',
            title: '{{ Translator::translate("Anda belum login!", $locale, 'id') }}',
            text: '{{ Translator::translate("Silakan login terlebih dahulu untuk menambahkan ke keranjang.", $locale, 'id') }}',
            confirmButtonText: '{{ Translator::translate("Login Sekarang", $locale, 'id') }}',
            showCancelButton: true,
            cancelButtonText: '{{ Translator::translate("Batal", $locale, 'id') }}',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('login') }}";
            }
        });
    }
</script>
@endpush
