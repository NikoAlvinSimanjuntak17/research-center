@extends('layout.backend.main', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('title', 'Profil Saya')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Profil Saya</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                {{-- FOTO PROFIL --}}
                <div class="col-md-3 text-center mb-3">
                    @if($user->user_img)
                        <img src="{{ asset('storage/' . $user->user_img) }}" alt="Foto Profil" class="img-fluid rounded" style="max-height: 200px;">
                    @else
                        <img src="{{ asset('default/user.png') }}" alt="Default" class="img-fluid rounded" style="max-height: 200px;">
                    @endif
                </div>

                {{-- DETAIL INFORMASI --}}
                <div class="col-md-9">
                    <table class="table table-borderless">
                        <tr>
                            <th>Nama</th>
                            <td>{{ $user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Telepon</th>
                            <td>{{ $user->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $user->address ?? '-' }}</td>
                        </tr>
                    </table>

                    <a href="{{ route('admin.profile.edit') }}" class="btn btn-warning mt-3">Edit Profil</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
