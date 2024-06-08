@extends('layouts.main-landing')
@section('content')
    <div class="slider-area">
        <!-- Mobile Menu -->
        <div class="single-slider slider-height2 d-flex align-items-center"
            data-background="{{ asset('assets/img/hero/h1_hero.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2>Katalog Produk</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     
    <!-- Product list part start -->
    <section class="product_list section_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product_list">
                        <div class="row">
                            @foreach ($produk as $item)
                                <div class="col-lg-3 col-sm-6 mb-4">
                                    <div class="single_product_item d-flex flex-column" style="height: 100%;">
                                        <div class="product-image"
                                            style="background-image: url('{{ asset('foto/product/' . $item->image) }}'); height: 200px; background-size: cover; background-position: center; margin-bottom: 15px;">
                                        </div>
                                        <div style="flex-grow: 1;">
                                            <h3>
                                                <a href="{{ route('produk.id', ['id' => $item->id]) }}">{{ $item->nama }}</a>
                                            </h3>
                                            <ul style="padding: 0; list-style: none; margin-bottom: 10px;">
                                                <li>Rp. {{ number_format($item->harga, 0, ',', '.') }}</li>
                                            </ul>
                                            <form action="{{ route('checkout', ['id' => $item->id]) }}" method="GET" style="margin-top: 20px;">
                                                <button type="submit" class="btn btn-primary" style="width: 100%;">Pesan Sekarang</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product list part end -->
@endsection
