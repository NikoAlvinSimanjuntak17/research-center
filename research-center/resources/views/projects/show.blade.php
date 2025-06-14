@include('layouts.header')

<section class="page-header">
    <div class="page-header__bg" style="background-image: url('{{ asset('images/bg.jpg') }}');"></div>
    <!-- /.page-header__bg -->
    <div class="container">
        <h2 class="page-header__title">Project Details</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ route('projects.index') }}">Projects</a></li>
            <li><span>{{ $project->title }}</span></li>
        </ul>
    </div>
</section>

<section class="blog-one blog-one--page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="blog-details">
                    <div class="blog-card__two">
                        {{-- Tanggal Pembuatan Proyek --}}
                        <div class="blog-card__two__image">
                            <div class="blog-card__two__date">
                                <span class="blog-card__two__date__day">{{ $createdAt->format('d') }}</span>
                                {{ strtoupper($createdAt->format('M')) }}
                            </div>
                        </div>

                        <div class="blog-card__two__content">
                            {{-- Metadata --}}
                            <ul class="list-unstyled blog-card__two__meta">
                                <li class="blog-card__two__meta__item">
                                    <i class="icon-user"></i>
                                    Oleh {{ $project->creator?->name ?? 'Tidak diketahui' }}
                                </li>
                                <li class="blog-card__two__meta__item">
                                    <i class="icon-calendar"></i>
                                    {{ $createdAt->toFormattedDateString() }}
                                </li>
                            </ul>

                            {{-- Judul & Deskripsi --}}
                            <h3 class="blog-card__two__title blog-card__two__title--two">{{ $project->title }}</h3>
                            <p class="blog-card__two__text blog-card__two__text--two">
                                {!! $project->description !!}
                                {{-- Jika ingin aman dari XSS, gunakan: --}}
                                {{-- {{ $project->description }} --}}
                            </p>

                            {{-- Status Pendaftaran Kolaborator --}}
                            @if ($isClosed)
                                <p class="text-danger mt-3"><strong>Pendaftaran untuk proyek ini sudah ditutup.</strong></p>
                            @elseif (!$hasApplied)
                                <a href="{{ route('collaborator.apply', $project->id) }}" class="laboix-btn">
                                    Daftar Sebagai Kolaborator
                                </a>
                            @else
                                <p class="text-success mt-3"><strong>Kamu sudah mendaftar sebagai kolaborator untuk proyek ini.</strong></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('layouts.footer')
