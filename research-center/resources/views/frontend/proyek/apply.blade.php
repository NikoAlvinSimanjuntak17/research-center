@extends('layout.frontend.main', ['activePage' => 'index', 'titlePage' => __('Daftar Kolaborator')])
@section('title', 'Daftar Sebagai Kolaborator')

@section('content')
    <section id="subheader" class="relative jarallax text-light">
        @php
        use Illuminate\Support\Facades\DB;
        $slider = DB::table('sliders')
        ->where('active', 1)
        ->orderBy('updated_at', 'desc')
        ->first(); // ganti get() dengan first()

        @endphp
        <img src="{{ asset(asset('storage/sliders/' . $slider->image)) }}" class="jarallax-img" alt="">
        <div class="container relative z-index-1000">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="crumb">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li class="active">Proyek</li>
                    </ul>
                    <h1 class="text-uppercase">Proyek</h1>
                    <p class="col-lg-10 lead">Temukan berbagai Proyek penelitian kami yang inovasi dan terpecaya.</p>
                </div>
            </div>
        </div>
        <img src="{{ asset('images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
        <div class="de-gradient-edge-top dark"></div>
        <div class="de-overlay"></div>
    </section>

<section>
    <div class="container">
        <div class="row g-5 mt-5">

            <!-- Kiri: Info proyek -->
            <div class="col-lg-5">
                <div class="p-4 bg-light rounded-2 h-100">
                    <h5 class="text-uppercase mb-4">Tentang Proyek</h5>
                    <p>{{ $project->title }}</p>

                    <div class="spacer-20"></div>

                    <div class="fw-bold text-dark"><i class="icofont-calendar me-2 id-color-2"></i>Dibuka</div>
                    {{ $project->open_at->format('d M Y') }}

                    <div class="spacer-20"></div>

                    <div class="fw-bold text-dark"><i class="icofont-calendar me-2 id-color-2"></i>Ditutup</div>
                    {{ $project->close_at->format('d M Y') }}

                    <div class="spacer-20"></div>

                    <div class="fw-bold text-dark"><i class="icofont-user me-2 id-color-2"></i>Penanggung Jawab</div>
                    {{ $project->creator->name ?? 'Tidak diketahui' }}
                </div>
            </div>

            <!-- Kanan: Formulir -->
            <div class="col-lg-7">
                <h3 class="mb-4">Formulir Pendaftaran Kolaborator</h3>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('frontend-project.apply.store', $project->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="position" class="form-label">Posisi <span class="text-danger">*</span></label>
                        <input type="text" name="position" id="position" class="form-control @error('position') is-invalid @enderror" placeholder="Mahasiswa" value="{{ old('position') }}" required>
                        @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="institution" class="form-label">Institusi</label>
                        <input type="text" name="institution" id="institution" class="form-control @error('institution') is-invalid @enderror" placeholder="Institut Teknologi Del" value="{{ old('institution') }}">
                        @error('institution') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="department" class="form-label">Departemen/Jurusan</label>
                        <input type="text" name="department" id="department" class="form-control @error('department') is-invalid @enderror" placeholder="D3 Teknologi Informasi" value="{{ old('department') }}">
                        @error('department') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="expertise" class="form-label">Keahlian</label>
                        <input type="text" name="expertise" id="expertise" class="form-control @error('expertise') is-invalid @enderror" placeholder="Machine Learning" value="{{ old('expertise') }}">
                        @error('expertise') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cv" class="form-label">Upload CV (PDF, max 2MB)</label>
                        <input type="file" name="cv" id="cv" accept="application/pdf" class="form-control @error('cv') is-invalid @enderror">
                        @error('cv') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="reason" class="form-label">Alasan Bergabung</label>
                        <textarea name="reason" id="reason" rows="4" class="form-control @error('reason') is-invalid @enderror" placeholder="Tulis alasan kamu tertarik bergabung...">{{ old('reason') }}</textarea>
                        @error('reason') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn-main">Kirim Pendaftaran</button>
                        <a href="{{ route('frontend-project.show', $project->id) }}" class="btn btn-secondary ms-2">Batal</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
@endsection