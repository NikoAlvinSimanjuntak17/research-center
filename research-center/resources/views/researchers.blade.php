@include('layouts.header')

<section class="page-header">
    <div class="page-header__bg" style="background-image: url('{{ asset('images/bg.jpg') }}');"></div>
    <!-- /.page-header__bg -->
    <div class="container">
        <h2 class="page-header__title">Daftar Peneliti</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><span>Peneliti</span></li>
        </ul>
    </div>
</section>

<section class="team-one">
    <div class="container">
        <div class="row gutter-y-30">
            @foreach($researchers as $researcher)
            <div class="col-md-6 col-lg-4">
                <div class="team-card wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='200ms'>
                    <div class="team-card__inner">
                        <div class="team-card__image">
                            <img 
                                src="{{ $researcher->image ? asset('storage/' . $researcher->image) : asset('images/team/team-1-1.jpg') }}" 
                                alt="{{ $researcher->user->name ?? 'Peneliti' }}" 
                                style="width: 360px; height: 400px; object-fit: cover; border-radius: 0;">
                        </div>
                        <div class="team-card__content">
                            <div class="team-card__content__inner">
                                <div class="team-card__content__item">
                                    <h3 class="team-card__content__title">
                                        <a href="{{ route('publications.byresearcher', $researcher->id) }}">
                                            {{ $researcher->user->name }}
                                        </a>
                                    </h3>
                                    <h6 class="team-card__content__designation">
                                        {{ $researcher->department->name ?? 'Tidak Ada Jabatan' }}
                                    </h6>
                                    <p class="text-muted small">
                                        {{ $researcher->department->institution->name ?? 'Tidak Ada Institusi' }}
                                    </p>
                                </div>                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $researchers->links('pagination::bootstrap-5') }}
        </div>
    </div>
</section>

@include('layouts.footer')
