@extends('layout.backend.main', ['activePage' => 'admin.orders', 'titlePage' => 'Semua Pesanan'])

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Daftar Semua Pesanan</h3>
        <a href="{{ route('admin.orders.export') }}" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Export Excel
        </a>
    </div>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                @php
                    $statusColors = [
                        'pending' => 'warning',
                        'paid' => 'primary',
                        'delivered' => 'success',
                        'reviewed' => 'info',
                        'cancelled' => 'danger',
                    ];
                    $badgeClass = $statusColors[$order->status] ?? 'secondary';
                    
                    $totalArray = json_decode($order->totalprice, true);
                    $totalAmount = is_array($totalArray) ? array_sum($totalArray) : 0;

                @endphp
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ $order->nama ?? $order->user->name }}</td>
                    <td>{{ $order->user->email }}</td>
                    <td>
                        <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                    </td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                    <td>Rp {{ number_format($totalAmount, 0, ',', '.') }}</td>
                    <td>
                        <button class="btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal{{ $order->id }}">
                            Detail
                        </button>
                    </td>
                </tr>
            @php
          $types = json_decode($order->item_type, true);
          $ids = json_decode($order->item_id, true);
          $prices = json_decode($order->totalprice, true);
        @endphp
                <!-- MODAL -->
                <div class="modal fade" id="detailModal{{ $order->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $order->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel{{ $order->id }}">Detail Pesanan #{{ $order->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Detail Informasi -->
                        <p><strong>Nama Pemesan:</strong> {{ $order->nama ?? $order->user->name }}</p>
                        <p><strong>Alamat:</strong> {{ $order->address }}, {{ $order->shipping_city }}</p>
                        <p><strong>Telepon:</strong> {{ $order->shipping_phonenumber }}</p>
                        <p><strong>Status:</strong>
                        <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($order->status) }}</span>
                        </p>
                        <p><strong>Waktu Order:</strong> {{ $order->created_at->translatedFormat('d F Y H:i') }}</p>
                        <!-- Tabel Item -->
                        <div class="mt-4">
                            <h5>Detail Item</h5>
                            <div class="mb-3">
                            @foreach($ids as $i => $id)
                                @php
                                    $type = $types[$i];
                                    $price = $prices[$i];

                                    if ($type === 'research_data') {
                                        $item = \App\Models\ResearchData::find($id);
                                        $itemTitle = $item ? $item->research_title : 'Dataset #' . $id;
                                    } else {
                                        $item = \App\Models\Event::find($id);
                                        $itemTitle = $item ? $item->name : 'Event #' . $id;
                                    }
                                @endphp

                                <div class="border rounded p-2 mb-2">
                                    <p class="mb-1"><strong>Jenis:</strong> {{ $type === 'research_data' ? 'Dataset' : 'Event' }}</p>
                                    <p class="mb-1"><strong>Item:</strong> {{ $itemTitle }}</p>
                                    <p class="mb-0"><strong>Harga:</strong> Rp {{ number_format($price, 0, ',', '.') }}</p>
                                </div>
                            @endforeach

                            </div>

                            @if($order->coupon)
                                <p><strong>Diskon ({{ $order->coupon->code }}):</strong>
                                    -Rp {{ number_format(
                                        $order->coupon->type === 'percent'
                                            ? array_sum($prices) * $order->coupon->value / 100
                                            : $order->coupon->value, 0, ',', '.'
                                    ) }}
                                </p>
                            @endif

                            <p class="mt-2"><strong>Total:</strong>
                                Rp {{ number_format(
                                    max(array_sum($prices) - ($order->coupon
                                        ? ($order->coupon->type === 'percent'
                                            ? array_sum($prices) * $order->coupon->value / 100
                                            : $order->coupon->value)
                                        : 0), 0), 0, ',', '.'
                                ) }}
                            </p>
                        </div>

                    </div>
                    </div>
                </div>
                </div>

            @empty
                <tr><td colspan="7" class="text-center">Tidak ada pesanan ditemukan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
