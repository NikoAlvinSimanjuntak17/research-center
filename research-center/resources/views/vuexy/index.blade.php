@extends('vuexy.layouts.main', ['activePage' => 'register', 'titlePage' => __('REGISTER')])
@section('title','REGISTER')

@section('content')
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible d-flex align-items-baseline" role="alert">
            <span class="alert-icon alert-icon-lg text-success me-2">
              <i class="ti ti-check ti-sm"></i>
            </span>
            <div class="d-flex flex-column ps-1">
                <h5 class="alert-heading mb-2">{{session()->get('success')}}</h5>
                <p class="mb-0">
                    Data Pendaftaran Anda Telah Masuk Ke Sistem Kami, Anda Akan dihubungi oleh pihak Prosus Inten untuk proses selanjutnya
                </p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @elseif (session()->has('danger'))
        <div class="alert alert-danger alert-dismissible d-flex align-items-baseline" role="alert">
            <span class="alert-icon alert-icon-lg text-danger me-2">
              <i class="ti ti-check ti-sm"></i>
            </span>
            <div class="d-flex flex-column ps-1">
                <h5 class="alert-heading mb-2">{{session()->get('danger')}}</h5>
                <p class="mb-0">
                    Data Pendaftaran Anda Gagal, Cek Kembali Semua Data
                </p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-xs-12">
            <img
                src="../../assets/img/illustrations/auth-register-illustration-light.png"
                alt="auth-register-cover"
                class="img-fluid my-5 auth-illustration"
                data-app-light-img="illustrations/auth-register-illustration-light.png"
                data-app-dark-img="illustrations/auth-register-illustration-dark.png"
            />
        </div>
        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <!-- /Logo -->
                    <h3 class="mb-1 fw-bold">DAFTAR BERSAMA PROSUS INTEN</h3>
                    <p class="mb-4">Belajar Sesuai Cara Kerja Otak</p>

                    <form id="formPendaftaran" class="mb-3" action="{{route('pendaftaran.create')}}" method="POST">
                        {{csrf_field()}}
                        <div class="mb-3">
                            <label for="id_pembelajaran" name="id_pembelajaran" class="form-label">Jenis Pembelajaran</label>
                            <select id="id_pembelajaran" name="id_pembelajaran" class="selectpicker w-100" data-style="btn-default">
                                <option value="1">PEMBELAJARAN REALTIME ONLINE</option>
                                <option value="2">PEMBELAJARAN TATAP MUKA (PTM)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input
                                type="text"
                                class="form-control"
                                id="nama_lengkap"
                                name="nama_lengkap"
                                placeholder="Masukkan Nama Lengkap Anda"
                                autofocus
                            />
                        </div>
                        <div class="mb-3">
                            <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
                            <input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah" placeholder="Masukkan Asal Sekolah Anda" />
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">Nomor Handphone (WA)</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan Nomor Handphone / WA Aktif" />
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Masukkan email anda" />
                        </div>
                        <div class="mb-3">
                            <label for="id_kelas" class="form-label">Kelas</label>
                            <select id="id_kelas" name="id_kelas" class="selectpicker w-100" data-style="btn-default">
                                <option value="5">SUPER INTENSIF</option>
                                <option value="1">XII IPA</option>
                                <option value="2">XII IPS</option>
                                <option value="3">ALUMNI IPA (GAP YEAR)</option>
                                <option value="4">ALUMNI IPS (GAP YEAR)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="kode_kota" class="form-label">KOTA</label>
                            <select id="kode_kota" name="kode_kota" class="selectpicker w-100" data-style="btn-default">
                                <option value="JKT">JAKARTA</option>
                                <option value="BDO">BANDUNG</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="kode_cabang" class="form-label">CABANG</label>
                            <select id="kode_cabang" name="kode_cabang" class="selectpicker w-100" data-style="btn-default">
                                <option value="JKT015">KALIMALANG</option>
                                <option value="JKT100">PROSUS INTEN PIRTONDI</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg d-grid w-100">DAFTARKAN</button>
                    </form>

                </div>
            </div>
        </div>

    </div>
@endsection
