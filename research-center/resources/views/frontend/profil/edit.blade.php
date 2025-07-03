@extends('layout.frontend.main', ['activePage' => 'index', 'titlePage' => __('Edit Profil')])
@section('title', 'Edit Profil')

@section('content')
<section id="subheader" class="relative jarallax text-light">
    <img src="{{ asset('images/background/2.webp') }}" class="jarallax-img" alt="">
    <div class="container relative z-index-1000">
        <div class="row">
            <div class="col-lg-6">
                <ul class="crumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">Profil</li>
                </ul>
                <h1 class="text-uppercase">Edit Profil</h1>
                <p class="col-lg-10 lead">Perbarui informasi akun Anda</p>
            </div>
        </div>
    </div>
    <img src="{{ asset('images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
    <div class="de-gradient-edge-top dark"></div>
    <div class="de-overlay"></div>
</section>

<section class="py-5">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                {{-- FOTO --}}
                <div class="col-md-3 text-center mb-3">
                    @if($user->user_img)
                        <img src="{{ asset('storage/' . $user->user_img) }}" class="img-fluid rounded" style="max-height: 200px;" alt="Foto Profil">
                    @else
                        <img src="{{ asset('default/user.png') }}" class="img-fluid rounded" style="max-height: 200px;" alt="Default">
                    @endif
                    <div class="mt-2">
                        <input type="file" name="user_img" class="form-control @error('user_img') is-invalid @enderror">
                        @error('user_img') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- FORM --}}
                <div class="col-md-9">
                    <div class="form-group mt-3">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label>No. Telepon</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $user->phone) }}">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label>Alamat</label>
                        <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                               value="{{ old('address', $user->address) }}">
                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mt-4">
                        <button type="submit" class="btn-main">Simpan Perubahan</button>
                        <a href="{{ route('user.profile.show') }}" class="btn btn-secondary ms-2">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
