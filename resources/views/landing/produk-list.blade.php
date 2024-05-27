@extends('layouts.main-landing')
@section('content')
    <div class="slider-area ">
        <!-- Mobile Menu -->
        <div class="single-slider slider-height2 d-flex align-items-center"
            data-background="{{ asset('assets/img/hero/h1_hero.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2>product list</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- product list part start-->
    <section class="product_list section_padding">
        <div class="container">
            <div class="row">

                <div class="col-md-12">
                    <div class="product_list">
                        <div class="row">
                            @foreach ($produk as $item)
                                <div class="col-lg-3 col-sm-3">
                                    <div class="single_product_item">
                                        <div class="product-image"
                                            style="background-image: url('{{ asset('foto/product/' . $item->image) }}');">
                                        </div>
                                        <h3> <a href="{{ route('produk.id', ['id' => $item->id]) }}">{{ $item->nama }}</a>
                                        </h3>
                                        <p>Rp. {{ number_format($item->harga, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- product list part end-->

    <!-- client review part here -->

    <!-- client review part end -->


    <!-- subscribe part end -->
@endsection
