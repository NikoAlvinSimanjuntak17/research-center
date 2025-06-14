@include('layouts.header')

<section class="page-header">
    <div class="page-header__bg" style="background-image: url('{{ asset('images/bg.jpg') }}');"></div>
    <!-- /.page-header__bg -->
    <div class="container">
        <h2 class="page-header__title">Berita Terbaru</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><span>Berita</span></li>
        </ul>
    </div>
</section>

<section class="blog-one blog-one--page py-5">
    <div class="container">
        <div class="row gutter-y-60">
            <div class="col-lg-4">
                <aside class="widget-area">
                    <div class="sidebar__single wow fadeInUp" data-wow-delay="300ms">
                        <h4 class="sidebar__title">Arsip Berita</h4>
                        <ul class="list-unstyled">
                            @forelse ($archivedNews as $archive)
                            <li class="mb-2">
                                <h3 class="blog-card__two__title">
                                    <a href="{{ route('shownews', $archive->id) }}">
                                        {!! Str::limit(strip_tags($archive->title), 30) !!}
                                    </a>
                                </h3>
                                <small class="text-muted">{{ $archive->created_at->format('d M Y') }}</small>
                            </li>
                            @empty
                            <li>Tidak ada arsip berita.</li>
                            @endforelse
                        </ul>
                    </div>
                </aside>
            </div>

            <div class="col-lg-8">
                <div class="row">
                    @forelse ($news as $item)
                        <div class="col-md-12 mb-4">
                            <div class="blog-card__two wow fadeInUp" data-wow-delay="100ms">
                                <div class="blog-card__two__content">
                                    <ul class="list-unstyled blog-card__two__meta">
                                        <li><i class="icon-user"></i> TSTH  &nbsp;</li>
                                        <li><i class="icon-clock-1"></i> {{ $item->created_at->format('d M Y') }}</li>
                                    </ul>
                                    <div class="blog-card__two__image">
                                        @if ($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="Berita Image" class="img-fluid">
                                        @else
                                            <p>Tidak ada gambar</p>
                                        @endif
                                    </div>
                                    <h3 class="blog-card__two__title">
                                        <a href="{{ route('shownews', $item->id) }}">{{ $item->title }}</a>
                                    </h3>
                                    <p class="blog-card__two__text">{!! Str::limit(strip_tags($item->content), 150) !!}</p>
                                    <a href="{{ route('shownews', $item->id) }}" class="laboix-btn laboix-btn--submite mt-3">
                                        Baca Selengkapnya <i class="icon-arrow"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <div class="alert alert-info">Belum ada berita yang tersedia saat ini.</div>
                        </div>
                    @endforelse

                    {{-- Pagination --}}
                    @if ($news->hasPages())
                        <div class="col-12">
                            <div class="pronation_widget wow fadeInUp" data-wow-delay="300ms">
                                <ul class="d-flex justify-content-start list-unstyled">
                                    {{-- Previous --}}
                                    @if ($news->onFirstPage())
                                        <li><span class="disabled"><i class="fas fa-angle-left"></i></span></li>
                                    @else
                                        <li><a href="{{ $news->previousPageUrl() }}"><i class="fas fa-angle-left"></i></a></li>
                                    @endif

                                    {{-- Pages --}}
                                    @foreach ($news->getUrlRange(1, $news->lastPage()) as $page => $url)
                                        <li>
                                            <a href="{{ $url }}" class="{{ $page == $news->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    {{-- Next --}}
                                    @if ($news->hasMorePages())
                                        <li><a href="{{ $news->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a></li>
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
