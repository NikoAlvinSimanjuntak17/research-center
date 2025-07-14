<x-mail::message>
{{-- Salam --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# Oops!
@else
# Halo!
@endif
@endif

{{-- Kalimat Pembuka --}}
@foreach ($introLines as $line)
{{ str_replace(
    ['You are receiving this email because we received a password reset request for your account.'],
    ['Akun Anda telah didaftarkan oleh admin dan sistem telah mengatur kata sandi sementara secara otomatis.'],
    $line
) }}

@endforeach

{{-- Tambahan Pesan Wajib Reset --}}
> **Untuk dapat login ke sistem, Anda wajib mengatur ulang kata sandi terlebih dahulu.**

{{-- Tombol Aksi --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color">
{{ str_replace('Reset Password', 'Atur Ulang Kata Sandi', $actionText) }}
</x-mail::button>
@endisset

{{-- Kalimat Penutup --}}
@foreach ($outroLines as $line)
{{ str_replace(
    [
        'If you did not request a password reset, no further action is required.',
    ],
    [
        'Jika Anda tidak meminta pengaturan ulang kata sandi, abaikan email ini.',
    ],
    $line
) }}

@endforeach

{{-- Penutup --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Salam hangat,<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
Jika Anda mengalami kesulitan mengklik tombol "{{ str_replace('Reset Password', 'Atur Ulang Kata Sandi', $actionText) }}", salin dan tempel URL berikut ke browser Anda:

<span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset
</x-mail::message>
