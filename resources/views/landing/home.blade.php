@extends('layouts.main-landing')
@section('content')
    <!-- slider Area Start -->
    <div class="slider-area ">
        <!-- Mobile Menu -->
        <div class="slider-active">
            <div class="single-slider slider-height" data-background="{{ asset('assets/img/hero/h1_hero.jpg') }}">
                <div class="container">
                    <div class="row d-flex align-items-center justify-content-between">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 d-none d-md-block">
                            <div class="hero__img" data-animation="bounceIn" data-delay=".4s">
                                <img src="assets/img/hero/hero_man.png" alt="">
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-8">
                            <div class="hero__caption">
                                <span data-animation="fadeInRight" data-delay=".4s">Sentral</span>
                                <h1 data-animation="fadeInRight" data-delay=".6s">Konveksi <br> Jember</h1>
                                <p data-animation="fadeInRight" data-delay=".8s">Terbaik dan Ekonomis
                                </p>
                                <!-- Hero-btn -->
                                <div class="hero__btn" data-animation="fadeInRight" data-delay="1s">
                                    <a href="/category-landing" class="btn hero-btn">Belanja Sekarang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider Area End-->
    <!-- Category Area Start-->
    <section class="category-area section-padding30">
        <div class="container-fluid">
            <!-- Section Tittle -->
            <div class="row ">
                <div class="col-lg-12">
                    <div class="section-tittle text-center mb-85">
                        <h2>Katalog Produk Kami</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($kategori as $item)
                    <div class="col-xl-4 col-lg-6">
                        <div class="single-category mb-30">
                            <div class="category-img">
                                @php
                                    $firstProduct = $item->produk->where('kategori_id', $item->id)->first();
                                    $firstProductImage = $firstProduct ? $firstProduct->image : 'default_image.jpg'; // Use default image if no product found
                                @endphp
                                <a href="{{ route('kategori.id', ['id' => $item->id]) }}"><img
                                        src="{{ asset('assets/img/hero/h1_hero.jpg') }}" style="color: #000;"
                                        alt=""></a>
                                <div class="category-caption">
                                    <h2 style="">{{ $item->nama }}</h2>
                                    <span class="best"><a href="{{ route('kategori.id', ['id' => $item->id]) }}">Harga Terbaik</a></span>
                                    <span class="collection">Koleksi Terbaru</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Category Area End-->
    <!-- Latest Products Start -->
    <section class="latest-product-area padding-bottom">
        <div class="container">
            <div class="row product-btn d-flex justify-content-end align-items-end">
                <!-- Section Tittle -->
                <div class="col-xl-8 col-lg-7 col-md-7">
                    <div class="section-tittle mb-30">
                        <h2>Produk Terbaru</h2>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-7 col-md-7">
                    <div class="properties__button f-right">
                    </div>
                </div>
            </div>
            <!-- Nav Card -->
            <div class="tab-content" id="nav-tabContent">
                <!-- card one -->
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="row">
                        @foreach ($latestProduk as $item)
                            <div class="col-xl-4 col-lg-4 col-md-6">
                                <div class="single-product mb-60">
                                    <div class="product-img">
                                        <a href="{{ route('produk.id', ['id' => $item->id]) }}">
                                            <img src="{{ asset('foto/product/' . $item->image) }}" alt=""></a>
                                        <div class="new-product">
                                            <span>Baru</span>
                                        </div>
                                    </div>
                                    <div class="product-caption">
                                        <h4><a href="{{ route('produk.id', ['id' => $item->id]) }}">{{ $item->nama }}</a>
                                        </h4>
                                        <div class="price">
                                            <ul>
                                                <li>Rp. {{ number_format($item->harga, 0, ',', '.') }}</li>
                                            </ul>
                                        </div>
                                        <form action="{{ route('checkout', ['id' => $item->id]) }}" method="GET">
                                            <button type="submit" class="btn header-btn mt-3">Pesan Sekarang</button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- End Nav Card -->
        </div>
    </section>
    <!-- Latest Products End -->
    <!-- Best Product Start -->
    <div class="best-product-area lf-padding">
        <div class="product-wrapper bg-height" style="background-image: url('assets/img/categori/card.png')">
            <div class="container position-relative">
                <div class="row justify-content-between align-items-end">
                    <div class="product-man position-absolute  d-none d-lg-block">
                        {{-- <img src="assets/img/categori/card-man.png" alt=""> --}}
                    </div>
                    <div class="col-xl-2 col-lg-2 col-md-2 d-none d-lg-block">
                        <div class="vertical-text">
                            <span>Sentral</span>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8">
                        <div class="best-product-caption">
                            <h2>Konveksi<br> Jember.</h2>
                            <p>Temukan produk terbaik dari toko kami</p>
                            <a href="/category-landing" class="black-btn">Belanja Sekarang</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Shape -->
        <div class="shape bounce-animate  d-none d-md-block">
            <img src="assets/img/categori/card-shape.png" alt="" class="responsive-shape">
        </div>
    </div>
    <!-- Best Product End-->
    <!-- Shop Method Start-->
    <div class="shop-method-area section-padding30">
        <div class="container">
            <div class="row d-flex justify-content-between">
                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="single-method mb-40">
                        <i class="ti-package"></i>
                        <h6>Pengiriman Cepat</h6>
                        <p>Dapatkan pesanan Anda dengan cepat dan tepat waktu.</p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="single-method mb-40">
                        <i class="ti-unlock"></i>
                        Dapatkan pesanan Anda dengan cepat dan tepat waktu.
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="single-method mb-40">
                        <i class="ti-reload"></i>
                        <h6>Terbaik dan Ekonomis</h6>
                        <p>Temukan solusi terbaik dengan harga yang ekonomis.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Method End-->
    <!-- Best Collection Start -->
    {{-- <div class="best-collection-area section-padding2">
        <div class="container">
            <div class="row d-flex justify-content-between align-items-end">
                <!-- Left content -->
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="best-left-cap">
                        <h2>Konveksi Jember</h2>
                        <p>Sentral Bordir Sablon Jember.</p>
                        <a href="/category-landing" class="btn shop1-btn">Pesan Sekarang</a>
                    </div>
                    <div class="best-left-img mb-30 d-none d-sm-block">
                        <img src="assets/img/collection/collection1.png" alt="">
                    </div>
                </div>
                <!-- Mid Img -->
                <div class="col-xl-2 col-lg-2 d-none d-lg-block">
                    <div class="best-mid-img mb-30 ">
                        <img src="assets/img/collection/collection2.png" alt="">
                    </div>
                </div>
                <!-- Riht Caption -->
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="best-right-cap ">
                        <div class="best-single mb-30">
                            <div class="single-cap">
                                <h4>Jaket<br></h4>
                            </div>
                            <div class="single-img">
                                <img src="assets/img/collection/collection3.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="best-right-cap">
                        <div class="best-single mb-30">
                            <div class="single-cap active">
                                <h4>Kemeja<br></h4>
                            </div>
                            <div class="single-img">
                                <img src="assets/img/collection/collection4.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="best-right-cap">
                        <div class="best-single mb-30">
                            <div class="single-cap">
                                <h4>Kaos<br></h4>
                            </div>
                            <div class="single-img">
                                <img src="assets/img/collection/collection5.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Best Collection End -->
    <style>
        .responsive-shape {
    width: 480px; /* Set the width to a fixed size */
    max-width: 100%; /* Ensure the image doesn't exceed 100% of its container */
    height: auto; /* Maintain aspect ratio */
    /* Optional: Add a minimum width */
    min-width: 300px; /* Set a minimum width to prevent the image from becoming too small */
}

    </style>
@endsection
