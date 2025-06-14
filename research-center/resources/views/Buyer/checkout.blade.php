@include('layouts.header')
<section class="page-header">
            <div class="page-header__bg" style="background-image: url(assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
            <!-- /.page-header__bg -->
            <div class="container">
                <h2 class="page-header__title">Checkout</h2>
                <ul class="nionx-breadcrumb list-unstyled">
                    <li><a href="index.html">Home</a></li>
                    <li><span>Shop</span></li>
                </ul><!-- /.thm-breadcrumb list-unstyled -->
            </div><!-- /.container -->
        </section><!-- /.page-header -->
        <!-- Checkout Start -->
        <section class="checkout-page">
            <div class="container">
                <div class="checkout-page__notice">Have a coupon?<a href="login.html"> Click here to enter your code</a></div>
                <div class="row">
                    <div class="col-xl-6 col-lg-6">
                        <div class="checkout-page__billing-address">
                            <h2 class="checkout-page__billing-address__title">Billing details</h2>
                            <form class="checkout-page__form">
                                <div class="row bs-gutter-x-20">
                                    <div class="col-xl-6">
                                        <div class="checkout-page__input-box">
                                            <input type="text" name="first-name" value="" placeholder="Frist name" required="">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="checkout-page__input-box">
                                            <input type="text" name="last-name" value="" placeholder="Last name" required="">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="checkout-page__input-box">
                                            <input type="email" name="email" value="" placeholder="Email address" required="">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="checkout-page__input-box">
                                            <input type="tel" name="form-phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required="" placeholder="Phone number">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="checkout-page__input-box">
                                            <input type="text" name="company-name" value="" placeholder="Company">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="checkout-page__input-box">
                                            <input type="text" name="address" value="" placeholder="Address">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="checkout-page__input-box">
                                            <input type="text" name="company-name" value="" placeholder="Apartment, Unit, etc(optional)">
                                        </div>
                                    </div>
                                </div>
                                <div class="row bs-gutter-x-20">
                                    <div class="col-xl-6">
                                        <div class="checkout-page__input-box">
                                            <input type="text" name="state" value="" placeholder="Town/City" required="">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="checkout-page__input-box">
                                            <input type="text" name="state" value="" placeholder="State">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="checkout-page__input-box">
                                            <input name="form_zip" type="text" pattern="[0-9]*" placeholder="Zip code">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="checkout-page__input-box">
                                            <input name="country" type="text" placeholder="Country">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="checkout-page__shipping-address">
                            <h2 class="checkout-page__shipping-address__title">Additional information</h2>
                            <form class="checkout-page__form">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="checkout-page__input-box">
                                            <textarea placeholder="Write a message" name="message"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="checkout-page__details">
                    <h2 class="checkout-page__details__title">Shipping details</h2>
                    <div class="checkout-page__details__check-box">
                        <input type="checkbox" name="skipper4" id="skipper4" checked>
                        <label for="skipper4">Same as billing details<span></span></label>
                    </div>
                </div><!-- /.checkout-page__details -->
                <div class="checkout-page__your-order">
                    <h2 class="checkout-page__your-order__title">Your order</h2>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6">
                            <table class="checkout-page__order-table">
                                <thead class="order_table_head">
                                    <tr>
                                        <th>Product</th>
                                        <th class="right">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="pro__title">Product name</td>
                                        <td class="pro__price">$10.33</td>
                                    </tr>
                                    <tr>
                                        <td class="pro__title">Subtotal</td>
                                        <td class="pro__price">$10.33</td>
                                    </tr>
                                    <tr>
                                        <td class="pro__title">Shipping</td>
                                        <td class="pro__price">$0.00</td>
                                    </tr>
                                    <tr>
                                        <td class="pro__title">Total</td>
                                        <td class="pro__price">$20.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <div class="checkout-page__payment">
                                <div class="checkout-page__payment__item checkout-page__payment__item--active">
                                    <h3 class="checkout-page__payment__title">Direct bank transfer</h3>
                                    <div class="checkout-page__payment__content" style="display: none;">
                                        Make your payment directly into our bank account. Please
                                        use your Order ID as the payment reference. Your order
                                        wont be shipped until the funds have cleared.
                                    </div><!-- /.checkout__payment__content -->
                                </div><!-- /.checkout__payment__item -->
                                <div class="checkout-page__payment__item">
                                    <h3 class="checkout-page__payment__title">Cash on delivery</h3>
                                    <div class="checkout-page__payment__content" style="display: none;">
                                        Make your payment directly into our bank account. Please
                                        use your Order ID as the payment reference. Your order
                                        wont be shipped until the funds have cleared.
                                    </div><!-- /.checkout__payment__content -->
                                </div><!-- /.checkout__payment__item -->
                            </div><!-- /.checkout__payment -->
                            <div class="text-right d-flex justify-content-start">
                                <a href="checkout.html" class="laboix-btn laboix-btn--secondary">
                                    <span>Place your Order</span>
                                </a>
                            </div><!-- /.text-right -->

                        </div><!-- /.col-lg-6 -->
                    </div>
                </div>
            </div>
        </section>
        <!-- Checkout End -->
         @include('layouts.footer')