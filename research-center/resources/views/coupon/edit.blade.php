@extends('layout.backend.main', ['activePage' => 'coupons.edit', 'titlePage' => __('Coupon News')])

@section('title', 'Edit Kupon')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Edit Kupon</h4>

    <form action="{{ route('coupon.update', $model->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Kode Kupon</label>
            <input type="text" name="code" class="form-control" value="{{ $model->code }}" required>
        </div>
        <div class="mb-3">
            <label>Jenis Kupon</label>
            <select name="type" class="form-control" required>
                <option value="fixed" {{ $model->type == 'fixed' ? 'selected' : '' }}>Tetap (Rp)</option>
                <option value="percent" {{ $model->type == 'percent' ? 'selected' : '' }}>Persentase (%)</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Nilai</label>
            <input type="number" step="0.01" name="value" class="form-control" value="{{ $model->value }}" required>
        </div>
        <div class="mb-3">
            <label>Tanggal Kadaluarsa</label>
            <input type="datetime-local" name="expired_at" class="form-control" 
                   value="{{ $model->expired_at ? \Carbon\Carbon::parse($model->expired_at)->format('Y-m-d\TH:i') : '' }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('coupon.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
