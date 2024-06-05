@extends('layouts.main-landing')
@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@push('scripts')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to update dropdown options
            function updateDropdownOptions() {
                var selectedColors = [];
                var selectedSizes = [];

                // Collect all selected color and size values
                $('.pesanan_row').each(function() {
                    var color = $(this).find('.color_select').val();
                    var size = $(this).find('.ukuran_select').val();

                    if (color) {
                        selectedColors.push(color);
                    }

                    if (size) {
                        selectedSizes.push(size);
                    }
                });

                // Update the options for each dropdown based on selected values
                $('.pesanan_row').each(function() {
                    var currentColor = $(this).find('.color_select').val();
                    var currentSize = $(this).find('.ukuran_select').val();

                    $(this).find('.color_select option').each(function() {
                        if (selectedColors.includes($(this).val()) && $(this).val() !=
                            currentColor) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });

                    $(this).find('.ukuran_select option').each(function() {
                        if (selectedSizes.includes($(this).val()) && $(this).val() != currentSize) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });
                });
            }

            // Add new order row
            $('.add_row').click(function() {
                var row = $('.pesanan_row:first').clone(true,
                    true); // Clone the first row with event handlers
                row.find('.color_select').val(''); // Reset dropdown color
                row.find('.ukuran_select').val(''); // Reset dropdown size
                row.find('input[type="number"]').val(''); // Reset input quantity
                $('#pesanan_container').append(row);
                updateDropdownOptions(); // Update dropdown options after adding a new row
            });

            // Remove order row
            $(document).on('click', '.remove_row', function() {
                $(this).closest('.pesanan_row').remove();
                updateDropdownOptions(); // Update dropdown options after removing a row
            });

            // Monitor shipping option change
            $('#pengiriman_select').change(function() {
                if ($(this).val() === 'pengiriman') {
                    $('#biaya_pengiriman').show();
                } else {
                    $('#biaya_pengiriman').hide();
                }
            });

            // Initialize shipping dropdown display
            if ($('#pengiriman_select').val() === 'pengiriman') {
                $('#biaya_pengiriman').show();
            } else {
                $('#biaya_pengiriman').hide();
            }

            // Calculate total and update UI
            $('#cekButton').click(function() {
                var totalHarga = 0;
                var orderSummary = $('#order_summary');
                orderSummary.empty(); // Clear the order summary

                $('.pesanan_row').each(function() {
                    var warna = $(this).find('.color_select option:selected').text();
                    var ukuran = $(this).find('.ukuran_select option:selected').text();
                    var qty = $(this).find('input[type="number"]').val();
                    var hargaProduk = {{ $produk->harga }};
                    var totalItemHarga = hargaProduk * qty;

                    totalHarga += totalItemHarga;
                    orderSummary.append('<li>' + warna + ' ' + ukuran +
                        ' <span class="middle"> x ' +
                        qty + '</span> <span class="last"> = Rp. ' + totalItemHarga
                        .toLocaleString() +
                        '</span></li>');
                });

                $('#totalPrice').text('Rp. ' + totalHarga.toLocaleString());

                // Remove commas from totalHarga and set it as integer
                var parsedTotal = totalHarga.toString().replace(/,/g, '');
                $('#grandTotalInput').val(parsedTotal);
            });

            // Update dropdown options on initial load
            updateDropdownOptions();
        });
    </script>
