@extends('layout.app', ['activePage' => 'dashboard', 'titlePage' => __('Data User')])
@section('title','Data User')

@section('content')
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
    td.kpjsusulan {
        background-color: red;
    }
    td.kpj {
        background-color: green;
    }
</style>
@if (session()->has('success'))
    <div class="alert text-white bg-success" role="alert">
        <div class="iq-alert-text">{{session()->get('success')}}</div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>

@elseif (session()->has('danger'))
    <div class="alert text-white bg-danger" role="alert">
        <div class="iq-alert-text">{{session()->get('danger')}}</div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>

@endif

<div class="messages"></div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">

                <div class="iq-card-body">
                    <center>
                        <h4 class="card-title">DATA USER PROSUS INTEN</h4>
                    </center>
                    <p align="right">
                        <a class="btn btn-warning" onclick="return confirm('Apakah anda akan Reset Semua Password Wali Kelas?')" href="{{route('generate-reset-password', ['role' =>'WALI_KELAS'])}}"><i class="fa fa-window-restore"></i> GENERATE PASSWORD WALI KELAS</a>
                        <button type="button" class="btn cur-p btn-primary" data-toggle="modal" data-target="#modalInputUser" data-placement="top">
                            <span class="ri-user-add-line"></span>
                            TAMBAH DATA USER
                        </button>
                        <button type="button" class="btn cur-p btn-success" data-toggle="modal" data-target="#modalRoleUser" data-placement="top">
                            <span class="ri-user-shared-2-line"></span>
                            ASSIGN ROLE USER
                        </button>
                    </p>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="data_user" style="width:100%">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Inisial</th>
                                <th>Telp</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalInputUser" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title" id="modalHeaderInputKelasCabang">FORM INPUT DATA USER <b class="text-primary">PROSUS INTEN</b></h4></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="formDataUser" name="formDataUser" class="form-horizontal" method="post" action="{{route('create-new-user')}}">
                    {{csrf_field()}}
                    @method('POST')

                    <div class="form-row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="nama_user">NAMA LENGKAP</label>
                                <input type="text" class="form-control" id="nama_user" name="nama_user" placeholder="Contoh: Nomaheu Panjaitan" required="true">
                            </div>
                            <div class="form-group">
                                <label for="inisial_user">INISIAL USER</label>
                                <input type="text" class="form-control" id="inisial_user" name="inisial_user" placeholder="Contoh: NP" required="true">
                            </div>

                            <div class="form-group">
                                <label for="username">USERNAME</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="inisial.kota (Contoh: hc.jakarta)" required="true">
                            </div>

                            <div class="form-group">
                                <label for="email">EMAIL</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Contoh: hc.jakarta@inten.com" required="true">
                            </div>

                            <div class="form-group">
                                <label for="telp">NOMOR HANDPHONE</label>
                                <input type="text" class="form-control" id="telp" name="telp" placeholder="Contoh: 0852xxxxyyyy" required="true">
                            </div>

                        </div>
                    </div>


                    <div class="col-md-12 col-sm-12">
                        <center>
<!--                            <button type="submit" class="saveDataKelas btn btn-success btn-lg btn-block" id="saveDataKelas" value="create">SIMPAN DATA KELAS
                            </button>-->
                             <button type="submit" class="btn btn-primary">SIMPAN DATA USER
                            </button>
                        </center>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditUser" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title" id="modalHeaderEditUser">FORM EDIT DATA USER <b class="text-primary">PROSUS INTEN</b></h4></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="formEditDataUser" name="formEditDataUser" class="form-horizontal" method="post">
                    {{csrf_field()}}
                    @method('PUT')

                    <div class="form-row">
                        <div class="col-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="id_edit" name="id_edit" required="true" hidden="true">
                            </div>

                            <div class="form-group">
                                <label for="username">USERNAME</label>
                                <input type="text" class="form-control" id="username_edit" name="username_edit" placeholder="inisial.kota (Contoh: hc.jakarta)" required="true" readonly="true">
                            </div>

                            <div class="form-group">
                                <label for="nama_user">NAMA LENGKAP</label>
                                <input type="text" class="form-control" id="nama_user_edit" name="nama_user_edit" placeholder="Contoh: Nomaheu Panjaitan" required="true">
                            </div>
                            <div class="form-group">
                                <label for="inisial_user">INISIAL USER</label>
                                <input type="text" class="form-control" id="inisial_user_edit" name="inisial_user_edit" placeholder="Contoh: NP" required="true">
                            </div>

                            <div class="form-group">
                                <label for="email">EMAIL</label>
                                <input type="email" class="form-control" id="email_edit" name="email_edit" placeholder="Contoh: hc.jakarta@inten.com" required="true">
                            </div>

                            <div class="form-group">
                                <label for="telp">NOMOR HANDPHONE</label>
                                <input type="text" class="form-control" id="telp_edit" name="telp_edit" placeholder="Contoh: 0852xxxxyyyy" required="true">
                            </div>


                        </div>
                    </div>


                    <div class="col-md-12 col-sm-12">
                        <center>
                            <button type="submit" class="updateDataUser btn btn-success btn-lg btn-block" id="updateDataUser" value="update">UPDATE DATA USER
                            </button>
