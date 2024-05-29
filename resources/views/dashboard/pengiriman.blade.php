@extends('layouts.main')
@section('title')
    Pengiriman
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}" />
@endpush
@section('container')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Tabel Pengiriman</h5>
                <button class="btn btn-primary float-end me-3" data-bs-toggle="modal" data-bs-target="#add">Tambah</button>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jasa Ekspedisi</th>
                            <th>Harga Ongkir</th>
                            <th>Alamat Pengirim</th>
                            <th>Alamat Tujuan</th>
                            <th>Tanggal Pengiriman</th>
                            <th>Estimasi</th>
                            <th>Tanggal Tiba</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengiriman as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->jasa_ekspedisi }}</td>
                                <td>
                                    Rp. {{ number_format($item->harga_ongkir, 0, ',', '.') }}
                                </td>
                                <td>{{ $item->alamat }}</td>
                                <td>{{ $item->alamat_tujuan }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($item->tanggal_pengiriman)->format('d F Y') }}
                                </td>
                                <td> {{ $item->estimasi }} </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($item->tanggal_tiba)->format('d F Y') }}
                                </td>
                                <td>
                                    <button class="btn icon btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#update{{ $item->id }}"><i class="bi bi-pencil"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- modal add --}}
    <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
        data-bs-backdrop="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel1">Tambah Data Pengiriman</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="{{ route('pengiriman.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="first-name-vertical">Jasa Ekspedisi</label>
                            <input type="text" id="first-name-vertical" required class="form-control"
                                name="jasa_ekspedisi" required />
                        </div>
                        <div class="form-group">
                            <label for="first-name-vertical">Harga Ongkir</label>
                            <input type="number" id="first-name-vertical" required class="form-control" name="harga_ongkir"
                                required />
                        </div>
                        <div class="form-group">
                            <label for="first-name-vertical">Alamat Pengirim</label>
                            <input type="test" id="first-name-vertical"
                                value="Krajan Lor,RT 5 RW 1, Desa Gumelar, Balung, Jember, Jatim" required
                                class="form-control" name="alamat" readonly required />
                        </div>
                        <div class="form-group">
                            <label for="first-name-vertical">Alamat Tujuan</label>
                            <input type="test" id="first-name-vertical" required class="form-control"
                                name="alamat_tujuan" required />
                        </div>
                        <div class="form-group">
                            <label for="first-name-vertical">Tanggal Pengiriman</label>
                            <input type="date" id="first-name-vertical" required class="form-control"
                                name="tanggal_pengiriman" required />
                        </div>
                        <div class="form-group">
                            <label for="first-name-vertical">Estimasi Sampai</label>
                            <input type="text" id="first-name-vertical" required class="form-control" name="estimasi"
                                placeholder="0 hari" required />
                        </div>
                        <div class="form-group">
                            <label for="first-name-vertical">Tanggal Tiba</label>
                            <input type="date" id="first-name-vertical" required class="form-control" name="tanggal_tiba"
                                required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tutup</span>
                        </button>
                        <button type="submit" class="btn btn-primary ms-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- modal edit --}}
    @foreach ($pengiriman as $item)
        <div class="modal fade text-left" id="update{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" data-bs-backdrop="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Tambah Data Pengiriman</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>

                    </div>
                    <form action="{{ route('pengiriman.update', $item->id) }}" method="POST">

                        @csrf

                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="first-name-vertical">Jasa Ekspedisi</label>
                                <input type="text" required class="form-control" name="jasa_ekspedisi" required
                                    value="{{ $item->jasa_ekspedisi }}" />
                            </div>
                            <div class="form-group">
                                <label for="first-name-vertical">Total Ongkir</label>
                                <input type="number" required class="form-control" name="harga_ongkir"
                                    value="{{ $item->harga_ongkir }}" required />
                            </div>
                            <div class="form-group">
                                <label for="first-name-vertical">Alamat Pengirim</label>
                                <input type="test" id="first-name-vertical"
                                    value="Krajan Lor,RT 5 RW 1, Desa Gumelar, Balung, Jember, Jatim" required
                                    class="form-control" name="alamat" value="{{ $item->alamat }}" readonly required />
                            </div>
                            <div class="form-group">
                                <label for="first-name-vertical">Alamat Tujuan</label>
                                <input type="test" id="first-name-vertical" required class="form-control"
                                    name="alamat_tujuan" value="{{ $item->alamat_tujuan }}" required />
                            </div>
                            <div class="form-group">
                                <label for="first-name-vertical">Tanggal Pengiriman</label>
                                <input type="date" id="first-name-vertical" required class="form-control"
                                    name="tanggal_pengiriman" value="{{ $item->tanggal_pengiriman }}" required />
                            </div>
                            <div class="form-group">
                                <label for="first-name-vertical">Estimasi Sampai</label>
                                <input type="text" id="first-name-vertical" required class="form-control"
                                    name="estimasi" placeholder="0 hari" value="{{ $item->estimasi }}" required />
                            </div>
                            <div class="form-group">
                                <label for="first-name-vertical">Tanggal Tiba</label>
                                <input type="date" id="first-name-vertical" required class="form-control"
                                    name="tanggal_tiba" value="{{ $item->tanggal_tiba }}" required />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Tutup</span>
                            </button>
                            <button type="submit" class="btn btn-primary ms-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Simpan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@push('scripts')
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/simple-datatables.js') }}"></script>
@endpush
