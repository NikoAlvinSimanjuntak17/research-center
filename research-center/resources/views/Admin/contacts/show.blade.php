@extends('admin.layouts.app')
@section('title', 'Detail Kontak')

@section('content')
    <h2 class="mb-4">Detail Kontak</h2>

    <div class="card">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Key</dt>
                <dd class="col-sm-9">{{ $contact->key }}</dd>

                <dt class="col-sm-3">Judul</dt>
                <dd class="col-sm-9">{{ $contact->title }}</dd>

                <dt class="col-sm-3">Isi Kontak</dt>
                <dd class="col-sm-9">{{ $contact->value ?? '-' }}</dd>

                <dt class="col-sm-3">Gambar</dt>
                <dd class="col-sm-9">
                    @if ($contact->image)
                        <img src="{{ asset('storage/' . $contact->image) }}" alt="Gambar" style="max-width: 200px;">
                    @else
                        <span class="text-muted">Tidak ada gambar</span>
                    @endif
                </dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">
                    @if ($contact->active)
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-secondary">Nonaktif</span>
                    @endif
                </dd>

                <dt class="col-sm-3">Dibuat Pada</dt>
                <dd class="col-sm-9">{{ $contact->created_at?->format('d M Y H:i') }}</dd>

                <dt class="col-sm-3">Diperbarui Pada</dt>
                <dd class="col-sm-9">{{ $contact->updated_at?->format('d M Y H:i') }}</dd>
            </dl>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">Kembali</a>
                <a href="{{ route('admin.contacts.edit', $contact->id) }}" class="btn btn-warning">Edit Kontak</a>
            </div>
        </div>
    </div>
@endsection
