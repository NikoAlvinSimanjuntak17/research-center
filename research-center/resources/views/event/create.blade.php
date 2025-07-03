@extends('layout.backend.main', ['activePage' => 'event.create', 'titlePage' => __('Create Event')])

@section('content')
<div class="container mt-5">
    <h2>Tambah Event</h2>

    <form method="POST" action="{{ route('event.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Nama Event</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $event->name ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="date" class="form-control" value="{{ old('date', $event->date ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Jam</label>
            <input type="time" name="time" class="form-control" value="{{ old('time', $event->time ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Kapasitas Orang</label>
            <input type="number" name="people" class="form-control" value="{{ old('people', $event->people ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="price" class="form-control" value="{{ old('price', $event->price ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Jenis Event</label>
            <select name="event_type" class="form-control" required>
                <option value="workshop" {{ old('event_type', $event->event_type ?? '') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                <option value="seminar" {{ old('event_type', $event->event_type ?? '') == 'seminar' ? 'selected' : '' }}>Seminar</option>
                <option value="conference" {{ old('event_type', $event->event_type ?? '') == 'conference' ? 'selected' : '' }}>Conference</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Gambar</label>
            <input type="file" name="image" class="form-control">
            @if (!empty($event->image))
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image" style="max-height: 150px;">
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $event->description ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Registrasi Dibuka</label>
            <input type="date" name="registration_start_date" class="form-control" value="{{ old('registration_start_date', $event->registration_start_date ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label>Registrasi Ditutup</label>
            <input type="date" name="registration_end_date" class="form-control" value="{{ old('registration_end_date', $event->registration_end_date ?? '') }}" required>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-success">SIMPAN DATA</button>
            <a href="{{ route('event.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection
