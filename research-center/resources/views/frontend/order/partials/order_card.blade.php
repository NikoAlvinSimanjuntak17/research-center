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
                Invoice Order: #{{ $order->id }}
            </button>
        </h2>
    </div>
    <div id="{{ $collapseId }}" class="collapse show" aria-labelledby="heading{{ $order->id }}">
        <div class="card-body">
            <div class="row">
                <div class="col"><strong>Order time:</strong><br>{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('d F Y') }}</div>
                <div class="col"><strong>Status:</strong><br>{{ ucfirst($order->status) }}</div>
                <div class="col"><strong>Invoice:</strong><br>
                <a href="{{ route('frontend-orders.invoice', $order->id) }}" class="btn-sm btn-secondary" target="_blank">
                    Get Invoice
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
                    $title = strtoupper($type) . ' #' . $id;
                @endphp
                <li class="col-md-4 mt-3">
                    <figure class="itemside mb-3">
                        <div class="aside">
                            <img src="{{ $img }}" class="img-sm border" style="height: 80px; object-fit: cover;">
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
                        <i class="fas fa-credit-card"></i> Bayar Sekarang
                    </button>
                </center>
                @elseif($order->status === 'delivered')
                <center>    
                <a href="{{ route('frontend-orders.review', $order->id) }}" class="btn-sm btn-white" style="margin-top: 5px">
                        <i class="fas fa-star"></i> Review Produk
                    </a>
                </center>
                @endif
                <div style="margin-top: 2px;">
                @if($order->status !== 'pending' && in_array('research_data', $itemTypes))
                <center>
                    <a href="{{ route('frontend-orders.download', $order->id) }}" class="btn-sm btn-success">
                        <i class="fas fa-download"></i> Download Dataset
                    </a>
                </center>
                
                @endif
                
        </div>
    </div>
</div>

@push('js')
    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
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
</script>
@endpush
