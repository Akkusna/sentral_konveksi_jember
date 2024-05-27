@extends('layouts.main')
@section('title')
    Laporan Bahan Baku
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}" />
@endpush
@section('container')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Laporan Bahan Baku</h5>
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
                            <th>Bahan Baku</th>
                            <th>Harga per meter</th>
                            <th>Jumlah Masuk</th>
                            <th>Total Harga</th>
                            <th>Jumlah Digunakan</th>
                            <th>Sisa Bahan</th>
                            <th>Tanggal beli</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bahan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>Rp. {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td>{{ $item->transaksiMasuk->sum('qty') }} meter</td>
                                <td>Rp. {{ number_format($item->harga * $item->transaksiMasuk->sum('qty'), 0, ',', '.') }}
                                </td>
                                <td>{{ $item->transaksiKeluar->sum('qty') }} meter</td>
                                <td>{{ $item->qty }}</td>
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
