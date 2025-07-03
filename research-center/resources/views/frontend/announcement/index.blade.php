<?php
use Carbon\Carbon;
?>
@extends('layout.frontend.main', ['activePage' => 'index', 'titlePage' => __('View Berita')])
@section('title','View Berita')
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css"> --}}

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
    <!-- blog area -->
    <div class="blog-area py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="site-heading text-center">
                        <h2 class="site-title">Pengumuman</span></h2>
                        <p>Lihat semua pengumuman mengenai STT HKBP Pematangsiantar</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered" id="data-index" style="width:100%">
                        <thead>
                            <tr>
                               
                                <td style="font-weight: bold;"><h4>Judul Berita</h4></td>
                                <td style="font-weight: bold;"><h4>Tanggal Publish</h4></td>
                                <td style="font-weight: bold;"><h4>Aksi</h4></td>
                            </tr>
                        </thead>
                    </table>
                    
                    <div class="blog-top-meta">
                        <ul>
                            {{-- <li><i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::now()->format('F d, Y') }}</li> --}}
                            <li><i class="far fa-user-circle"></i> Admin Web STT HKBP Pematangsiantar</li>
                        </ul>
                    </div>

                </div>
            </div>
           
        </div>
    </div>
    <!-- blog area end -->
    <script type="text/javascript">
        $('#data-index thead tr:eq(0) td').each( function (index) {
            var col1 = [0];
            if(col1.includes(index)){
                var title = $(this).text();
                $(this).html( title+'<br><input type="text" id="nama" name="nama" style="width:100%;" class="form-control form-control-sm" placeholder="Cari.." />' );
            }

        } );

        var table = $('#data-index').DataTable( {
            iDisplayLength: 20,
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
                url: '{{ url("announcement/data-index") }}',
            },

            columns: [
                
                    {data: 'title', name: 'title',className: 'text-left'},
                    // {data: 'updated_at', name: 'updated_at',className: 'text-left'},
                    {data: 'updated_at', name: 'updated_at',className: 'text-center',
                        render: function(data, type, row, meta){
                            const date = new Date(row.updated_at.replace(' ', 'T')); // Ensures correct parsing
                            const options = { day: '2-digit', month: 'short', year: 'numeric' };
                            const formatted = date.toLocaleDateString('en-GB', options);

                            return formatted;
                        }
                    },
                    {data: 'id', name: 'id',className: 'text-center',
                        render: function(data, type, row, meta){
                            if(type === 'display'){
                                
                                data = '<a href="{{ url("frontend-announcement/view") }}/' + row.id + '" class="btn btn-block theme-btn" data-bs-popup="tooltip" title="Edit Admisi" data-bs-placement="right">'+'Lihat'+'</a>';
                                
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