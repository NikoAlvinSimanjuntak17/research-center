@include('layouts.header')

<section class="page-header">
    <div class="page-header__bg" style="background-image: url('{{ asset('images/backgrounds/tanamanherbal.jpg') }}');"></div>
    <div class="container">
        <h2 class="page-header__title">Login</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><span>Login</span></li>
        </ul>
    </div>
</section>

<section class="login-page">
    <div class="container">
        <div class="login-page__inner">
            <div class="row">
                <div class="wow fadeInUp animated" data-wow-delay="300ms">
                    <div class="col login-page__wrap">
                        <h3 class="login-page__wrap__title">Login</h3>
                        
                        @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        
                        <form action="{{ url('/login') }}" method="POST">
                            @csrf
                            <div class="login-page__form-input-box">
                                <input type="email" name="email" placeholder="Email address*" required>
                            </div>
                            <div class="login-page__form-input-box">
                                <input type="password" name="password" placeholder="Password*" required>
                            </div>
                            <div class="login-page__checked-box">
                                <div class="login-page__checked-inner">
                                    <input type="checkbox" name="remember" id="save-data">
                                    <label for="save-data"><span></span>Remember me?</label>
                                </div>
                                <div class="login-page__form-forgot-password">
                                    <a href="" class="login-page__form-forgot-password__item">Forgot password?</a>
                                </div>
                            </div>
                            <div class="login-page__form-btn-box">
                                <button type="submit" class="laboix-btn laboix-btn--secondary"><span>Login</span></button>
                            </div>
                            <div class="login-page__checked-box">
                                <div class="login-page__form-forgot-password">
                                    <p>Don't have an account? <a href="{{ url('/register') }}" class="login-page__form-forgot-password__item">Register</a></p>
                                </div>
                            </div>
                        </form>
                        <div class="form__border"></div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>

@include('layouts.footer')
