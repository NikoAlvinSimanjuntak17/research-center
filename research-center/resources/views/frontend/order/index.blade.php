@php
    use App\Helpers\Translator;
    $locale = app()->getLocale();
@endphp

@extends('layout.frontend.main', ['activePage' => 'orders', 'titlePage' => __('Pesanan Saya')])
@section('title', 'Pesanan Saya')

@section('css')
<link href="{{ asset('frontend/gardyn/css/order.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
@if(session('error'))
    <div class="alert alert-danger" style="margin-top: 20em">{{ session('error') }}</div>
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
                    <li><a href="{{ url('/') }}">{{ Translator::translate('Beranda', $locale, 'id') }}</a></li>
                    <li class="active">{{ Translator::translate('Pesanan', $locale, 'id') }}</li>
                </ul>
                <h1 class="text-uppercase">{{ Translator::translate('Pesanan', $locale, 'id') }}</h1>
                <p class="col-lg-10 lead">{{ Translator::translate('Temukan berbagai pesanan anda dalam penelitian kami yang inovasi dan terpecaya.', $locale, 'id') }}</p>
            </div>
            </div>
        </div>
        <img src="{{ asset('images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
        <div class="de-gradient-edge-top dark"></div>
        <div class="de-overlay"></div>
    </section>
<div class="container-fluid mt-5 order-container">
    <div class="row">
        <div class="col-xl-10 mx-auto" style="margin-top: 8em; margin-bottom: 10em;">
            <div class="card shadow">
                <div class="card-header bg-white border-0">
