@extends('layout.frontend.main', ['activePage' => 'index', 'titlePage' => __('Profil Saya')])
@section('title', 'Profil Saya')

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
                        <li class="active">Profil</li>
                    </ul>
                    <h1 class="text-uppercase">Profil</h1>
                    <p class="col-lg-10 lead">Kelola halaman profil anda</p>
                </div>
            </div>
        </div>
        <img src="{{ asset('images/logo-wm.webp') }}" class="abs end-0 bottom-0 z-2 w-20" alt="">
        <div class="de-gradient-edge-top dark"></div>
        <div class="de-overlay"></div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        {{-- FOTO PROFIL --}}
                        <div class="col-md-3 text-center mb-3">
                            @if($user->user_img)
                                <img src="{{ asset('storage/' . $user->user_img) }}" alt="Foto Profil" class="img-fluid rounded"
                                    style="max-height: 200px;">
                            @else
                                <img src="{{ asset('default/user.png') }}" alt="Default" class="img-fluid rounded"
                                    style="max-height: 200px;">
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

                            <a href="{{ route('user.profile.edit') }}" class="btn-main">Edit Profil</a>
                        </div>
                    </div>
                </div>
            </div>


            {{-- PROYEK YANG DIIKUTI --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Proyek yang Diikuti</h5>
                </div>
                <div class="card-body">
                    @if($user->collaborations->count())
                        <ul class="list-group list-group-flush">
                            @foreach($user->collaborations as $collab)
                                <li class="list-group-item">
                                    <strong>{{ $collab->project->title ?? '-' }}</strong><br>
                                    <small class="text-muted">Sebagai: {{ $collab->position ?? 'Kolaborator' }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Belum mengikuti proyek manapun.</p>
                    @endif
                </div>
            </div>

            {{-- PROYEK YANG SEDANG BERLANGSUNG --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Proyek Sedang Berlangsung</h5>
                </div>
                <div class="card-body">
                    @if($inProgressProjects->count())
                        <ul class="list-group list-group-flush">
                            @foreach($inProgressProjects as $project)
                                <li class="list-group-item">
                                    <strong>{{ $project->title }}</strong><br>
                                    <small class="text-muted">{{ $project->description ?? '' }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Tidak ada proyek yang sedang berlangsung.</p>
                    @endif
                </div>
            </div>

            {{-- PROYEK YANG SELESAI --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Proyek Selesai</h5>
                </div>
                <div class="card-body">
                    @if($completedProjects->count())
                        <ul class="list-group list-group-flush">
                            @foreach($completedProjects as $project)
                                <li class="list-group-item">
                                    <strong>{{ $project->title }}</strong><br>
                                    <small class="text-muted">{!! $project->description ?? '' !!}</small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Belum ada proyek yang selesai.</p>
                    @endif
                </div>
            </div>


            {{-- PUBLIKASI --}}
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Publikasi dari Proyek yang Diikuti</h5>
                </div>
                <div class="card-body">
                    @if($publications->count())
                        <ul class="list-group list-group-flush">
                            @foreach($publications as $publication)
                                <li class="list-group-item">
                                    <strong>{{ $publication->title }}</strong><br>
                                    <small class="text-muted">
                                        {{ $publication->journal ?? 'Jurnal Tidak Diketahui' }} -
                                        {{ $publication->publication_date }}
                                    </small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Belum ada publikasi dari proyek yang diikuti.</p>
                    @endif
                </div>
            </div>

        </div>
    </section>
@endsection