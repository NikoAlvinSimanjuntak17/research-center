@include('layouts.header')

<section class="page-header">
   <div class="page-header__bg" style="background-image: url('{{ asset('images/bg.jpg') }}');"></div>
    <!-- /.page-header__bg -->
    <div class="container">
        <h2 class="page-header__title">Daftar Proyek</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><span>Proyek</span></li>
        </ul>
    </div>
</section>

<section class="blog-one blog-one--page py-5">
    <div class="container">
        <div class="row gutter-y-60">
            <div class="col-lg-4">
                <aside class="widget-area">
                    <div class="sidebar__single wow fadeInUp" data-wow-delay="300ms">
                        <h4 class="sidebar__title">Exp Proyek</h4>
                        <ul class="list-unstyled">
                            @forelse ($closedProjects as $closed)
                            <li class="mb-2">
                                <h3 class="blog-card__two__title">
                                        <a href="{{ route('projects.show', $closed->id) }}">{!! Str::limit(strip_tags($closed->title), 15) !!}</a>
                                    </h3>
                                <small class="text-muted">{{ $closed->close_at->format('d M Y') }}</small>
                            </li>
                            @empty
                            <li>Tidak ada proyek yang sudah selesai.</li>
                            @endforelse
                        </ul>
                    </div>
                </aside>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    @forelse ($projects as $project)
                        <div class="col-md-12 mb-4">
                            <div class="blog-card__two wow fadeInUp" data-wow-delay="100ms">
                                <div class="blog-card__two__content">
                                    <ul class="list-unstyled blog-card__two__meta">
                                        <li><i class="icon-user"></i> Oleh {{ $project->creator?->name ?? 'Tidak diketahui' }}</li>
                                        <li><i class="icon-clock-1"></i> {{ $project->open_at->format('d M Y') }} – {{ $project->close_at->format('d M Y') }}</li>
                                    </ul>
                                    <h3 class="blog-card__two__title">
                                        <a href="{{ route('projects.show', $project->id) }}">{{ $project->title }}</a>
                                    </h3>
                                    <p class="blog-card__two__text">{!! Str::limit(strip_tags($project->description), 150) !!}</p>
                                    <a href="{{ route('projects.show', $project->id) }}" class="laboix-btn laboix-btn--submite mt-3">
                                        Lihat Detail <i class="icon-arrow"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <div class="alert alert-info">Belum ada proyek yang tersedia saat ini.</div>
                        </div>
                    @endforelse

                    {{-- Pagination (harus di luar loop) --}}
                    @if ($projects->hasPages())
                        <div class="col-12">
                            <div class="pronation_widget wow fadeInUp" data-wow-delay="300ms">
                                <ul class="d-flex justify-content-start list-unstyled">
                                    {{-- Previous Page --}}
                                    @if ($projects->onFirstPage())
                                        <li><span class="disabled"><i class="fas fa-angle-left"></i></span></li>
                                    @else
                                        <li><a href="{{ $projects->previousPageUrl() }}"><i class="fas fa-angle-left"></i></a></li>
                                    @endif

                                    {{-- Page Numbers --}}
                                    @foreach ($projects->getUrlRange(1, $projects->lastPage()) as $page => $url)
                                        <li>
                                            <a href="{{ $url }}" class="{{ $page == $projects->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Next Page --}}
                                    @if ($projects->hasMorePages())
                                        <li><a href="{{ $projects->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a></li>
                                    @else
                                        <li><span class="disabled"><i class="fas fa-angle-right"></i></span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@include('layouts.footer')
