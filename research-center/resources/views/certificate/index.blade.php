@extends('layout.backend.main', ['activePage' => 'event.index', 'titlePage' => __('Index Event')])

@section('content')
<div class="container mt-4">
    <h3>Peserta Event yang Sudah Verifikasi</h3>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Event</th>
                <th>Peserta</th>
                <th>Email</th>
                <th>Sertifikat</th>
                <th>Upload Sertifikat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $reg)
                <tr>
                    <td>{{ $reg->event->name }}</td>
                    <td>{{ $reg->order->nama ?? $reg->user->name }}</td>
                    <td>{{ $reg->user->email }}</td>
                    <td>
                        @if($reg->certificate)
                            <a href="{{ asset( $reg->certificate->certificate_link) }}" target="_blank">Lihat Sertifikat</a>
                        @else
                            Belum ada
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('event.uploadCertificate', $reg->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group">
                                <input type="file" name="certificate" class="form-control" required>
                                <button class="btn btn-success btn-sm">Upload</button>
                            </div>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Tidak ada peserta terverifikasi.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection