@extends('layout.backend.main', ['activePage' => 'event.index', 'titlePage' => __('Index Event')])

@section('content')
<div class="container mt-5">
    <h2>Daftar Event</h2>
    <a href="{{ route('event.create') }}" class="btn btn-primary mb-3">+ Tambah Event</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Token</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($events as $event)
                @php
                    $today = \Carbon\Carbon::today();
                    $eventDate = \Carbon\Carbon::parse($event->date);

                    if ($eventDate->isFuture()) {
                        $status = 'scheduled';
                        $badge = 'warning';
                        $label = 'Terjadwal';
                    } elseif ($eventDate->isSameDay($today)) {
                        $status = 'ongoing';
                        $badge = 'info';
                        $label = 'Sedang berlangsung';
                    } else {
                        $status = 'done';
                        $badge = 'success';
                        $label = 'Selesai';
                    }
                @endphp
                <tr>
                    <td>{{ $event->name }}</td>
                    <td>{{ $eventDate->translatedFormat('d M Y') }}</td>
                    <td>{{ ucfirst($event->event_type) }}</td>
                    <td>{{ $event->attendance_token }}</td>
                    <td>{{ $event->price > 0 ? 'Rp ' . number_format($event->price) : 'Gratis' }}</td>
                    <td>
                        <span class="badge bg-{{ $badge }}">{{ $label }}</span>
                    </td>
                    <td>
                        <a href="{{ route('event.edit', $event->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form method="POST" action="{{ route('event.destroy', $event->id) }}" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus event ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
