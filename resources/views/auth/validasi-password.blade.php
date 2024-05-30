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
                            <h2>Reset Password</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider Area End-->
    <!--================login_part Area =================-->
    <section class="login_part section_padding ">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="login_part_text text-center">
                        <div class="login_part_text_iner">
                            <h2>Reset Password</h2>
                            <p>Silahkan masukan password baru anda</p>
                            {{-- <a href="/register" class="btn_3">Login</a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="login_part_form">
                        <div class="login_part_form_iner">
                            <h3>Masukan Password baru anda !
                            </h3>
                            <form class="row contact_form" action="{{ route('validasi-password-act') }}" method="post"
                                novalidate="novalidate">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="col-md-12 form-group p_star">
                                    <input type="text" class="form-control" id="password" name="password" value=""
                                        required placeholder="password">
                                </div>
                                <div class="col-md-12 form-group">
                                    <button type="submit" value="submit" class="btn_3">
                                        Kirim
                                    </button>
                                    {{-- <a class="lost_pass" href="#">forget password?</a> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================login_part end =================-->
@endsection
