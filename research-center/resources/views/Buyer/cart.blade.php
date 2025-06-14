@include('layouts.header')

<section class="page-header">
            <div class="page-header__bg" style="background-image: url(assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
            <!-- /.page-header__bg -->
            <div class="container">
                <h2 class="page-header__title">Cart</h2>
                <ul class="nionx-breadcrumb list-unstyled">
                    <li><a href="index.html">Home</a></li>
                    <li><span>Shop</span></li>
                </ul><!-- /.thm-breadcrumb list-unstyled -->
            </div><!-- /.container -->
        </section><!-- /.page-header -->


        <!-- Cart Start -->
        <section class="cart-page">
            <div class="container">
                <div class="table-responsive">
                    <table class="table cart-page__table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="cart-page__table__meta">
                                        <div class="cart-page__table__meta-img">
                                            <img src="{{ asset('images/products/cart-1-1.jpg') }}" alt="laboix">
                                        </div>
                                        <h3 class="cart-page__table__meta-title"><a href="product-details.html">Office chair</a>
                                        </h3>
                                    </div>
                                </td>
                                <td>$10.99</td>
                                <td>
                                    <div class="product-details__quantity">
                                        <div class="quantity-box">
                                            <button type="button" class="sub"><i class="fa fa-minus"></i></button>
                                            <input type="text" value="1">
                                            <button type="button" class="add"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </td>
                                <td>$10.99</td>
                                <td>
                                    <a href="cart.html" class="table cart-page__table__remove"><i class="fas fa-times"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="cart-page__table__meta">
                                        <div class="cart-page__table__meta-img">
                                            <img src="{{ asset('images/products/cart-1-2.jpg') }}" alt="laboix">
                                        </div>
                                        <h3 class="cart-page__table__meta-title"><a href="product-details.html">Round chair</a>
                                        </h3>
                                    </div>
                                </td>
                                <td>$10.99</td>
                                <td>
                                    <div class="product-details__quantity">
                                        <div class="quantity-box">
                                            <button type="button" class="sub"><i class="fa fa-minus"></i></button>
                                            <input type="text" value="1">
                                            <button type="button" class="add"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </td>
                                <td>$10.99</td>
                                <td><a href="cart.html" class="table cart-page__table__remove"><i class="fas fa-times"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-xl-8 col-lg-7">
                        <form action="#" class="cart-page__coupone-form">
                            <input type="text" placeholder="Enter coupon code" class="cart-cupon__input">
                            <button type="submit" class="laboix-btn laboix-btn--submite"><span>Apply Coupon</span></button>
                        </form>
                    </div>
                    <div class="col-xl-4 col-lg-5">
                        <ul class="cart-page__cart-total list-unstyled">
                            <li><span>Subtotal</span><span class="cart-page__cart-total-amount">$20.98 </span></li>
                            <li><span>Shipping cost</span><span class="cart-page__cart-total-amount">$0.00 </span></li>
                            <li><span>Total</span><span class="cart-page__cart-total-amount">$20.98 </span></li>
                        </ul>
                        <div class="cart-page__buttons">
                            <a href="cart.html" class="laboix-btn"><span>Update</span></a>
                            <a href="{{ route('Buyer.checkout') }}" class="laboix-btn laboix-btn--base"><span>checkout</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Cart End -->
        @include('layouts.footer')