@endpush
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
                            <h2>Checkout</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider Area End-->

    <!--================Checkout Area =================-->
    <section class="checkout_area section_padding">
        <div class="container">
            <div class="billing_details">
                <form action="{{ route('checkout-store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-lg-8">
                            <h3>Detail Pemesanan</h3>
                            <div class="col-md-12 form-group p_star">
                                <label for="first">Nama</label>
                                <input type="text" class="form-control" id="first" readonly
                                    value="{{ auth()->user()->name }}" />
                            </div>
                            <input type="hidden" value="{{ $produk->id }}" name="produk_id">
                            <div class="col-md-12 form-group p_star">
                                <label for="number">No. Telepon</label>
                                <input type="number" class="form-control" readonly id="number" required
                                    value="{{ auth()->user()->notelp }}" />
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" readonly id="email" required
                                    value="{{ auth()->user()->email }}" />
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <label for="add1">Alamat</label>
                                <input type="text" class="form-control" readonly id="add1" required
                                    value="{{ auth()->user()->alamat }}" />
                            </div>
                            <div class="row ml-1 mt-3">
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="add1" required readonly
                                        value="{{ $produk->nama }}" />
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="genric-btn info-border medium add_row mt-2">Tambah
                                    </button>
                                </div>
                            </div>
                            <div id="pesanan_container">
                                <div class="pesanan_row row ml-1 mt-3">
                                    <div class="col-md-4">
                                        <div class="input-group-icon mt-10 form-group">
                                            <div class="icon"><i class="fa fa-paint-brush" aria-hidden="true"></i></div>
                                            <div class="form-select" id="default-select">
                                                <select required name="color_id[]" class="color_select">
                                                    <option value="" selected>Pilih Warna</option>
                                                    @foreach ($warna as $item)
                                                        <option value="{{ $item->color->id }}">
                                                            {{ $item->color->name_color }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group-icon mt-10 form-group">
                                            <div class="icon"><i class="fa fa-paint-brush" aria-hidden="true"></i></div>
                                            <div class="form-select" id="default-select">
                                                <select required name="ukuran_id[]" class="ukuran_select">
                                                    <option value="" selected>Pilih Ukuran</option>
                                                    @foreach ($ukuran as $item)
                                                        <option value="{{ $item->ukuran->id }}">
                                                            {{ $item->ukuran->ukuran }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group-icon mt-10 form-group">
                                            <input type="number" required name="qty[]" placeholder="Qty"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-1 mt-3">
                                        <button type="button"
                                            class="genric-btn danger-border medium remove_row">Hapus</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="input-group-icon mt-10 form-group">
                                    <div class="icon"><i class="fa fa-truck" aria-hidden="true"></i></div>
                                    <div class="form-select" id="default-select">
                                        <select required name="pengiriman" id="pengiriman_select">
                                            <option value="pengiriman">Pengiriman
                                            </option>
                                            <option value="ambil sendiri">Ambil Sendiri
                                            </option>
                                        </select>
                                    </div>
                                    <small class="ml-2"> Note: Jika pesanan anda memilih untuk dikirim maka akan terkena
                                        biaya tambahan untuk ongkos kirim</small>
                                </div>
                            </div>
                            <div class="col-md-10" id="biaya_pengiriman" style="display: none;">
                                <div class="input-group-icon mt-10 form-group">
                                    <div class="icon"><i class="fa fa-truck" aria-hidden="true"></i></div>
                                    <div class="form-select" id="default-select">
                                        <select name="pengiriman_id">
                                            <option value="" selected>Pilih Pengiriman</option>
                                            @foreach ($pengiriman as $item)
                                                <option value="{{ $item->id }}">{{ $item->alamat }} -
                                                    {{ $item->alamat_tujuan }} - {{ $item->jasa_ekspedisi }} -
                                                    {{ $item->harga_ongkir }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="message">Detail Alamat</label>
                                <textarea class="form-control" name="detail_alamat" id="message" rows="3" required
                                    placeholder="Tambah detail alamat anda"></textarea>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="message">Detail Pesanan</label>
                                <textarea class="form-control" required name="detail_pesanan" id="message" rows="3"
                                    placeholder="Detail pesanan"></textarea>
                            </div>
                            <div class="col-md-2 ml-1">
                                <button type="button" id="cekButton"
                                    class="genric-btn success-border remove_row">Cek</button>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="order_box">
                                <h2>Pesanan Anda</h2>
                                <ul class="list">
                                    <li>
                                        <a href="#">Produk
                                            <span>Total</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="d-flex flex-column">{{ $produk->nama }}
                                            <span class="last">Rp.
                                                {{ number_format($produk->harga, 0, ',', '.') }}</span>
                                        </a>
                                    </li>
                                </ul>
                                <div id="order_summary" class="mt-2"></div>
                                <ul class="list list_2">
                                    <li>
                                        <a href="#">Total <span id="totalPrice">Rp.
                                                {{ number_format($produk->harga, 0, ',', '.') }}</span></a>
                                    </li>
                                </ul>
                                <input type="hidden" id="grandTotalInput" name="grand_total">
                                <div class="payment_item">
                                    <div class="form-group mt-2">
                                        <label for="bukti" style="font-size: 12px">Upload Bukti pembayaran</label>
                                        <input type="file" class="form-control" id="bukti" required
                                            name="bukti" />
                                    </div>
                                    @foreach ($bank as $item)
                                        <p>{{ $item->nama }} = {{ $item->no_rekening }}</p>
                                    @endforeach
                                    <p>
                                        Silahkan lakukan pembayaran dengan DP 50% atau bisa langsung melunasi total harga
                                        agar
                                        pesanan segera diproses
                                    </p>
                                </div>
                                <button type="submit" class="btn_3"">Pesan Sekarang</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--================End Checkout Area =================-->
@endsection
