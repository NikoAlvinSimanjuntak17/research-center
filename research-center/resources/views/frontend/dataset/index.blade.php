@php
    use App\Helpers\Translator;
    $locale = app()->getLocale();
@endphp

@extends('layout.frontend.main', ['activePage' => 'datasets', 'titlePage' => __('Datasets')])
@section('title', 'Datasets')
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
                        <li><a href="{{ url('/') }}">{{ Translator::translate('Home', $locale, 'id') }}</a></li>
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
    <div class="blog-area py-120">
        <div class="container">
            <div class="row">

               
                <div class="col-lg-6 mx-auto" style="margin-top: 7em;">
                    <div class="site-heading text-center">
                        <h2 class="site-title">{{ Translator::translate('DataRiset penelitian', $locale, 'id') }}</h2>
                        <p>{{ Translator::translate('Lihat kumpulan data penelitian dari berbagai peneliti', $locale, 'id') }}</p>
                        

                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4 mx-auto">
                    <form action="{{ route('frontend-dataset.index') }}" method="GET">
                        <select name="category" class="form-select" onchange="this.form.submit()">
                        <option value="">{{ Translator::translate('Semua Kategori', $locale, 'id') }}</option>
                            @foreach ($news_category as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {!! Translator::translate($cat->category_name, $locale, 'id') !!}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            <div class="row">
                @foreach ($datasets as $data)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm h-100 rounded-4 p-3 d-flex flex-column justify-content-between">
                            {{-- Tanggal --}}
                            <div class="text-muted mb-2">
                                <i class="ph-calendar-blank"></i>
                                {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y') }}
                            </div>

                            {{-- Preview --}}
                            @php
                                $fileName = $data->preview_path ? basename($data->preview_path) : null;
                                $ext = $fileName ? strtolower(pathinfo($fileName, PATHINFO_EXTENSION)) : null;
                            @endphp

                            <div class="mb-3">
                                @if ($ext === 'pdf')
                                    <img src="{{ url('/preview-image/' . $fileName) }}"
                                        style="width:100%; height:350px; object-fit:cover; border-radius:12px;" alt="Preview PDF">
                                @elseif(in_array($ext, ['fastq', 'fq']))
                                    <iframe src="{{ url('/preview-image/' . $fileName . '?bytes=1000') }}"
                                        style="width:100%; height:350px; border:none; border-radius:12px; background:#f8f8f8; pointer-events: none;   overflow:hidden; scrollbar-width: none;"
                                        scrolling="no" seamless onload="this.contentWindow.document.body.style.overflow='hidden';">
                                    </iframe>
                                @else
                                    <div style="width:100%; height:350px; display:flex; align-items:center; justify-content:center;
                                                        background:#f0f0f0; border-radius:12px; color:#888;">
                                        Preview tidak tersedia
                                    </div>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div>
                                <ul class="list-unstyled d-flex justify-content-between small text-muted mb-2">
                                    <li><i class="fas fa-user me-1"></i> {{ $data->researcher_name }}</li>
                                    <li><i class="fas fa-flask me-1"></i>{!! Translator::translate($data->research_category_name, $locale, 'id') !!}</li>
                                </ul>

                                <h5 class="fw-semibold mb-3 text-truncate" title="{!! Translator::translate($data->research_title, $locale, 'id') !!}"
                                    style="white-space: normal;">
                                    <a href="{{route('frontend-dataset.view', ['id' => $data->id])}}">
                                    {!! Translator::translate(Str::limit($data->research_title, $locale, 'id'),80) !!}
                                    </a>
                                </h5>


                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-success fw-bold">
                                    {{ $data->price > 0 ? 'Rp ' . number_format($data->price, 0, ',', '.') : Translator::translate('Free', $locale, 'id') }}
                                    </span>
                                    <div class="d-flex gap-2">
                                        @auth
                                            <form method="POST" action="{{ route('frontend-cart.add', $data->id) }}">
                                                @csrf
                                                <button class="btn-sm btn-primary">
                                                    <i class="fas fa-shopping-cart me-1"></i> {{ Translator::translate('Tambah Keranjang', $locale, 'id') }}
                                                </button>
                                            </form>
                                        @endauth

                                        @guest
                                            <button onclick="showLoginAlert()" class="btn-sm btn-primary">
                                                <i class="fas fa-shopping-cart me-1"></i> {{ Translator::translate('Tambah Keranjang', $locale, 'id') }}
                                            </button>
                                        @endguest

                                        <a class="btn-sm btn-secondary text-decoration-none"
                                            href="{{route('frontend-dataset.view', ['id' => $data->id])}}">
                                            Detail
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            

            {{-- Pagination --}}
            <div class="pagination-area mt-5">
                {{ $datasets->links() }}
            </div>
        </div>
    </div>
    

    {{-- Optional JS cart --}}
    {{--
    <script>
        function addToCart(datasetId) {
            alert('Dataset ID ' + datasetId + ' ditambahkan ke cart! (implementasi AJAX di tahap berikutnya)');
        }
    </script> --}}
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showLoginAlert() {
            Swal.fire({
                icon: 'warning',
                title: 'Anda belum login!',
                text: 'Silakan login terlebih dahulu untuk menambahkan ke keranjang.',
                confirmButtonText: 'Login Sekarang',
                showCancelButton: true,
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('login') }}";
                }
            });
        }
    </script>
@endpush