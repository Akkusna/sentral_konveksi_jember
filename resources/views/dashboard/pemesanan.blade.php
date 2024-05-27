@extends('layouts.main')
@section('title')
    Pesanan
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}" />
@endpush
@section('container')
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
                            <th>Nama Pelanggan</th>
                            <th>Produk</th>
                            <th>Harga Produk</th>
                            <th>Qty</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Status Pemesanan</th>
                            <th>Bukti Pembayaran</th>
                            <th>Bukti Pelunasan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pesanan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->user->name }}</td>
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
                                    {{ $item->status }}
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
                                    <button class="btn icon btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#bukti{{ $item->id }}"><i class="bi bi-receipt"></i></button>
                                </td>
                                <td>
                                    @if ($item->status_pembayaran === 'dp' && !is_null($item->bukti_pelunasan))
                                        <button class="btn icon btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#pelunasan{{ $item->id }}"><i
                                                class="bi bi-receipt"></i></button>
                                    @else
                                        <p>-</p>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn icon btn-info" data-bs-toggle="modal"
                                        data-bs-target="#info{{ $item->id }}"><i
                                            class="bi bi-info-circle"></i></button>
                                    <button class="btn icon btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#update{{ $item->id }}"><i class="bi bi-pencil"></i></button>
                                    <button class="btn icon btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#bahan{{ $item->id }}"><i class="bi bi-box-seam"></i></button>
                                    @if ($item->status === 'selesai')
                                        <a href="{{ route('pesanan-nota', ['id' => $item->id]) }}"
                                            class="btn icon btn-danger" target="_blank">
                                            <i class="bi bi-receipt"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- modal info --}}
    @foreach ($pesanan as $item)
        <div class="modal fade text-left" id="info{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" data-bs-backdrop="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-full" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Info Detail Pesanan</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first-name-vertical">Nama Pelanggan</label>
                                    <input type="text" id="first-name-vertical" required value="{{ $item->user->name }}"
                                        class="form-control" readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first-name-vertical">No Telepon Pelanggan</label>
                                    <input type="text" id="first-name-vertical" required
                                        value="{{ $item->user->notelp }}" class="form-control" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first-name-vertical">Alamat Pelanggan</label>
                                    <input type="text" id="first-name-vertical" required
                                        value="{{ $item->user->alamat }}" class="form-control" readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first-name-vertical">Detail Alamat</label>
                                    <input type="text" id="first-name-vertical" required
                                        value="{{ $item->detail_alamat }}" class="form-control" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first-name-vertical">Produk</label>
                                    <input type="text" id="first-name-vertical" required
                                        value="{{ $item->produk->nama }}" class="form-control" readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first-name-vertical">Harga Produk</label>
                                    <input type="text" id="first-name-vertical" required
                                        value="Rp. {{ number_format($item->produk->harga, 0, ',', '.') }}"
                                        class="form-control" readonly />
                                </div>
                            </div>
                        </div>
                        @foreach ($item->detailPesanan as $detail)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first-name-vertical">Warna</label>
                                        <input type="text" id="first-name-vertical" required
                                            value="{{ $detail->color->name_color }}" class="form-control" readonly />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first-name-vertical">Kode Warna</label>
                                        <input type="text" id="first-name-vertical" required
                                            value="{{ $detail->color->code_color }}" class="form-control" readonly />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first-name-vertical">Ukuran</label>
                                        <input type="text" id="first-name-vertical" required
                                            value="{{ $detail->ukuran->ukuran }}" class="form-control" readonly />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first-name-vertical">Qty</label>
                                        <input type="text" id="first-name-vertical" required
                                            value="{{ $detail->qty }}" class="form-control" readonly />
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first-name-vertical">Qty</label>
                                    <input type="text" id="first-name-vertical" required value="{{ $item->qty }}"
                                        class="form-control" readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first-name-vertical">Total Harga Produk</label>
                                    <input type="text" id="first-name-vertical" required
                                        value="Rp. {{ number_format($item->grand_total, 0, ',', '.') }}"
                                        class="form-control" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first-name-vertical">Detail Pesanan</label>
                                    <input type="text" id="first-name-vertical" required
                                        value="{{ $item->detail_pesanan }}" class="form-control" readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first-name-vertical">Status Pesanan</label>
                                    <input type="text" id="first-name-vertical" required value="{{ $item->status }}"
                                        class="form-control" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first-name-vertical">Status Pembayaran</label>
                                    <input type="text" id="first-name-vertical" required
                                        value="{{ $item->status_pembayaran }}" class="form-control" readonly />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first-name-vertical">Tanggal Pesan</label>
                                    <input type="text" id="first-name-vertical" required
                                        value="{{ $item->created_at }}" class="form-control" readonly />
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tutup</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- modal bukti --}}
    @foreach ($pesanan as $item)
        <div class="modal fade text-left" id="bukti{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" data-bs-backdrop="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Info Pembayaran</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('foto/bukti/' . $item->bukti) }}" alt="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tutup</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- modal bukti --}}
    @foreach ($pesanan as $item)
        <div class="modal fade text-left" id="pelunasan{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" data-bs-backdrop="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Info Pelunasan Pembayaran</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset('foto/bukti/' . $item->bukti_pelunasan) }}" alt="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tutup</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    {{-- modal update --}}
    @foreach ($pesanan as $item)
        <div class="modal fade text-left" id="update{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" data-bs-backdrop="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Edit Data Pesanan</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form action="{{ route('pesanan-update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <fieldset class="form-group">
                                <label for="basicSelect">Status Pembayaran</label>
                                <select name="status_pembayaran" class="form-select" id="basicSelect">
                                    <option value="lunas" {{ $item->status_pembayaran == 'lunas' ? 'selected' : '' }}>
                                        Lunas</option>
                                    <option value="dp" {{ $item->status_pembayaran == 'dp' ? 'selected' : '' }}>Dp 50%
                                    </option>
                                </select>
                            </fieldset>
                            <fieldset class="form-group">
                                <label for="basicSelect">Status Pesanan</label>
                                <select name="status" class="form-select" id="basicSelect">
                                    <option value="menunggu konfirmasi"
                                        {{ $item->status == 'menunggu konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi
                                    </option>
                                    <option value="proses" {{ $item->status == 'proses' ? 'selected' : '' }}>Proses
                                    </option>
                                    <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>Selesai
                                    </option>
                                </select>
                            </fieldset>
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

    {{-- modal bahan --}}
    {{-- modal bahan --}}
    @foreach ($pesanan as $item)
        <div class="modal fade text-left" id="bahan{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" data-bs-backdrop="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Bahan Baku</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form action="{{ route('pesanan.bahan-baku.store-or-update') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="pesanan_id" value="{{ $item->id }}">
                            <div id="bahan-baku-container-{{ $item->id }}">
                                @php
                                    $existingBahanBakus = $item->detailPesananBahanBaku;
                                @endphp

                                @forelse ($existingBahanBakus as $detail)
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label for="bahan_baku_id" class="form-label">Bahan Baku</label>
                                            <select name="bahan_baku_id[]" class="form-select" required>
                                                @foreach ($bahan as $b)
                                                    <option value="{{ $b->id }}"
                                                        {{ $b->id == $detail->bahan_baku_id ? 'selected' : '' }}>
                                                        {{ $b->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <label for="qty" class="form-label">Quantity</label>
                                            <input type="number" name="qty[]" class="form-control" required
                                                min="1" value="{{ $detail->qty }}">
                                        </div>
                                        <div class="col-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-remove-field">-</button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label for="bahan_baku_id" class="form-label">Bahan Baku</label>
                                            <select name="bahan_baku_id[]" class="form-select" required>
                                                @foreach ($bahan as $b)
                                                    <option value="{{ $b->id }}">{{ $b->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <label for="qty" class="form-label">Quantity</label>
                                            <input type="number" name="qty[]" class="form-control" required
                                                min="1">
                                        </div>
                                        <div class="col-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-suc cess btn-add-field">+</button>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-add-field').forEach(function(button) {
                button.addEventListener('click', function() {
                    const modalId = button.closest('.modal').id;
                    const container = document.getElementById('bahan-baku-container-' + modalId
                        .split('bahan')[1]);
                    const newField = document.createElement('div');
                    newField.classList.add('row', 'mb-3');

                    newField.innerHTML = `
                    <div class="col-6">
                        <select name="bahan_baku_id[]" class="form-select" required>
                            @foreach ($bahan as $b)
                                <option value="{{ $b->id }}">{{ $b->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <input type="number" name="qty[]" class="form-control" required min="1">
                    </div>
                    <div class="col-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-remove-field">-</button>
                    </div>
                `;

                    container.appendChild(newField);

                    newField.querySelector('.btn-remove-field').addEventListener('click',
                        function() {
                            newField.remove();
                        });
                });
            });

            document.querySelectorAll('.btn-remove-field').forEach(function(button) {
                button.addEventListener('click', function() {
                    button.closest('.row').remove();
                });
            });
        });
    </script>
@endpush
