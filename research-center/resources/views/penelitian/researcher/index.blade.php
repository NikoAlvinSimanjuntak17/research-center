@extends('layout.backend.main', ['activePage' => 'researcher.index', 'titlePage' => __('Index Researcher')])
@section('title','Index Researcher')

{{-- Styles dan Scripts --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

@section('content')

{{-- Alert --}}
@if (session()->has('success'))
    <div class="alert alert-success alert-icon-start alert-dismissible fade show">
        <span class="alert-icon bg-success text-white">
            <i class="ph-check-circle"></i>
        </span>
        {{ session()->get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@elseif (session()->has('danger'))
    <div class="alert alert-danger alert-icon-start alert-dismissible fade show">
        <span class="alert-icon bg-danger text-white">
            <i class="ph-x-circle"></i>
        </span>
        {{ session()->get('danger') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Content -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">DATA PENELITI</h5>
            </div>
            <div class="card-body">
                <p class="text-end">
                    <a href="{{ route('researcher.create') }}" class="btn btn-primary">
                        <i class="ph-plus-circle me-2"></i> Tambah Peneliti
                    </a>
                </p>

                <table class="table table-bordered" id="data-index" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Script DataTable --}}
<script type="text/javascript">
    var table = $('#data-index').DataTable({
        iDisplayLength: 50,
        bStateSave: false,
        lengthChange: false,
        ordering: false,
        info: false,
        dom: 'lifrtpi',
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("researcher.data-index") }}',
        },
        columns: [
            {
                data: 'id',
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'name', name: 'name', className: 'text-left' },
            { data: 'email', name: 'email', className: 'text-left' },
            {
                data: 'id',
                name: 'id',
                className: 'text-center',
                render: function (data, type, row, meta) {
                    if (type === 'display') {
                        let btn = '';
                        btn += `<a href="{{ url('admin/researcher/edit') }}/${row.id}" class="btn btn-outline-success rounded-pill btn-sm" title="Edit"><i class="ph-pencil me-2"></i> Edit</a> `;
                        btn += `<a href="{{ url('admin/researcher/show') }}/${row.id}" class="btn btn-outline-primary btn-icon btn-sm" title="Lihat"><i class="ph-eye"></i></a> `;
                        btn += `<a href="{{ url('admin/researcher/destroy') }}/${row.id}" class="btn btn-outline-danger btn-icon btn-sm" onclick="return confirm('Apakah kamu yakin ingin menghapus peneliti ini?')" title="Hapus"><i class="ph-trash"></i></a>`;
                        return btn;
                    }
                    return data;
                }
            },
        ]
    });
</script>

@endsection
