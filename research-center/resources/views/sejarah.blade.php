@include('layouts.header')

<section class="page-header">
    <div class="page-header__bg" style="background-image: url('{{ asset('images/bg.jpg') }}');"></div>
    <div class="container">
        <h2 class="page-header__title">Sejarah TSTH</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><span>Sejarah TSTH</span></li>
        </ul>
    </div>
</section>

<section class="about-two">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="">
                    <div class="sec-title text-start wow fadeInUp" data-wow-duration="1500ms">
                        <h6 class="sec-title__tagline">
                            <img src="{{ asset('images/shapes/sec-title-s-1.png') }}" alt="About Us" class="sec-title__img">
                            About Us
                        </h6>
                        <h3 class="sec-title__title">{{ $history->title ?? 'Sejarah TSTH' }}</h3>
                    </div>
                    @if($history)
                    <div class="service-details__thumbnail wow fadeInUp" data-wow-delay='300ms'>
                        @if($history->image)
                            <img src="{{ asset('storage/' . $history->image) }}" alt="Sejarah TSTH" class="img-fluid mb-3" width="500">
                        @endif
                        <div class="about-two__top">
                            {!! $history->description !!}
                        </div>
                    </div>
                    @else
                    <p class="text-muted">Belum ada informasi sejarah yang tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@include('layouts.footer')
