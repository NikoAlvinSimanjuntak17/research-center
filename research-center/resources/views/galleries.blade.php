@include('layouts.header')

<section class="page-header">
    <div class="page-header__bg" style="background-image: url('{{ asset('images/bg.jpg') }}');"></div>
    <!-- /.page-header__bg -->
    <div class="container">
        <h2 class="page-header__title">Gallery  </h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><span>Gallery</span></li>
        </ul><!-- /.thm-breadcrumb list-unstyled -->
    </div><!-- /.container -->
</section><!-- /.page-header -->

<section class="gallery-one gallery-one--page">
    <div class="container">
        <div class="row masonry-layout">
            @foreach ($galleries as $gallery)
                <div class="col-md-6 col-lg-4">
                    <div class="gallery-one__card">
                        <!-- Menampilkan gambar yang diupload -->
                        <img src="{{ asset('storage/' . $gallery->photo) }}" alt="gallery-image">
                        <div class="gallery-one__card__hover">
                            <a href="{{ asset('storage/' . $gallery->photo) }}" class="img-popup">
                                <div class="gallery-one__card__icon">
                                    <span class="gallery-one__card__icon__item"></span>
                                </div>
                            </a>
                        </div><!-- /.gallery-one__card__hover -->
                    </div><!-- /.gallery-one__card -->
                </div><!-- /.col-md-6 col-lg-4 -->
            @endforeach
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section><!-- /.gallery-one -->

@include('layouts.footer')
