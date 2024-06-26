<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Gaya teks pada navbar */
        #navigation li a {
            color: black;
            /* Warna teks default */
            text-decoration: none;
            /* Hilangkan garis bawah */
            transition: color 0.3s;
            /* Efek transisi saat mengubah warna */
        }

        /* Gaya teks pada navbar saat kursor diarahkan */
        #navigation li a:hover {
            color: rgb(9, 9, 251);
            /* Ubah warna teks menjadi biru dongker saat kursor diarahkan */
        }
    </style>
</head>

<body>
    <header>
        <!-- Header Start -->
        <div class="header-area">
            <div class="main-header ">
                <div class="header-top top-bg d-none d-lg-block">
                    <div class="container-fluid">
                        <div class="col-xl-12" style="height: 30px">
                            <div class="row d-flex align-items-end justify-content-end">
                                <div class="header-info-right">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="header-bottom  header-sticky">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <!-- Logo -->
                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('home') }}">
                                        <img src="{{ asset('assets/img/logo_fix.png') }}" height="80px" alt="">
                                    </a>
                                    <div class="ms-2 d-flex flex-column">
                                        <h2 class="mb-0" style="margin-bottom: 0;">Sentral</h2>
                                        <small class="mb-0" style="margin-top: -5px;">Konveksi Jember</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12">
                                <!-- Main-menu -->
                                <div class="main-menu f-right d-none d-lg-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a href="/">Home</a></li>
                                            <li><a class="hot" href="/category-landing">Katalog Produk</a></li>
                                            <li><a href="/contact">Informasi Kontak</a></li>
                                            @if (auth()->check() && auth()->user()->is_admin == 0)
                                                <li> <a href="{{ route('dashboard-user') }}"
                                                        class="btn header-btn text-white text-center"
                                                        style="display: flex">Pesanan Saya</a>
                                                </li>
                                            @else
                                                <li> <a href="{{ route('login') }}"
                                                        class="btn header-btn text-white text-center"
                                                        style="display: flex;">Login atau Daftar</a>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-3 col-md-3 col-sm-3 fix-card">
                                {{-- <ul class="header-right f-right d-none d-lg-block d-flex justify-content-between">
                                    @if (auth()->check() && auth()->user()->is_admin == 0)
                                        <li class="d-none d-lg-block"> <a href="{{ route('dashboard-user') }}"
                                                class="btn header-btn">Pesanan Saya</a>
                                        </li>
                                    @else
                                        <li class="d-none d-lg-block"> <a href="{{ route('login') }}"
                                                class="btn header-btn">Login</a>
                                        </li>
                                    @endif
                                </ul> --}}
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
</body>

</html>
