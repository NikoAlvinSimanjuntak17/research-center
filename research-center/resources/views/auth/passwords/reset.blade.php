@extends('layout.frontend.main')

@section('content')

<section id="subheader" class="relative jarallax text-light">
    @php
        use Illuminate\Support\Facades\DB;
        $slider = DB::table('sliders')->where('active', 1)->orderBy('updated_at', 'desc')->first();
    @endphp
    <img src="{{ asset('storage/sliders/' . $slider->image) }}" class="jarallax-img" alt="">
    <div class="container relative z-index-1000">
        <div class="row">
            <div class="col-lg-6">
                <ul class="crumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">Reset Password</li>
                </ul>
                <h1 class="text-uppercase">Reset Password</h1>
                <p class="col-lg-10 lead">Silakan atur ulang kata sandi akun Anda.</p>
            </div>
        </div>
    </div>
    <img src="{{ asset('images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
    <div class="de-gradient-edge-top dark"></div>
    <div class="de-overlay"></div>
</section>

<section class="no-top no-bottom" style="margin-top: 8em">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card shadow border-0 rounded-4" style="min-height: 520px;">
                    <div class="card-body p-4 d-flex flex-column justify-content-center">
                        <h4 class="text-center mb-4">Atur Ulang Kata Sandi</h4>

                        @if(session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $email }}">

                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn-primary" style="height: 50px">Simpan Password</button>
                            </div>

                            <div class="text-center mt-4">
                                <a href="{{ route('login') }}">Kembali ke Login</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
