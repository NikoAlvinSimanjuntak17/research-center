@include('layouts.header')
<section class="page-header">
    <div class="page-header__bg" style="background-image: url('{{ asset('images/backgrounds/tanamanherbal.jpg') }}')"></div>
    <!-- /.page-header__bg -->
    <div class="container">
        <h2 class="page-header__title">Register</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><span>Register</span></li>
        </ul><!-- /.thm-breadcrumb list-unstyled -->
    </div><!-- /.container -->
</section><!-- /.page-header -->

<!-- Register Start -->
<section class="login-page">
    <div class="container">
        <div class="login-page__inner">
            <div class="row">
                <div class="col wow fadeInUp animated" data-wow-delay="400ms">
                    <div class="login-page__wrap register-page__wrap">
                        <h3 class="login-page__wrap__title">Register</h3>
                        <form method="POST" action="{{ route('register.buyer') }}" class="login-page__form">
                            @csrf
                            <div class="login-page__form-input-box">
                                <input type="text" name="name" placeholder="Full Name" required>
                            </div>
                            <div class="login-page__form-input-box">
                                <input type="email" name="email" placeholder="Email Address" required>
                            </div>
                            <div class="login-page__form-input-box">
                                <input type="password" name="password" placeholder="Password*" required>
                            </div>
                            <div class="login-page__checked-box">
                                <input type="checkbox" name="accept_policy" id="accept-policy" required>
                                <label for="accept-policy"><span></span>I accept the company privacy policy.</label>
                            </div>
                            <div class="login-page__form-btn-box">
                                <button type="submit" class="laboix-btn laboix-btn--secondary">
                                    <span>Register</span>
                                </button>
                            </div>
                        </form>
                    </div><!-- register-form -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Register End -->

@include('layouts.footer')

