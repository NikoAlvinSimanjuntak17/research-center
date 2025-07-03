<?php
use Illuminate\Support\Facades\DB;
?>

@extends('layout.app', ['activePage' => 'dashboard', 'titlePage' => __('View Profil')])
@section('title','View Profil')

@section('content')
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


    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                <div class="iq-card">
                    <div class="iq-card-body">
                        <div class="row">

                            <div class="col-md-12">
                                <center><h4>DETAIL PROFIL </h4></center>
                            </div>

                            <div class="col-md-12">
                                <p align="right">
                                    <button type="button" class="btn cur-p btn-warning" data-toggle="modal" data-target="#modalEditProfil" data-placement="top">
                                        <span class="fa fa-pencil"></span>
                                        EDIT PROFIL
                                    </button>
                                    <button type="button" class="btn cur-p btn-success" data-toggle="modal" data-target="#modalUpdatePassword" data-placement="top">
                                        <span class="ri-building-4-line"></span>
                                        UPDATE PASSWORD
                                    </button>

                                </p>
                                <div class="table-responsive">
                                    <div class="table-responsive">
                                        <input type="text" class="form-control" id="id" name="id" value="{{$model->id}}" hidden="true">
                                        <table class="table table-striped" id="data_siswa_wali" style="width:100%">
                                            <tbody>
                                            <tr>
                                                <td>Nama</td>
                                                <td>:</td>
                                                <td><b class="text-primary">{{$model->nama_user}}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Inisial</td>
                                                <td>:</td>
                                                <td><b class="text-primary">{{$model->inisial_user}}</b></td>
                                            </tr>

                                            <tr>
                                                <td>Nomor HP</td>
                                                <td>:</td>
                                                <td><b class="text-primary">{{$model->telp}}</b></td>
                                            </tr>

                                            <tr>
                                                <td>Username</td>
                                                <td>:</td>
                                                <td><b class="text-primary">{{$model->username}}</b></td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td>:</td>
                                                <td><b class="text-primary">{{$model->email}}</b></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>


    <div class="modal fade bd-example-modal-md" id="modalUpdatePassword">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" align="center">
                    <center><h4>UPDATE PASSWORD</h4></center>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="content-modal-data">
                    <form class="form-horizontal" action="{{route('user.update-password',['id'=>$model->id])}}" method="post">
                        {{csrf_field()}}
                        @method('PUT')
                        <div class="form-group">
                            <label for="first_name">Password Baru</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Masukkan Password Baru" required="true">
                        </div>

                        <div class="form-group">
                            <label for="first_name">Ulangi Password Baru</label>
                            <input type="password" class="form-control" id="repeat_password" name="repeat_password" placeholder="Ulangi Masukkan Password Baru" required="true">
                        </div>
                        <div class="form-group">
                            <center>
                                <button type="submit" class="btn btn-success btn-lg">UPDATE PASSWORD</button>
                            </center>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-md" id="modalEditProfil">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" align="center">
                    <center><h4>EDIT PROFIL</h4></center>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="content-modal-data">
                    <form class="form-horizontal" action="{{route('user.update-profil',['id'=>$model->id])}}" method="post">
                        {{csrf_field()}}
                        @method('PUT')
                        <div class="form-group">
                            <label for="nama_user">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_user" name="nama_user" value="{{$model->nama_user}}" required="true">
                        </div>

                        <div class="form-group">
                            <label for="telp">Nomor HP</label>
                            <input type="text" class="form-control" id="telp" name="telp" value="{{$model->telp}}" required="true">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{$model->email}}" required="true">
                        </div>


                        <div class="form-group">
                            <center>
                                <button type="submit" class="btn btn-warning btn-lg">SIMPAN DATA</button>
                            </center>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection
