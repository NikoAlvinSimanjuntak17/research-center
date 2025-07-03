@extends('layout.backend.main', ['activePage' => 'coupons.index', 'titlePage' => __('Coupon News')])

@section('title', 'Indeks Kupon')

@section('content')
<div class="container-fluid">
    <h4 class="mb-4">Manajemen Kupon</h4>
    <a href="{{ route('coupon.create') }}" class="btn btn-primary mb-3">+ Tambah Kupon</a>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="couponTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Jenis</th>
                        <th>Nilai</th>
                        <th>Kadaluarsa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('#couponTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('coupon.dataIndex') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'code', name: 'code' },
                { data: 'type', name: 'type' },
                { data: 'value', name: 'value' },
                { data: 'expired_at', name: 'expired_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endpush
