@extends('layouts.main')
@section('title')
    Laporan Pesanan
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}" />
@endpush
@section('container')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Laporan Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Tanggal Mulai</label>
                        <input type="date" id="start_date" class="form-control datepicker" placeholder="Tanggal Mulai">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" id="end_date" class="form-control datepicker" placeholder="Tanggal Akhir">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button class="btn btn-primary" id="filterButton">Filter</button>
                    </div>
                    <div class="col-md-1 d-flex align-items-end ms-auto">
                        <button class="btn btn-success">Export</button>
                    </div>
                </div>
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Pesanan</th>
                            <th>Detail Pesanan</th>
                            <th>Total Harga</th>
                            <th>Tanggal Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pesanan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->produk->nama }} x {{ $item->qty }}</td>
                                <td>
                                    @foreach ($item->detailPesanan as $detail)
                                        <div>{{ $detail->color->name_color }} / {{ $detail->ukuran->ukuran }} x
                                            {{ $detail->qty }}
                                        </div>
                                    @endforeach
                                </td>
                                <td>Rp. {{ number_format($item->produk->harga * $item->qty, 0, ',', '.') }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/simple-datatables.js') }}"></script>
@endpush
