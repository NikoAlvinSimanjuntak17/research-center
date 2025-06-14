@include('layouts.header')
<section class="page-header">
    <div class="page-header__bg" style="background-image: url('{{ asset('images/bg.jpg') }}');"></div>
    <!-- /.page-header__bg -->
    <div class="container">
        <h2 class="page-header__title">About</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="#">Home</a></li>
            <li><span>Visi & Misi</span></li>
        </ul><!-- /.thm-breadcrumb list-unstyled -->
    </div><!-- /.container -->
</section><!-- /.page-header -->

<section class="service-details">
    <div class="container">
        <div class="row gutter-y-30">
            <div class="col">
                <div class="service-details__content">
                    <div class="service-details__single">
                        <div class="service-details__thumbnail wow fadeInUp" data-wow-delay='300ms'>
                            <img src=" {{ asset('images/service/service-d-1-1.png')}}" alt="Artificial intelligence">
                        </div><!-- /.service-details__thumbnail -->
                        
                        <h3 class="service-details__title wow fadeInUp" data-wow-delay='300ms'>Visi</h3><!-- /.service-details__title -->
                        
                        <!-- Menampilkan konten Visi & Misi dari database -->
                        <div class="service-details__text wow fadeInUp" data-wow-delay='350ms'>
                            {!! $visi !!} <!-- Menampilkan konten visi -->
                        </div>
                        
                        <h3 class="service-details__title wow fadeInUp" data-wow-delay='300ms'>Misi </h3><!-- /.service-details__title -->

                        <div class="service-details__text wow fadeInUp" data-wow-delay='400ms'>
                            {!! $misi !!} <!-- Menampilkan konten misi -->
                        </div>
                        
                    </div><!-- /.service-details__single--> 
                </div><!-- /.service-details__content -->
            </div><!-- /.col-md-12 col-lg-8 -->
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.service-details -->

@include('layouts.footer')