@include('layouts.header')

<section class="page-header">
    <div class="page-header__bg" style="background-image: url('{{ asset('images/bg.jpg') }}');"></div>
    <!-- /.page-header__bg -->
    <div class="container">
        <div class="page-header__inner">
            <h2 class="page-header__title">Form Pendaftaran Proyek</h2>
            <ul class="list-unstyled thm-breadcrumb">
                <li><a href="{{ route('projects.index') }}">Beranda</a></li>
                <li><span>Form Pendaftaran Kolaborator</span></li>
            </ul>
        </div>
    </div>
</section>

<section class="checkout-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="checkout-page__billing-address">
                    <h2 class="checkout-page__billing-address__title">Formulir Pendaftaran Kolaborator</h2>
                    <form class="checkout-page__form" action="{{ route('collaborator.store', $project->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row bs-gutter-x-20">
                            <div class="col-xl-12">
                                <div class="checkout-page__input-box">
                                    <label for="position">Jabatan<span class="text-danger">*</span></label>
                                    <input type="text" name="position" id="position" placeholder="Contoh: Dosen/Mahasiswa" required>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="checkout-page__input-box">
                                    <label for="institution">Institusi / Universitas</label>
                                    <input type="text" name="institution" id="institution" placeholder="Contoh: Universitas Gadjah Mada">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="checkout-page__input-box">
                                    <label for="department">Fakultas / Departemen</label>
                                    <input type="text" name="department" id="department" placeholder="Contoh: Fakultas Teknik / Departemen Informatika">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="checkout-page__input-box">
                                    <label for="expertise">Bidang Keahlian</label>
                                    <input type="text" name="expertise" id="expertise" placeholder="Contoh: Artificial Intelligence, Data Mining">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="checkout-page__input-box">
                                    <label for="reason">Alasan Bergabung</label>
                                    <textarea name="reason" id="reason" rows="4" placeholder="Tuliskan alasan Anda ingin bergabung dalam proyek ini..."></textarea>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="checkout-page__input-box">
                                    <label for="cv">Upload CV (PDF, maks 2MB)</label>
                                    <input type="file" name="cv" id="cv" accept=".pdf">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="checkout-page__input-box text-end">
                                    <button type="submit" class="laboix-btn">Kirim Pendaftaran</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@include('layouts.footer')
