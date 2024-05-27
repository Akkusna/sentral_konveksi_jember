    <header>
        <!-- Header Start -->
        <div class="header-area">
            <div class="main-header ">
                <div class="header-top top-bg d-none d-lg-block">
                    <div class="container-fluid">
                        <div class="col-xl-12" style="height: 30px">
                            <div class="row d-flex align-items-end justify-content-end">
                                <div class="header-info-right">
                                    {{-- <ul>
                                        <li><a href="login.html">My Account</a></li>
                                        <li><a href="product_list.html">Wish List</a></li>
                                        <li><a href="cart.html">Shopping</a></li>
                                        <li><a href="cart.html">Cart</a></li>
                                        <li><a href="checkout.html">Checkout</a></li>
                                    </ul> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="header-bottom  header-sticky">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <!-- Logo -->
                            <div class="col-xl-1 col-lg-1 col-md-1 col-sm-4">
                                <div class="logo">
                                    {{-- <a href="index.html"><img src="assets/img/logo/sentral.png" alt=""></a> --}}
                                    <h1>Sentral</h1>

                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-8 col-md-7 col-sm-5">
                                <!-- Main-menu -->
                                <div class="main-menu f-right d-none d-lg-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a href="/">Home</a></li>
                                            <li><a class="hot" href="/category-landing">Kategori</a></li>
                                            <li><a href="/contact">Informasi Kontak</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-3 col-md-3 col-sm-3 fix-card">
                                <ul class="header-right f-right d-none d-lg-block d-flex justify-content-between">
                                    @if (auth()->check() && auth()->user()->is_admin == 0)
                                        <li class="d-none d-lg-block"> <a href="{{ route('dashboard-user') }}"
                                                class="btn header-btn">Pesanan Saya</a>
                                        </li>
                                    @else
                                        <li class="d-none d-lg-block"> <a href="{{ route('login') }}"
                                                class="btn header-btn">Login</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <!-- Mobile Menu -->
                            <div class="col-12">
                                <div class="mobile_menu d-block d-lg-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
