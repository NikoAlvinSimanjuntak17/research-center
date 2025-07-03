@extends('layout.backend.main', ['activePage' => 'study-centre.index', 'titlePage' => __('Index Pusat Studi')])
@section('title','Index Pusat Studi')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<style type="text/css">
    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
        visibility: hidden;
    }
</style>

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success alert-icon-start alert-dismissible fade show">
            <span class="alert-icon bg-success text-white">
                <i class="ph-check-circle"></i>
            </span>
            {{session()->get('success')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

    @elseif (session()->has('danger'))
        <div class="alert alert-danger alert-icon-start alert-dismissible fade show">
            <span class="alert-icon bg-danger text-white">
                <i class="ph-x-circle"></i>
            </span>
            {{session()->get('success')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

    @endif

<!-- Content area -->
    <div class="row">
        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">DATA PUSAT STUDI</h5>
                </div>

                <div class="card-body">
                    <p align="right">
                        <a href="{{route('study-centre.create')}}" class="btn btn-primary"><i class="ph-plus-circle me-2"></i> Tambah Pusat Studi</a>
                    </p>
                    <table class="table table-bordered" id="data-index" style="width:100%">
                        <thead>
                            <tr>
                                <td style="font-weight: bold;">No</td>
                                <td style="font-weight: bold;">Nama Pusat Studi</td>
                                <td style="font-weight: bold;">Aksi</td>
                            </tr>
                        </thead>
                    </table>
                </div>

                
            </div>

            
        </div>
    </div>
<!-- /content area -->

<script type="text/javascript">
        $('#data-index thead tr:eq(0) td').each( function (index) {
            var col1 = [1];
            if(col1.includes(index)){
                var title = $(this).text();
                $(this).html( title+'<br><input type="text" id="nama" name="nama" style="width:100%;" class="form-control form-control-sm" placeholder="Cari.." />' );
            }

        } );

        var table = $('#data-index').DataTable( {
            iDisplayLength: 50,
            bStateSave: false,
            lengthChange: false,
            ordering: false,
            info:     false,
            // order:  [[2, "desc" ]],
            // orderCellsTop: true,
            // fixedHeader: true,
            dom: 'lifrtpi',
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url("study-centre/data-index") }}',
            },

            columns: [
                {
                        "data": 'id',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {data: 'title', name: 'title',className: 'text-left'},
                    {data: 'id', name: 'id',className: 'text-center',
                        render: function(data, type, row, meta){
                            if(type === 'display'){
                                
                                data = '<a href="{{ url("study-centre/edit") }}/' + row.id + '" class="btn btn-outline-success rounded-pill btn-sm" data-bs-popup="tooltip" title="Edit Admisi" data-bs-placement="right">'+'<i class="ph-pencil"></i>'+'</a>';
                                data += '&nbsp;';
                                data += '<a href="{{ url("frontend-study-centre/view") }}/' + row.id + '" class="btn btn-outline-primary btn-icon btn-sm" target="_blank" data-bs-popup="tooltip" title="Lihat Detail Admisi" data-bs-placement="right">'+'<i class="ph-eye"></i>'+'</a>';
                                data += '&nbsp;';
                                data += '<a href="{{ url("study-centre/destroy") }}/' + row.id + '" class="btn btn-outline-danger btn-icon btn-sm" onclick="return confirm(\'Apakah anda yakin ingin menghapus data ini?\')" data-bs-popup="tooltip" title="Hapus Admisi" data-bs-placement="right">'+'<i class="ph-trash"></i>'+'</a>';
                            }

                            return data;
                        }
                    },
            ],

            /*columnDefs: [
                {
                    targets: 7,
                    render: $.fn.dataTable.render.number(',', '.', 0, '')
                }
            ],*/

            initComplete: function (index) {
                // Apply the search
                this.api().columns().every( function () {
                    var that = this;

                    $( 'input', this.header() ).on( 'keyup change clear', function () {
                        if ( that.search() !== this.value ) {
                            that
                                .search( this.value )
                                .draw();
                        }
                    } );

                } );
            },
        });

    </script>

@endsection
