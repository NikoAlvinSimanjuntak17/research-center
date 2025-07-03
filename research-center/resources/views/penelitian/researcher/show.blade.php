@extends('layout.backend.main', ['activePage' => 'researcher.show', 'titlePage' => __('Detail Peneliti')])
@section('title','Detail Peneliti')
@section('content')
<div class="row">
    <div class="col-xl-8 offset-xl-2">
        <div class="card">
            <div class="card-body">

                <center>
                    <h4 class="card-title">DETAIL DATA PENELITI</h4>
                </center>

                <p align="left">
                    <a href="{{ route('researcher.index') }}" class="btn btn-outline-primary rounded-pill btn-sm">
                        <i class="ph-skip-back me-2"></i> Kembali ke daftar
                    </a>
                </p>

                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 30%">Nama Lengkap</th>
                            <td>: {{ $researcher->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>: {{ $researcher->email }}</td>
                        </tr>
                        <tr>
                            <th>Akun Login</th>
                            <td>: {{ $researcher->user->email }}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>: 
                                @if ($researcher->user->roles->count())
                                    {{ implode(', ', $researcher->user->roles->pluck('display_name')->toArray()) }}
                                @else
                                    <span class="text-muted"><i>Tidak ada role</i></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat Pada</th>
                            <td>: {{ $researcher->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Diperbarui Pada</th>
                            <td>: {{ $researcher->updated_at->format('d M Y, H:i') }}</td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
