@include('layouts.header')

<section class="page-header">
    <div class="page-header__bg" style="background-image: url('{{ asset('images/bg.jpg') }}');"></div>
    <!-- /.page-header__bg -->
    <div class="container">
        <h2 class="page-header__title">Struktur Organisasi TSTH</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><span>Struktur Organisasi TSTH</span></li>
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
                        <h3 class="sec-title__title">Struktur Organisasi TSTH</h3>
                    </div>
                    @foreach ($organization as $item)
                        <div class="service-details__thumbnail wow fadeInUp mb-5" data-wow-delay='300ms'>
                            <h3 class="mb-3">{{ $item->title }}</h4>

                            <img 
                                src="{{ asset($item->image ? 'storage/' . $item->image : 'images/default.jpg') }}" 
                                alt="{{ $item->title }}" 
                                class="img-fluid mb-3">

                            <div class="about-two__top">
                                {!! $item->description !!}
                            </div>
                        </div>
                        @endforeach

                </div>
            </div>
        </div>
    </div><!-- /.service-details__thumbnail -->
</section>
@include('layouts.footer')
