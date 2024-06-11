@extends('dashboard.user.dashboard')
@section('title-user')
    Pesanan
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}" />
@endpush
@section('user')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Tabel Pesanan</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Produk</th>
                            <th>Harga Produk</th>
                            <th>Qty</th>
                            <th>Total Harga</th>
                            <th>Status Pemesanan</th>
                            <th>Tanggal Pesan</th>
                            <th>Status</th>
                            <th>Status Pembayaran</th>
                            <th>Status Pelunasan</th>
                            <th>Cek Nota</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pesanan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $item->produk->nama }}
                                </td>
                                <td>
                                    Rp. {{ number_format($item->produk->harga, 0, ',', '.') }}
                                </td>
                                <td>
                                    {{ $item->qty }}
                                </td>
                                <td>
                                    Rp. {{ number_format($item->grand_total, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if ($item->pengiriman === 'ambil sendiri')
                                        <div class="badge badge-pill bg-light-warning">
                                            Ambil Sendiri
                                        </div>
                                    @else
                                        <div class="badge badge-pill bg-light-warning">
                                            Dikirim
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}
                                </td>
                                <td>
                                    @if ($item->status === 'menunggu konfirmasi')
                                        <div class="badge badge-pill bg-light-warning">
                                            Menunggu Konfimasi Admin
                                        </div>
                                    @elseif ($item->status === 'proses')
                                        <div class="badge badge-pill bg-light-warning">
                                            Dalam Proses Produksi
                                        </div>
                                    @elseif ($item->status === 'dalam pengiriman')
                                        <div class="badge badge-pill bg-light-warning">
                                            Dalam Proses Pengiriman
                                        </div>
                                    @else
                                        <div class="badge badge-pill bg-light-success">
                                            Selesai
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status_pembayaran === 'belum_bayar')
                                        <div class="badge badge-pill bg-light-warning">
                                            Menunggu Konfimasi Admin
                                        </div>
                                    @else
                                        <div class="badge badge-pill bg-light-success">
                                            {{ $item->status_pembayaran }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status_pembayaran === 'dp' && is_null($item->bukti_pelunasan))
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#pelunasan{{ $item->id }}"><i class="bi bi-edit"></i>Upload
                                            bukti
                                            pelunasan</button>
                                    @elseif (!is_null($item->bukti_pelunasan))
                                        <p>Sudah Upload Bukti</p>
                                    @else
                                        <p>Tidak perlu melakukan pelunasan</p>
                                    @endif
                                </td>
                                <td>
                                    {{-- @if ($item->status_pembayaran === 'dp') --}}
                                    <button class="btn icon btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#nota{{ $item->id }}"><i class="bi bi-receipt"></i></button>
                                    {{-- @endif --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- modal bukti --}}
    @foreach ($pesanan as $item)
        <div class="modal fade text-left" id="nota{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" data-bs-backdrop="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Nota</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="qrCodeImage" src="{{ asset('nota/' . $item->qr_code) }}" alt="" height="200px"
                            width="200px">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tutup</span>
                        </button>
                        <button type="button" class="btn btn-primary ms-1" onclick="downloadQR()">
                            <i class="bx bx-download d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Simpan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- modal bukti pelunasan --}}
    @foreach ($pesanan as $item)
        <div class="modal fade text-left" id="pelunasan{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" data-bs-backdrop="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Bukti Pelunasan</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form action="{{ route('pemesanan-user-pelunasan', $item->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="first-name-vertical">Upload Bukti Pelunasan</label>
                                <input type="file" id="first-name-vertical" required class="form-control" required
                                    name="bukti_pelunasan" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Tutup</span>
                            </button>
                            <button type="submit" class="btn btn-primary ms-1">
                                <i class="bx bx-download d-block d-sm-none"></i>
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
    <script>
        function downloadQR() {
            // Get the image element
            var qrCodeImage = document.getElementById('qrCodeImage');
            // Create a link element
            var link = document.createElement('a');
            // Set the href attribute of the link to the image source
            link.href = qrCodeImage.src;
            // Set the download attribute to force download
            link.download = 'nota_qrcode.png';
            // Simulate a click on the link
            link.click();
        }
    </script>
@endpush