<!--                            <button type="submit" class="btn btn-primary">SIMPAN DATA USER
                            </button>-->
                        </center>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRoleUser" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title" id="modalHeaderRoleUser">FORM ASSIGN ROLE USER <b class="text-primary">PROSUS INTEN</b></h4></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="formRoleUser" name="formRoleUser" class="form-horizontal" method="post" action="{{route('create-role-user')}}">
                    {{csrf_field()}}
                    @method('POST')

                    <div class="form-row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="user_id">USER</label>
                                <select class="loadUser form-control" id="user_id" name="user_id" required="true" style="width:100%;">
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="item_name">ROLE</label>
                                <select class="form-control" id="item_name" name="item_name" required="true">
                                    <option value="">Pilih ROLE</option>
                                    <option value="WALI_KELAS">WALI_KELAS</option>
                                    <option value="KEPALA_CABANG">KEPALA_CABANG</option>
                                    <option value="WAKIL_KEPALA_CABANG">WAKIL_KEPALA_CABANG</option>
                                    <option value="SEKRETARIS">SEKRETARIS</option>
                                    <option value="SEKRETARIS_KOTA">SEKRETARIS_KOTA</option>
                                    <option value="MANAJER_AKADEMIK">MANAJER_AKADEMIK</option>
                                </select>
                            </div>

                        </div>
                    </div>


                    <div class="col-md-12 col-sm-12">
                        <center>
                            <button type="submit" class="btn btn-success">SIMPAN DATA ROLE USER
                            </button>
                        </center>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    $('#data_user thead tr:eq(0) th').each( function (index) {

        var col1 = [1,2,3,5];


        if(col1.includes(index)){
            var title = $(this).text();
            $(this).html( title+'<br><input type="text" id="nama" name="nama" style="width:100%;" class="form-control form-control-sm" placeholder="Search '+title+'" />' );
        }


    } );

    var table = $('#data_user').DataTable( {
        iDisplayLength: 50,
        bStateSave: false,
        lengthChange: false,
        ordering: false,
        info:     true,
        // order:  [[2, "desc" ]],
        // orderCellsTop: true,
        // fixedHeader: true,
        dom: 'lifrtpi',
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ url("data-user") }}',
        },

        columns: [
            {
                "data": 'id',
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },

            /*{data: 'username', name: 'username',
              render: function(data, type, row, meta){
                if(type === 'display'){
                    data = '<a href="{{ url("view-siswa") }}/' + row.username + '" target="_blank">' + data + '</a>';
                }

                return data;
              }
            },*/
            {data: 'username', name: 'username'},
            {data: 'nama_user', name: 'nama_user'},
            // {data: 'first_name', name: 'first_name'},

            {data: 'inisial_user', name: 'inisial_user'},
            {data: 'telp', name: 'telp',className: 'text-center'},
            {data: 'item_name', name: 'item_name',className: 'text-center'},
            {data: 'reset_password', name: 'reset_password'},

        ],

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

     $('body').on('click', '.reset_password', function (e){
        e.preventDefault();

        var id = $(this).data('id');

        $.ajax({
            url:'{{ url("/reset-password") }}'+'/'+id,
            method:'GET',
            dataType:'json',
            success:function(data)
            {
                alert("Password Berhasil Direset!");

            },
            error: function (data) {
                  console.log('Error:', data);
                  alert("Data Kelulusan Gagal Disimpan! Mungkin sudah ada data sebelumnya dengan jalur yang sama atau Form Tidak Lengkap Diisi");
            }
        })
    });

    $('.loadUser').select2({
        //placeholder: 'Pilih User - Wali Kelas',
        ajax: {
            url: '{{ route("load-data-user") }}',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    term: params.term
                }
            },

            processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                            text: item.username+' - '+item.inisial_user+' - '+item.nama_user,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    // Fungsi Edit dan Update Kelas Menggunakan Modal Pada Datatables
    $('body').on('click', '.edit_data', function () {
        var id = $(this).data('id_user');

        $.get('{{ url("/user/get-user") }}/'+id, function (data) {
            $('#formEditDataUser').trigger("reset");
            jQuery('#modalEditUser').modal('show');
            $('#username_edit').val(data.username);
            $('#id_edit').val(data.id);
            $('#nama_user_edit').val(data.nama_user);
            $('#inisial_user_edit').val(data.inisial_user);
            $('#email_edit').val(data.email);
            $('#telp_edit').val(data.telp);
        })
    });

    $('body').on('click', '.updateDataUser', function (e){
        e.preventDefault();
        var id_user = $('#id_edit').val();

        //var id_to = $('#id_to_saintek').val();
        $(this).html('Proses UPDATE USER..');
        $.ajax({
            data: $('#formEditDataUser').serialize(),
            url: '{{ url("user/update-user") }}/'+ id_user,
            type: "PUT",
            dataType: 'json',
            success: function (data) {
                $('#formEditDataUser').trigger("reset");
                $('#modalEditUser').modal('hide');
                var messages = $('.messages');

                var successHtml = '<div class="alert text-white bg-success" role="alert"><div class="iq-alert-text">'+data.message+'</div><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ri-close-line"></i></button></div>';

                $(messages).html(successHtml);

                table.draw();

            },
            error: function (data) {
                console.log('Error:', data);
                $('#modalEditUser').modal('hide');
                alert("Data Gagal Disimpan! Mungkin sudah ada data sebelumnya atau Form Tidak Lengkap Diisi");
            }
        });
    });
</script>

@endsection
