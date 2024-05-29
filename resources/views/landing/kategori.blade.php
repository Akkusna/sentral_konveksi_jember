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
                            <h2>Kategori</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider Area End-->

    <!-- Latest Products Start -->
    <section class="latest-product-area latest-padding">
        <div class="container">
            <div class="row product-btn d-flex justify-content-between">
                <div class="properties__button">
                    <!--Nav Button  -->
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                role="tab" aria-controls="nav-home" aria-selected="true">All</a>
                            @foreach ($kategori as $item)
                                <a class="nav-item nav-link kategori-tab" id="nav-profile-tab{{ $item->id }}"
                                    data-kategori-id="{{ $item->id }}" data-toggle="tab"
                                    href="#nav-profile-{{ $item->id }}" role="tab" aria-controls="nav-profile"
                                    aria-selected="false">{{ $item->nama }}</a>
                            @endforeach
                        </div>
                    </nav>
                    <!--End Nav Button  -->
                </div>
            </div>
            <!-- Nav Card -->
            <div class="tab-content" id="nav-tabContent">
                <!-- card one -->
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="row">
                        @foreach ($produk as $item)
                            <div class="col-xl-4 col-lg-4 col-md-6">
                                <div class="single-product mb-60">
                                    <div class="product-img">
                                        <a href="{{ route('produk.id', ['id' => $item->id]) }}">
                                            <img src="{{ asset('foto/product/' . $item->image) }}" alt=""></a>
                                        <div class="new-product">
                                            <span>New</span>
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
                <!-- Card two -->
                <!-- Tab Panel -->
                @foreach ($kategori as $item)
                    <div class="tab-pane fade" id="nav-profile-{{ $item->id }}" role="tabpanel"
                        aria-labelledby="nav-profile-tab{{ $item->id }}">
                        <div class="row" id="produkByCategory-{{ $item->id }}">
                            <!-- Konten produk akan dimuat di sini -->
                        </div>
                    </div>
                @endforeach

            </div>
            <!-- End Nav Card -->
        </div>
    </section>
    <!-- Latest Products End -->

    <!-- Shop Method Start-->
    <div class="shop-method-area section-padding30">
        <div class="container">
            <div class="row d-flex justify-content-between">
                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="single-method mb-40">
                        <i class="ti-package"></i>
                        <h6>Free Shipping Method</h6>
                        <p>aorem ixpsacdolor sit ameasecur adipisicing elitsf edasd.</p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="single-method mb-40">
                        <i class="ti-unlock"></i>
                        <h6>Secure Payment System</h6>
                        <p>aorem ixpsacdolor sit ameasecur adipisicing elitsf edasd.</p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="single-method mb-40">
                        <i class="ti-reload"></i>
                        <h6>Secure Payment System</h6>
                        <p>aorem ixpsacdolor sit ameasecur adipisicing elitsf edasd.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Method End-->

    <!-- JavaScript -->
@endsection
@push('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('.kategori-tab').click(function() {
                var kategoriId = $(this).data('kategori-id');
                $.ajax({
                    url: '/category-landing/' + kategoriId,
                    type: 'GET',
                    success: function(response) {
                        $('#produkByCategory-' + kategoriId).empty();
                        $.each(response, function(index, produk) {
                            $('#produkByCategory-' + kategoriId).append(
                                '<div class="col-xl-4 col-lg-4 col-md-6">' +
                                '<div class="single-product mb-60">' +
                                '<div class="product-img">' +
                                '<a href="/produk/' + produk.id + '">' +
                                '<img src="/foto/product/' + produk.image +
                                '" alt="">' +
                                '</a>' +
                                '<div class="new-product">' +
                                '<span>New</span>' +
                                '</div>' +
                                '</div>' +
                                '<div class="product-caption">' +
                                '<h4><a href="/produk/' + produk.id + '">' + produk
                                .nama + '</a></h4>' +
                                '<div class="price">' +
                                '<ul>' +
                                '<li>Rp. ' + formatRupiah(produk.harga) + '</li>' +
                                '</ul>' +
                                '</div>' +
                                '<form action="{{ route('checkout', ['id' => $item->id]) }}" method="GET">' +
                                '<button type="submit" class="btn header-btn mt-3">Pesan Sekarang</button>' +
                                '</form>' +
                                '</div>' +
                                '</div>' +
                                '</div>'
                            );
                        });
                    }
                });
            });


            // Function to format Rupiah
            function formatRupiah(angka) {
                var number_string = angka.toString(),
                    sisa = number_string.length % 3,
                    rupiah = number_string.substr(0, sisa),
                    ribuan = number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
                return rupiah;
            }
        });
    </script>
@endpush