<h3 class="mb-0">{{ Translator::translate('Pesanan Saya', $locale, 'id') }}</h3>
                </div>
                <div class="card-body">
                    <!-- Tabs -->
                    <ul class="nav nav-tabs justify-content-center" id="orderTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="current-tab" data-bs-toggle="tab"
                                data-bs-target="#current-orders" type="button" role="tab"
                                aria-controls="current-orders" aria-selected="true">
                                {{ Translator::translate('Pesanan Saya', $locale, 'id') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="event-tab" data-bs-toggle="tab"
                                data-bs-target="#my-event" type="button" role="tab"
                                aria-controls="my-event" aria-selected="false">
                                {{ Translator::translate('Kegiatan Saya', $locale, 'id') }}
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="history-tab" data-bs-toggle="tab"
                                data-bs-target="#order-history" type="button" role="tab"
                                aria-controls="order-history" aria-selected="false">
                                {{ Translator::translate('Riwayat Pesanan', $locale, 'id') }}
                            </button>
                        </li>
                    </ul>


                    <!-- Tab Contents -->
                    <div class="tab-content mt-4" id="orderTabsContent">

                    <div class="tab-pane fade show active" id="current-orders" role="tabpanel" aria-labelledby="current-tab">
                            @if($currentOrders->isEmpty())
                                <p class="p-3 text-center">{{ Translator::translate('Tidak ada pesanan.', $locale, 'id') }}</p>
                            @else
                                @foreach($currentOrders as $order)
                                    @php
                                        $itemTypes = json_decode($order->item_type, true);
                                        $itemIds = json_decode($order->item_id, true);
                                        $filePaths = json_decode($order->file_path, true);
                                        $prices = json_decode($order->totalprice, true);
                                        $collapseId = 'collapseOrder' . $order->id;

                                        $steps = in_array('research_data', $itemTypes) ? [
                                            ['Order confirmed', 'fa-check'],
                                            ['Bill paid', 'fa-user'],
                                            ['Get product', 'fa-download'],
                                            ['Review the product', 'fa-star'],
                                        ] : [
                                            ['Order confirmed', 'fa-check'],
                                            ['Bill paid', 'fa-user'],
                                        ];

                                        $statusStep = ['pending' => 1, 'paid' => 2, 'delivered' => 3, 'reviewed' => 4];
                                        $activeStep = $statusStep[$order->status] ?? 0;
                                    @endphp

                                    <div class="card mb-3" data-order-id="{{ $order->id }}">
                                        <div class="card-header" id="heading{{ $order->id }}">
                                            <h2 class="mb-0">
                                                <button class="btn" style="background-color: #384c34; color:white;" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}">
                                                    {{ Translator::translate('Pesanan', $locale, 'id') }}: #{{ $order->id }}
                                                </button>
                                            </h2>
                                        </div>
                                        <div id="{{ $collapseId }}" class="collapse show" aria-labelledby="heading{{ $order->id }}">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col"><strong>{{ Translator::translate('Waktu Pemesanan', $locale, 'id') }}:</strong><br>
                                                        {{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y') }}</div>
                                                    <div class="col"><strong>Status:</strong><br>{{ ucfirst($order->status) }}</div>
                                                    <div class="col"><strong>{{ Translator::translate('Faktur', $locale, 'id') }}:</strong><br>
                                                        <a href="{{ route('frontend-orders.invoice', $order->id) }}" class="btn-sm btn-secondary" target="_blank">
                                                            {{ Translator::translate('Unduh Faktur', $locale, 'id') }}
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="track my-4 d-flex justify-content-between">
                                                    @foreach($steps as $i => [$text, $icon])
                                                        <div class="step {{ $i < $activeStep ? 'active' : '' }}">
                                                            <span class="icon"><i class="fa {{ $icon }}"></i></span>
                                                            <span class="text">{{ $text }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <ul class="row mt-5">
                                                    @foreach($itemIds as $i => $id)
                                                        @php
                                                            $type = $itemTypes[$i];
                                                            $price = $prices[$i] ?? 0;
                                                            $file = $filePaths[$i] ?? '';
                                                            $img = $type === 'event' ? asset($file) : asset('preview-image/' . basename($file));

                                                            if ($type === 'research_data') {
                                                                $research = \App\Models\ResearchData::find($itemIds[$i]);
                                                                $title = $research?->research_title ?? 'Unknown Dataset';
                                                            } elseif ($type === 'event') {
                                                                $title = 'Event #' . $itemIds[$i];
                                                            } else {
                                                                $title = strtoupper($type) . ' #' . $itemIds[$i];
                                                            }
                                                        @endphp

                                                        <li class="col-md-4 mt-3">
                                                            <figure class="itemside mb-3">
                                                                <div class="aside">
                                                                    @if ($type === 'research_data')
                                                                        <div class="d-flex align-items-center justify-content-center border" style="width: 80px; height: 80px;">
                                                                            <div class="text-center">
                                                                                <i class="fas fa-database fa-lg text-primary"></i><br>
                                                                                <small class="text-muted">{{ Translator::translate('Dataset', $locale, 'id') }}</small>
                                                                            </div>
                                                                        </div>
                                                                    @elseif ($type === 'event')
                                                                        <div class="d-flex align-items-center justify-content-center text-dark border" style="width: 80px; height: 80px;">
                                                                            <div class="text-center">
                                                                                <i class="fas fa-calendar-alt fa-lg text-primary"></i><br>
                                                                                <small>{{ Translator::translate('Acara', $locale, 'id') }}</small>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <img src="{{ $img }}" class="img-sm border" style="height: 80px; object-fit: cover;">
                                                                    @endif
                                                                </div>

                                                                <figcaption class="info align-self-center">
                                                                    <p class="title">{{ $title }}</p>
                                                                    <span class="text-muted">{{ $price == 0 ? 'Free' : 'Rp ' . number_format($price, 0, ',', '.') }}</span>
                                                                </figcaption>
                                                            </figure>
                                                        </li>
                                                    @endforeach
                                                </ul>

                                                <div> {{-- Start tombol area --}}
                                                    @if($order->status === 'pending' && $order->snap_token)
                                                        <center>
                                                            <button onclick="payNow('{{ $order->snap_token }}')" class="btn-sm btn-warning mt-3">
                                                                <i class="fas fa-credit-card"></i> {{ Translator::translate('Bayar sekarang', $locale, 'id') }}
                                                            </button>
                                                        </center>
                                                    @elseif($order->status === 'delivered')
                                                        <center>    
                                                            <a href="{{ route('frontend-orders.review', $order->id) }}" class="btn-sm btn-white" style="margin-top: 5px">
                                                                <i class="fas fa-star"></i> {{ Translator::translate('Review produk', $locale, 'id') }}
                                                            </a>
                                                        </center>
                                                    @endif

                                                    <div style="margin-top: 2px;">
                                                        @if($order->status !== 'pending' && in_array('research_data', $itemTypes))
                                                            <center>
                                                                <a href="{{ route('frontend-orders.download', $order->id) }}" class="btn-sm btn-success" style="height: 10px;" id="download-btn">
                                                                    <i class="fas fa-download"></i> {{ Translator::translate(text: 'Unduh dataset', target: $locale, source: 'id') }}
                                                                </a>
                                                            </center>
                                                        @endif
                                                    </div>
                                                </div> {{-- End tombol area --}}

                                            </div> {{-- card-body --}}
                                        </div> {{-- collapse --}}
                                    </div> {{-- card --}}
                                @endforeach
                            @endif
                        </div> {{-- tab-pane current-orders --}}

                        <!-- My Event -->
                        <div class="tab-pane fade" id="my-event" role="tabpanel" aria-labelledby="event-tab">
                            @if($eventRegistrations->isEmpty())
                                <p class="p-3 text-center">{{ Translator::translate('Belum ada acara yg diikuti.', $locale, 'id') }}</p>
                            @else
                                @foreach($eventRegistrations as $reg)
                                    @php
                                        $event = $reg->event;
                                        $certificate = $reg->certificate;
                                        $status = $reg->token_verified;
                                    @endphp
                                    <div class="card mb-4 collapse show">
                                        <div class="row g-0">
                                            <div class="col-md-4">
                                                <img src="{{ asset($event->image) }}" class="img-fluid rounded-start" style="height: 40em; object-fit: contain; width: 40em;">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $event->name }}</h5>
                                                    <p class="card-text">{{ $event->description }}</p>
                                                    <p class="card-text"><small class="text-muted">{{ \Carbon\Carbon::parse($event->date)->translatedFormat('d F Y') }}</small></p>

                                                    <div class="mb-2">
                                                        <strong>Status:</strong>
                                                        <span class="badge {{ $status === 'verified' ? 'bg-success' : 'bg-warning' }} text-light px-3 py-1 rounded-pill">
                                                            {{ $status === 'verified' ? 'Present' : 'Not Present' }}
                                                        </span>
                                                    </div>

                                                    @if ($status !== 'verified')
                                                        <form id="form-token-{{ $reg->id }}" onsubmit="verifyToken(event, {{ $reg->id }})">
                                                            <div class="input-group mb-2">
                                                                <input type="text" class="form-control" placeholder="Masukkan token kehadiran" name="attendance_token" required>
                                                                <button class="btn-sm btn-primary" type="submit">{{ Translator::translate('Verifikasi', $locale, 'id') }}</button>
                                                            </div>
                                                        </form>
                                                    @endif

                                                    @if ($status === 'verified' && $certificate)
                                                        <div class="mt-4">
                                                            <a href="{{ asset($certificate->certificate_link) }}" class="btn-sm btn-primary" target="_blank"><i class="fas fa-download"></i> Unduh Sertifikat</a>
                                                        </div>
                                                    @elseif($status === 'verified')
                                                        <div class="alert alert-info mt-3 mb-0">{{ Translator::translate(text: 'Harap tunggu admin akan segera menerbitkan sertifikat.', target: $locale, source: 'id') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                                        
                       
                        <!-- Order History -->
                        <div class="tab-pane fade" id="order-history" role="tabpanel" aria-labelledby="history-tab">
                            @if($historyOrders->isEmpty())
                                <p class="p-3 text-center">{{ Translator::translate('Tidak ada riwayat pesanan.', $locale, 'id') }}</p>
                            @else
                                @foreach($historyOrders as $order)
                                @php
                                    $itemTypes = json_decode($order->item_type, true);
                                    $itemIds = json_decode($order->item_id, true);
                                    $filePaths = json_decode($order->file_path, true);
                                    $prices = json_decode($order->totalprice, true);
                                    $collapseId = 'collapseOrder' . $order->id;

                                    $steps = in_array('research_data', $itemTypes) ? [
                                        ['Order confirmed', 'fa-check'],
                                        ['Bill paid', 'fa-user'],
                                        ['Get product', 'fa-download'],
                                        ['Review the product', 'fa-star'],
                                    ] : [
                                        ['Order confirmed', 'fa-check'],
                                        ['Bill paid', 'fa-user'],
                                    ];

                                    $statusStep = ['pending' => 1, 'paid' => 2, 'delivered' => 3, 'reviewed' => 4];
                                    $activeStep = $statusStep[$order->status] ?? 0;
                                @endphp

                                <div class="card mb-3" data-order-id="{{ $order->id }}">
                                    <div class="card-header" id="heading{{ $order->id }}">
                                        <h2 class="mb-0">
                                            <button class="btn" style="background-color: #384c34; color:white;" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}">
                                                {{ Translator::translate('Pesanan', $locale, 'id') }}: #{{ $order->id }}
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="{{ $collapseId }}" class="collapse show" aria-labelledby="heading{{ $order->id }}">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col"><strong>{{ Translator::translate('Waktu Pemesanan', $locale, 'id') }}:</strong><br>{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y') }}</div>
                                                <div class="col"><strong>{{ Translator::translate('Status', $locale, 'id') }}:</strong><br>{{ ucfirst($order->status) }}</div>
                                                <div class="col"><strong>{{ Translator::translate(text: 'Faktur', target: $locale, source: 'id') }}:</strong><br>
                                                <a href="{{ route('frontend-orders.invoice', $order->id) }}" class="btn-sm btn-secondary" target="_blank">
                                                    {{ Translator::translate('Unduh Faktur', $locale, 'id') }}
                                                </a>
                                                </div>
                                            </div>
                                            <div class="track my-4 d-flex justify-content-between">
                                                @foreach($steps as $i => [$text, $icon])
                                                    <div class="step {{ $i < $activeStep ? 'active' : '' }}">
                                                        <span class="icon"><i class="fa {{ $icon }}"></i></span>
                                                        <span class="text">{{ $text }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <ul class="row mt-5">
                                            @foreach($itemIds as $i => $id)
                                                @php

                                                    $type = $itemTypes[$i];
                                                    $price = $prices[$i] ?? 0;
                                                    $file = $filePaths[$i] ?? '';
                                                    $img = $type === 'event' ? asset($file) : asset('preview-image/' . basename($file));

                                                    if ($type === 'research_data') {
                                                        $research = \App\Models\ResearchData::find($itemIds[$i]);
                                                        $title = $research?->research_title ?? 'Unknown Dataset';
                                                    } elseif ($type === 'event') {
                                                        $title = 'Event #' . $itemIds[$i]; // atau ambil dari model Event jika tersedia
                                                    } else {
                                                        $title = strtoupper($type) . ' #' . $itemIds[$i];
                                                    }
                                                @endphp

                                                <li class="col-md-4 mt-3">
                                                    <figure class="itemside mb-3">
                                                        <div class="aside">
                                                            @if ($type === 'research_data')
                                                                <div class="d-flex align-items-center justify-content-center border" style="width: 80px; height: 80px;">
                                                                    <div class="text-center">
                                                                        <i class="fas fa-database fa-lg text-primary"></i><br>
                                                                        <small class="text-muted">{{ Translator::translate('Dataset', $locale, 'id') }}</small>
                                                                    </div>
                                                                </div>
                                                            @elseif ($type === 'event')
                                                                <div class="d-flex align-items-center justify-content-center text-dark border" style="width: 80px; height: 80px;">
                                                                    <div class="text-center">
                                                                        <i class="fas fa-calendar-alt fa-lg text-primary"></i><br>
                                                                        <small>{{ Translator::translate('Acara', $locale, 'id') }}</small>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <img src="{{ $img }}" class="img-sm border" style="height: 80px; object-fit: cover;">
                                                            @endif
                                                        </div>

                                                        <figcaption class="info align-self-center">
                                                            <p class="title">{{ $title }}</p>
                                                            <span class="text-muted">{{ $price == 0 ? 'Free' : 'Rp ' . number_format($price, 0, ',', '.') }}</span>
                                                        </figcaption>
                                                    </figure>
                                                </li>
                                            @endforeach
                                            </ul>

                                            <div>
                                            @if($order->status === 'pending' && $order->snap_token)
                                                <center>
                                                    <button onclick="payNow('{{ $order->snap_token }}')" class="btn-sm btn-warning mt-3">
                                                        <i class="fas fa-credit-card"></i> {{ Translator::translate('Bayar sekarang', $locale, 'id') }}
                                                    </button>
                                                </center>
                                                @elseif($order->status === 'delivered')
                                                <center>    
                                                <a href="{{ route('frontend-orders.review', $order->id) }}" class="btn-sm btn-white" style="margin-top: 5px">
                                                        <i class="fas fa-star"></i> {{ Translator::translate('Review produk', $locale, 'id') }}
                                                    </a>
                                                </center>
                                                @endif
                                                <div style="margin-top: 2px;">
                                                @if($order->status !== 'pending' && in_array('research_data', $itemTypes))
                                                <center>
                                                    <a href="{{ route('frontend-orders.download', $order->id) }}" class="btn-sm btn-success" style="height: 10px;" id="download-btn">
                                                        <i class="fas fa-download"></i> {{ Translator::translate(text: 'Unduh dataset', target: $locale, source: 'id') }}
                                                    </a>
                                                </center>
                                                
                                                @endif
                                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                                @endforeach
                            @endif
                        </div>
                        </div>


                        
                    </div>
                

                    </div>
                </div>
            </div>
        </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- Bootstrap 5 Bundle JS (Popper.js already included) -->

@endsection
@push('js')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
function verifyToken(event, regId) {
    event.preventDefault();
    const form = document.getElementById('form-token-' + regId);
    const token = form.querySelector('input[name="attendance_token"]').value;

    // Tambahkan fetch/axios call ke route verifikasi di sini
    alert("Token: " + token + " (contoh: AJAX logic ke backend)");
}

function verifyToken(e, regId) {
  e.preventDefault();

  const form = e.target;
  const token = form.attendance_token.value;
  const submitBtn = form.querySelector('button');

  submitBtn.disabled = true;
  submitBtn.innerText = 'Verifying...';

  axios.post("{{ route('frontend-events.verifyToken') }}", {
    event_registration_id: regId,
    attendance_token: token
  }, {
    headers: {
      'Accept': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  })
  .then(res => {
    console.log("✅ RESPONSE SUCCESS", res);
    Swal.fire({
      icon: 'success',
      title: 'Berhasil',
      text: res.data.message || 'Token berhasil diverifikasi',
      timer: 2000,
      showConfirmButton: false
    }).then(() => {
      location.reload(); // 🔁 Reload halaman setelah alert sukses ditutup
    });
  })
  .catch(err => {
    console.log("❌ RESPONSE ERROR", err);
    Swal.fire({
      icon: 'error',
      title: 'Gagal Verifikasi',
      text: err.response?.data?.message || 'Token tidak valid atau terjadi kesalahan',
    }).then(() => {
      location.reload(); // 🔁 Reload halaman setelah alert error ditutup (opsional)
    });
  })
  .finally(() => {
    submitBtn.disabled = false;
    submitBtn.innerText = 'Verifikasi';
  });
}


    function payNow(token) {
        window.snap.pay(token, {
            onSuccess: function () {
                window.location.href = "{{ route('frontend-orders.index') }}";
            },
            onClose: function () {
                window.location.href = "{{ route('frontend-orders.index') }}";
            }
        });
    }
document.getElementById('download-btn')?.addEventListener('click', function () {
        setTimeout(() => {
            window.location.reload(); // Ini akan me-refresh halaman
        }, 3000); // Tunggu 1 detik sebelum refresh
    });

  </script>    
@endpush