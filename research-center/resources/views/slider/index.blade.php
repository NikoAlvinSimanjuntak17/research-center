@extends('layout.backend.main', ['activePage' => 'slider.index', 'titlePage' => __('Index Slider')])
@section('title','Index Slider')

{{-- Styles & Scripts --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

@section('content')
@if (session()->has('success'))
    <div class="alert alert-success alert-icon-start alert-dismissible fade show">
        <span class="alert-icon bg-success text-white">
            <i class="ph-check-circle"></i>
        </span>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-xxl-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">DATA SLIDER</h5>
            </div>

            <div class="card-body">
                <p align="right">
                    <a href="{{ route('slider.create') }}" class="btn btn-primary">
                        <i class="ph-plus-circle me-2"></i> Tambah Slider
                    </a>
                </p>
                <table class="table table-bordered" id="slider-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(function () {
    $('#slider-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('slider.data-index') }}",
        columns: [
            {
                data: 'id', name: 'id',
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'image', name: 'image', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'active', name: 'active' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
@endsection
