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
                        <button class="btn btn-success" id="exportButton">Export</button>
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
                                <td>Rp. {{ number_format($item->produk->harga * $item->qty, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}</td>
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
    <script>
        document.getElementById('filterButton').addEventListener('click', function() {
            let startDate = document.getElementById('start_date').value;
            let endDate = document.getElementById('end_date').value;
            let table = document.getElementById('table1');
            let rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                let cell = rows[i].getElementsByTagName('td')[5];
                let dateText = cell.textContent || cell.innerText;
                let rowDate = new Date(dateText);
                let start = new Date(startDate);
                let end = new Date(endDate);

                // Compare the dates correctly
                if (startDate && endDate) {
                    if (rowDate >= start && rowDate <= end) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                } else if (startDate) {
                    if (rowDate >= start) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                } else if (endDate) {
                    if (rowDate <= end) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                } else {
                    rows[i].style.display = '';
                }
            }
        });

        document.getElementById('exportButton').addEventListener('click', function() {
            let startDate = document.getElementById('start_date').value;
            let endDate = document.getElementById('end_date').value;
            let url = '{{ route('export.excel') }}';
            if (startDate || endDate) {
                url += '?start_date=' + startDate + '&end_date=' + endDate;
            }
            window.location.href = url;
        });
    </script>
@endpush
