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
                            <h2>Informasi Kontak</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider Area End-->

    <section class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title">Lokasi Sentral Konveksi Jember</h2>
                </div>
                <div class="col-lg-8">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3948.576195105372!2d113.55759037746279!3d-8.245298870613963!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd68f61e3b19c2d%3A0x6eb0907207cf4a9a!2sSentral%20Garment!5e0!3m2!1sen!2sid!4v1716658296828!5m2!1sen!2sid"
                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-home"></i></span>
                        <div class="media-body">
                            <h3>Krajan Lor,RT 5 RW 1, Desa Gumelar, Kecamatan Balung,</h3>
                            <p>Jember, Jawa Timur</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                        <div class="media-body">
                            <h3>WhatsApp</h3>
                            <p><a href="https://wa.me/6283853494485" style="color: black; text-decoration: none;">083853494485</a></p>
                        </div>
                    </div>
                    
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-email"></i></span>
                        <div class="media-body">
                            <h3>sentralkonveksijember@gmail.com</h3>
                            <p>Kirim masukan anda kapanpun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
