@extends('dashboard.user.dashboard')
@section('title-user')
    Profile
@endsection
@section('user')
    <section class="section">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="media d-flex align-items-center">
                            <div class="avatar bg-warning me-3">
                                <span class="avatar-content">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                                <span class="avatar-status bg-success"></span>
                            </div>
                            <div class="name flex-grow-1">
                                <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                <span class="text-xs">User</span>
                            </div>
                            {{-- <button class="btn icon btn-primary">
                                <i class="bi bi-pencil-square"></i>
                            </button> --}}
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true">Informasi Akun</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                                    aria-controls="profile" aria-selected="false">Password</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <h5 class="mt-4">Edit data User</h5>
                                <form class="mt-4" action="{{ route('user-update-profile') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="first-name-vertical">Nama</label>
                                        <input type="text" id="first-name-vertical" value="{{ Auth::user()->name }}"
                                            required class="form-control" name="name" />
                                    </div>
                                    <div class="form-group">
                                        <label for="first-name-vertical">Email</label>
                                        <input type="email" id="first-name-vertical" value="{{ Auth::user()->email }}"
                                            required class="form-control" name="email" />
                                    </div>
                                    <div class="form-group">
                                        <label for="first-name-vertical">No. Telepon</label>
                                        <input type="number" id="first-name-vertical" required class="form-control"
                                            name="notelp" value="{{ Auth::user()->notelp }}" />
                                    </div>
                                    <div class="form-group">
                                        <label for="first-name-vertical">Alamat</label>
                                        <input type="text" id="first-name-vertical" required class="form-control"
                                            name="alamat" value="{{ Auth::user()->alamat }}" />
                                    </div>
                                    <button type="submit" class="btn btn-primary ms-1 float-end mt-2">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Simpan Perubahan</span>
                                    </button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <h5 class="mt-4">Edit password User</h5>
                                <form class="mt-4" action="{{ route('user-update-password') }} " method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="first-name-vertical">Password Baru</label>
                                        <input type="text" id="first-name-vertical" required class="form-control"
                                            name="new_password" />
                                    </div>
                                    <div class="form-group">
                                        <label for="first-name-vertical">Konfirmasi Password Baru</label>
                                        <input type="text" id="first-name-vertical" required class="form-control"
                                            name="confirm_password" />
                                    </div>
                                    <button type="submit" class="btn btn-primary ms-1 float-end mt-2">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Simpan Perubahan</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
