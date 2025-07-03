@php
    use App\Helpers\Translator;
    $locale = app()->getLocale();
@endphp
@extends('layout.frontend.main', ['activePage' => 'checkout', 'titlePage' => __('Checkout')])
@section('title', 'Checkout')

@section('content')
<div class="container my-5">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <h2 style="margin-top: 3em;">{{ Translator::translate('Formulir Checkout', $locale, 'id') }}</h2>
    <form method="POST" action="{{ route('frontend-checkout.placeOrder') }}">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <h5>{{ Translator::translate('Informasi Detail', $locale, 'id') }}</h5>
                <div class="mb-3">
                    <label>{{ Translator::translate('Nama Lengkap', $locale, 'id') }}</label>
                    <span class="text-danger me-1">*</span> 
                    <small class="ms-2 text-muted" style="font-weight: normal;">
                        {{ Translator::translate('Nama ini akan dicetak pada sertifikat.', $locale, 'id') }}
                    </small>
                    <input type="text" name="nama" class="form-control" required>
                    <small class="form-text text-muted">
                        {{ Translator::translate('Masukkan nama lengkap beserta gelar (jika ada), misalnya', $locale, 'id') }}: <em>Dr. Andi Susanto, M.Sc</em>.
                    </small>
                </div>
                <div class="mb-3">
                    <label>{{ Translator::translate('Alamat', $locale, 'id') }}</label>
                    <textarea name="address" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label>{{ Translator::translate('Kota', $locale, 'id') }}</label>
                    <input type="text" name="shipping_city" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>{{ Translator::translate('Kode Pos', $locale, 'id') }}</label>
                    <input type="text" name="shipping_postalcode" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>{{ Translator::translate('No. Telepon', $locale, 'id') }}</label>
                    <input type="text" name="shipping_phonenumber" class="form-control" required>
                </div>
            </div>

            <div class="col-md-6" style="margin-top: 3em">
                <h5>{{ Translator::translate('Ringkasan Pembayaran', $locale, 'id') }}</h5>
                <p>{{ Translator::translate('Total Harga', $locale, 'id') }}: <strong>Rp {{ number_format($totalPrice, 0, ',', '.') }}</strong></p>

                @if($discount > 0)
                    <p>{{ Translator::translate('Diskon Kupon', $locale, 'id') }}: <strong>- Rp {{ number_format($discount, 0, ',', '.') }}</strong></p>
                    <p><strong>{{ Translator::translate('Total Bayar', $locale, 'id') }}: Rp {{ number_format($finalPrice, 0, ',', '.') }}</strong></p>
                    <div class="mb-3">
                        <label>{{ Translator::translate('Kupon Digunakan', $locale, 'id') }}</label>
                        <input type="text" class="form-control" value="{{ $couponCode }}" disabled>
                    </div>
                @endif

                <button type="submit" class="btn-sm btn-success w-100">{{ Translator::translate('Buat Pesanan', $locale, 'id') }}</button>
            </div>
        </div>
    </form>
</div>
@endsection
