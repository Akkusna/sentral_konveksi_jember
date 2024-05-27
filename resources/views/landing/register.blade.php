@extends('layouts.app')
@section('content')
    <div class="container-fluid p-5">

        <div class="row px-xl-5">
            <div class="col-lg-5 col-md-12 text-center"><img src="assets/img/logo-rbg.png" alt="">
                <a href="" class="text-decoration-none">
                    <h1 class="mb-4 display-5 font-weight-semi-bold text-dark"><span
                            class="text-primary font-weight-bold border px-3 mr-2">KONVEKSI</span>Jember</h1>
                </a>
            </div>
            <div class="col-lg-7 col-md-12 border p-5">
                <h1 class="font-weight-bold text-dark mb-4 text-center">Register</h5>
                    <form action="{{ route('register.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <input type="text" name="name" class="form-control border py-4 mt-5"
                                placeholder="Nama Lengkap" required="required" />
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control border py-4" placeholder="Email"
                                required="required" />
                        </div>
                        <div class="form-group">
                            <input type="number" name="notelp" class="form-control border py-4" placeholder="No. Telepon"
                                required="required" />
                        </div>
                        <div class="form-group">
                            <input type="text" name="alamat" class="form-control border py-4" placeholder="Alamat"
                                required="required" />
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control border py-4" placeholder="Password"
                                required="required" />
                        </div>
                        <div class="mt-5 mb-5 mr-3 text-right">
                            <a class="text-dark">Lupa password ?</a>
                        </div>
                        <div>
                            <button class="btn btn-primary btn-block border py-3" type="submit">Register
                            </button>
                        </div>
                    </form>
            </div>
        </div>

    </div>
@endsection
