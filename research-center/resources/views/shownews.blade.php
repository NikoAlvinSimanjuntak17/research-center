@include('layouts.header')

<section class="page-header">
    <div class="page-header__bg" style="background-image: url('{{ asset('images/bg.jpg') }}');"></div>
    <!-- /.page-header__bg -->
    <div class="container">
        <h2 class="page-header__title">Detail Berita</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ route('news.index') }}">Berita</a></li>
            <li><span>{{ $news->title }}</span></li>
        </ul>
    </div>
</section>

<section class="blog-one blog-one--page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="blog-details">
                    <div class="blog-card__two">
                        {{-- Tanggal Berita --}}
                        <div class="blog-card_two_image">
                            <div class="blog-card_two_image">
                                    @if ($news->image)
                                        <img src="{{ asset('storage/' . $news->image) }}" alt="Berita Image" class="img-fluid">
                                    @else
                                        <p>Tidak ada gambar</p>
                                    @endif
                                </div>
                            <div class="blog-card_two_date">
                                <span class="blog-card_twodate_day">{{ $news->created_at->format('d') }}</span>
                                {{ strtoupper($news->created_at->format('M')) }}
                            </div>
                        </div>

                        <div class="blog-card_two_content">
                            {{-- Metadata --}}
                            <ul class="list-unstyled blog-card_two_meta">
                                <li class="blog-card_twometa_item">
                                    <i class="icon-user"></i>
                                    Oleh {{ $news->author?->name ?? 'Admin' }}
                                </li>
                                <li class="blog-card_twometa_item">
                                    <i class="icon-calendar"></i>
                                    {{ $news->created_at->toFormattedDateString() }}
                                </li>
                            </ul>

                            {{-- Judul & Konten --}}
                            <h3 class="blog-card_twotitle blog-cardtwo_title--two">{{ $news->title }}</h3>
                            <p class="blog-card_twotext blog-cardtwo_text--two">
                                {!! $news->description !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('layouts.footer')