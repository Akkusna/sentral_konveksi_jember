@extends('layouts.main-landing')

@section('content')
    <!-- slider Area Start-->
    <div class="slider-area ">
        <!-- Mobile Menu -->
        <div class="single-slider slider-height2 d-flex align-items-center"
            data-background="{{ asset('assets/img/hero/h1_hero.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="hero-cap text-center">
                            <h2>Detail Produk</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider Area End-->
    <!--================Single Product Area =================-->
    <!--================End Single Product Area =================-->
    <!-- subscribe part here -->
    <div class="whole-wrap">
        <div class="container box_1170">
            <div class="section-top-border">
                <h3 class="mb-30">Detail Produk</h3>
                <div class="row">
                    <div class="col-md-3">
                        <img src="{{ asset('foto/product/' . $produk->image) }}" height="300px" width="250px"
                            alt="" class="img-fluid">
                    </div>
                    <div class="col-md-9 mt-sm-20">
                        <h3>{{ $produk->nama }}<br>
                        </h3>

                        <h5 class="mt-5">Warna : </h5>
                        <div class="product_count_area mb-2">
                            <div class="button-group-area">
                                @foreach ($produk->produkColor as $detail)
                                    <a class="genric-btn disable"
                                        style="background: {{ $detail->color->code_color }}">{{ $detail->color->name_color }}</a>
                                @endforeach
                            </div>
                        </div>

                        <h5 class="mt-5">Ukuran : </h5>
                        <div class="row ml-1">
                            @foreach ($produk->produkUkuran as $item)
                                <p class="mr-2">{{ $item->ukuran->ukuran }}</p>
                            @endforeach
                        </div>
                        <h5 class="mt-5">Deskripsi : </h5>
                        <p>{{ $produk->deskripsi }}</p>
                        <h5 class="mt-5">Harga : </h5>
                        <p>Rp. {{ number_format($produk->harga, 0, ',', '.') }}</p>
                        <form action="{{ route('checkout', ['id' => $produk->id]) }}" method="GET">
                            <div class="card_area">
                                <div class="add_to_cart">
                                    <button type="submit" class="btn_3">CheckOut</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- subscribe part end -->
@endsection
