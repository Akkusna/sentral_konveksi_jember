@extends('dashboard.user.dashboard')
@section('title-user')
    Pengiriman
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}" />
@endpush
@section('user')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Tabel Pengiriman</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pesanan</th>
                            <th>Total Harga</th>
                            <th>Tanggal Pengiriman</th>
                            <th>Estimasi</th>
                            <th>Tanggal Tiba</th>
                            <th>Status</th>
                            <th>Jenis Ekspedisi</th>
                            <th>Harga Ongkir</th>
                            <th>Pesanan telah diterima</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengiriman as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $item->pesanan->produk->nama }} x {{ $item->pesanan->qty }}
                                </td>
                                <td>
                                    Rp. {{ number_format($item->pesanan->grand_total, 0, ',', '.') }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($item->tanggal_pengiriman)->format('d F Y') }}
                                </td>
                                <td>
                                    {{ $item->estimasi }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($item->tanggal_tiba)->format('d F Y') }}
                                </td>
                                <td>
                                    @if ($item->status === 'sampai')
                                        <div class="badge badge-pill bg-light-success">
                                            Telah Diterima
                                        </div>
                                    @elseif ($item->status === 'proses')
                                        <div class="badge badge-pill bg-light-warning">
                                            Dalam Proses Pengiriman
                                        </div>
                                    @else
                                        <div class="badge badge-pill bg-light-warning">
                                            Dalam Perjalanan
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    {{ $item->pesanan->jasa_ekspedisi }}
                                </td>
                                <td>
                                    Rp. {{ number_format($item->pesanan->harga_ongkir, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if ($item->status === 'sampai')
                                        <button class="btn icon btn-secondary" disabled"><i class="bi bi-check-lg"></i>
                                            Selesai</button>
                                    @else
                                        <button class="btn icon btn-success" data-bs-toggle="modal"
                                            data-bs-target="#acc{{ $item->id }}"><i class="bi bi-check-lg"></i>
                                            Selesai</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    {{-- modal terima --}}
    @foreach ($pengiriman as $item)
        <div class="modal fade text-left" id="acc{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" data-bs-backdrop="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Paket telah diterima</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form action="{{ route('pengiriman-user-acc', $item->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            Apakah paket anda telah diterima ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Tutup</span>
                            </button>
                            <button type="submit" class="btn btn-primary ms-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Ya</span>
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
