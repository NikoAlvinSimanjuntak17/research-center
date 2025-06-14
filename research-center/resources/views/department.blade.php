@include('layouts.header')

<section class="page-header">
    <div class="page-header__bg" style="background-image: url('{{ asset('images/bg.jpg') }}');"></div>
    <!-- /.page-header__bg -->
    <div class="container">
        <h2 class="page-header__title">Departments</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><span>Departments</span></li>
        </ul>
    </div>
</section>

<section class="blog-one blog-one--page">
    <div class="container">
        <div class="row gutter-y-30">
            @foreach ($departments as $department)
                <div class="col-md-6 col-lg-4">
                    <div class="blog-card wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='{{ $loop->index * 100 }}ms'>
                        <div class="blog-card__content">
                            <h3 class="blog-card__title">
                                <a href="{{ route('department.detail', $department->id) }}">
                                    {{ $department->name }}
                                </a>
                            </h3>
                            <p class="mb-2 text-muted">{{ $department->institution->name }}</p>
                            <div class="blog-card__content__btn">
                                <a href="{{ route('department.detail', $department->id) }}" class="blog-card__content__btn__link">
                                    Lihat Detail <i class="icon-arrow"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@include('layouts.footer')
