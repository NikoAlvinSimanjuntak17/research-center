@php
                use App\Helpers\Translator;
        $locale = app()->getLocale();
@endphp
@extends('layout.frontend.main', ['activePage' => 'cart', 'titlePage' => __('Keranjang')])
@section('title', 'Keranjang')
@section('css')
<style>
    .custom-secondary-button:hover {
        background-color: #5c636a;
        color: white;
        text-decoration: none;
    }
</style>

    
@endsection
@section('content')
<div class="container my-5">
<h2 class="mb-4" style="margin-top: 3em">{{ Translator::translate('Keranjang Saya', $locale, 'id') }}</h2>
    <a class="custom-secondary-button" href="{{ route('frontend-dataset.index') }}"
    style="
        display: inline-block;
        padding: 6px 12px;
        background-color: none; /* Bootstrap secondary */
        border: 1px solid #6c757d;
        border-radius: 4px;
        font-size: 0.875rem;
        text-decoration: none;
        vertical-align: middle;
    ">
    <i class="fas fa-arrow-left me-1"></i> {{ Translator::translate('Kembali ke Dataset', $locale, 'id') }}
    </a>


    <div class="row mt-3">
        <div class="col-md-8">
        <h4>{{ Translator::translate('Data Riset', $locale, 'id') }}</h4>
            @if($datasetItems->isEmpty())
                <div class="alert alert-info">Keranjang Anda kosong.</div>
            @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ Translator::translate('Judul', $locale, 'id') }}</th>
                        <th>{{ Translator::translate('Harga', $locale, 'id') }}</th>
                        <th>{{ Translator::translate('Aksi', $locale, 'id') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datasetItems as $item)
                        <tr>
                            <td>{{ $item->research_data->research_title ?? '-' }}</td>
                            <td>{{ $item->price > 0 ? 'Rp ' . number_format($item->price, 0, ',', '.') : 'Gratis' }}</td>
                            <td>
                                <form action="{{ route('frontend-cart.remove', $item->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class=" btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif

            <h4 class="mt-5">{{ Translator::translate('Tiket Event', $locale, 'id') }}</h4>
            @if($eventItems->isEmpty())
            <div class="alert alert-info">{{ Translator::translate('Keranjang Anda kosong.', $locale, 'id') }}</div>
            @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Event</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($eventItems as $item)
                        <tr>
                            <td>{{ $item->event->name ?? '-' }}</td>
                            <td>{{ $item->price > 0 ? 'Rp ' . number_format($item->price, 0, ',', '.') : 'Gratis' }}</td>
                            <td>
                                <form action="{{ route('frontend-cart.remove', $item->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">{{ Translator::translate('Hapus', $locale, 'id') }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

        {{-- Sisi Kanan: Kupon & Total --}}
        <div class="col-md-4" style="margin-top: 3em">
            <div class="card shadow-sm p-4">
            @if(!$datasetItems->isEmpty() || !$eventItems->isEmpty())
            <div class="d-flex justify-content-between align-items-center">
<h5 class="mb-0">{{ Translator::translate('Total Harga', $locale, 'id') }}</h5>
                <p class="mb-0"><strong>Rp {{ number_format($totalPrice, 0, ',', '.') }}</strong></p>
            </div>
            @if(session('discount'))
                <hr>
                <div class="d-flex justify-content-between">
<p class="mb-1">{{ Translator::translate('Potongan Kupon:', $locale, 'id') }}</p>
                    <p class="mb-1 text-success"><strong>- Rp {{ number_format(session('discount'), 0, ',', '.') }}</strong></p>
                </div>

                <div class="d-flex justify-content-between">
<p class="mb-2">{{ Translator::translate('Total Akhir:', $locale, 'id') }}</p>
                    <p class="mb-2 text-primary"><strong>Rp {{ number_format(session('final_price'), 0, ',', '.') }}</strong></p>
                </div>

<label for="appliedCoupon" class="form-label mt-2">{{ Translator::translate('Kode Kupon', $locale, 'id') }}</label>
                <input type="text" id="appliedCoupon" class="form-control" value="{{ session('coupon_code') }}" disabled>
            @else

                    {{-- Form kupon hanya ditampilkan jika belum ada diskon --}}
                    <hr>
                    <form method="POST" action="{{ route('frontend-cart.applyCoupon') }}">
                        @csrf
<label for="code">{{ Translator::translate('Kode Kupon', $locale, 'id') }}</label>
                        <div class="input-group mb-2">
<input type="text" name="code" class="form-control" placeholder="{{ Translator::translate('Masukkan kode kupon', $locale, 'id') }}">
<button class="btn-sm btn-primary" type="submit">{{ Translator::translate('Terapkan', $locale, 'id') }}</button>
                        </div>
                    </form>
                @endif

                @if(session('coupon_error'))
<div class="alert alert-danger mt-2">{{ Translator::translate(session('coupon_error'), $locale, 'id') }}</div>
                @endif
                @if(session('coupon_success'))
<div class="alert alert-success mt-2">{{ Translator::translate(session('coupon_success'), $locale, 'id') }}</div>
                @endif
                @endif
                @if(!$datasetItems->isEmpty() || !$eventItems->isEmpty())
                    <a href="{{ route('frontend-checkout.index') }}" class="btn-sm btn-success w-100 mt-3 d-flex justify-content-center align-items-center">
                        <i class="fas fa-check-circle me-2"></i> {{ Translator::translate('Lanjut ke Checkout', $locale, 'id') }}
                    </a>
                @endif


            </div>
        </div>
    </div>
</div>
@endsection
