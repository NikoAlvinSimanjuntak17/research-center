@php
    use App\Helpers\Translator;
    $locale = app()->getLocale();
@endphp
@extends('layout.frontend.main', ['activePage' => 'checkout', 'titlePage' => __('Pembayaran')])
@section('title', 'Pembayaran')

@section('content')
<div class="container my-5 text-center">
    <h3 style="margin-top: 3em;">{{ Translator::translate('Memproses Pembayaran Anda...', $locale, 'id') }}</h3>
    <p>{{ Translator::translate('Mohon tunggu, Anda akan diarahkan ke halaman pembayaran.', $locale, 'id') }}</p>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    window.onload = function() {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href = '{{ $redirectUrl }}';
            },
            onPending: function(result) {
                window.location.href = '{{ $redirectUrl }}';
            },
            onError: function(result) {
                alert("Pembayaran gagal. Silakan coba lagi.");
                window.location.href = '{{ $redirectUrl }}';
            },
            onClose: function() {
                window.location.href = '{{ $redirectUrl }}';
            }
        });
    };
</script>
@endsection
