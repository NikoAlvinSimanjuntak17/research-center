@extends('layout.backend.main', ['activePage' => 'coupons.create', 'titlePage' => __('Coupon News')])

@section('title', 'Tambah Kupon')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Tambah Kupon</h4>

    <form action="{{ route('coupon.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Kode Kupon</label>
            <input type="text" name="code" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Jenis Kupon</label>
            <select name="type" class="form-control" required>
                <option value="fixed">Tetap (Rp)</option>
                <option value="percent">Persentase (%)</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Nilai</label>
            <input type="number" step="0.01" name="value" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Kadaluarsa</label>
            <input type="datetime-local" name="expired_at" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('coupon.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
