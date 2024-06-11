@extends('layouts.main')
@section('title')
    Produk
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">
@endpush
@section('container')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Table Produk</h5>
                <button class="btn btn-primary float-end me-3" data-bs-toggle="modal" data-bs-target="#add">Tambah</button>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Foto</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Kategori</th>
                            <th>Daftar Warna</th>
                            <th>Daftar Ukuran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produk as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>
                                    <img src="{{ asset('foto/product/' . $item->image) }}" height="50" width="50"
                                        alt="Product Image">
                                </td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>{{ $item->formatRupiah('harga') }}</td>
                                <td>{{ $item->kategori->nama }}</td>
                                <td>
                                    @foreach ($item->produkColor as $detail)
                                        <a class="btn disable"
                                            style="background: {{ $detail->color->code_color }}">{{ $detail->color->code_color }}</a>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($item->produkUkuran as $detail)
                                        {{ $detail->ukuran->ukuran }},
                                    @endforeach
                                </td>
                                <td>
                                    <button class="btn icon btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#update{{ $item->id }}"><i class="bi bi-pencil"></i></button>
                                    <button class="btn icon btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#delete{{ $item->id }}"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- modal add --}}
    <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollable"
        data-bs-backdrop="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" style="display: block;" aria-modal="true" role="dialog">
            <form action="{{ route('produk.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                @method('POST')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Tambah Produk</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>

                    <div class="modal-body" style="overflow-y: auto;">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" id="nama" required class="form-control" name="nama"
                                placeholder="Nama Produk" />
                        </div>
                        <div class="form-group">
                            <label for="desc">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="desc" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="formFile" class="form-label">Upload gambar produk</label>
                            <input class="form-control" type="file" name="image" id="formFile">
                        </div>
                        <fieldset class="form-group">
                            <label for="kategori">Pilih Kategori</label>
                            <select class="form-select" id="kategori" name="kategori_id" required>
                                <option value="" selected disabled>Pilih Kategori</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </fieldset>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input type="number" id="harga" required class="form-control" name="harga"
                                placeholder="Harga" />
                        </div>
                        <div class="form-group">
                            <label for="colors">Pilih Warna</label>
                            <select class="choices form-select multiple-remove" id="colors" multiple="multiple"
                                name="color[]">
                                <optgroup label="Colors">
                                    @foreach ($color as $Colorsitem)
                                        <option value="{{ $Colorsitem->id }}">
                                            {{ $Colorsitem->name_color }}
                                            <span class="badge" style="background: {{ $Colorsitem->code_color }}"></span>
                                        </option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="ukuran">Pilih Ukuran</label>
                            <select class="choices form-select multiple-remove" id="ukuran" multiple="multiple"
                                name="ukuran[]">
                                <optgroup label="Ukuran">
                                    @foreach ($ukuran as $itemUkuran)
                                        <option value="{{ $itemUkuran->id }}">
                                            {{ $itemUkuran->ukuran }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                        <div class="form-check m-3">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="form-check-input form-check-primary form-check-glow"
                                    name="customCheck" id="checkboxGlow1">
                                <label class="form-check-label" for="checkboxGlow1">Tersedia ukuran lengan</label>
                            </div>
                        </div>
                        <!-- Hidden input untuk nilai lengan -->
                        <input type="hidden" name="lengan" id="lengan" value="0">
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
                    {{-- </form> --}}
                </div>
            </form>
        </div>
    </div>

    {{-- modal edit --}}
    @foreach ($produk as $produkItem)
        <div class="modal fade text-left" id="update{{ $produkItem->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLongTitle" data-bs-backdrop="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <form action="{{ route('produk.update', $produkItem->id) }}" enctype="multipart/form-data"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel1">Tambah Produk</h5>
                            <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" id="nama" required class="form-control" name="nama"
                                    value="{{ $produkItem->nama }}" placeholder="Nama Produk" />
                            </div>
                            <div class="form-group">
                                <label for="desc">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" id="desc" rows="3">{{ $produkItem->deskripsi }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="formFile" class="form-label">Upload gambar produk</label>
                                <input class="form-control" type="file" name="image" id="formFile">
                            </div>
                            <fieldset class="form-group">
                                <label for="kategori">Pilih Kategori</label>
                                <select class="form-select" id="kategori" name="kategori_id" required>
                                    <option value="" disabled>Pilih Kategori</option>
                                    @foreach ($kategori as $kategoriItem)
                                        <option value="{{ $kategoriItem->id }}"
                                            {{ $produkItem->kategori_id == $kategoriItem->id ? 'selected' : '' }}>
                                            {{ $kategoriItem->nama }}
                                        </option>
                                    @endforeach
                                </select>

                            </fieldset>
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="number" id="harga" required class="form-control" name="harga"
                                    value="{{ $produkItem->harga }}" placeholder="Harga" />
                            </div>
                            <div class="form-group">
                                <label for="colors">Pilih Warna</label>
                                @php
                                    $selectedColors = [];

                                    $selectedColorIds = $produkItem->produkColor->pluck('color_id')->toArray();

                                    foreach ($color as $colorItem) {
                                        if (in_array($colorItem->id, $selectedColorIds)) {
                                            $selectedColors[] = $colorItem->id;
                                        }
                                    }
                                @endphp
                                <select class="choices form-select multiple-remove" id="colors" multiple="multiple"
                                    name="color[]">
                                    <optgroup label="Colors">
                                        @foreach ($color as $colorItem)
                                            <option value="{{ $colorItem->id }}"
                                                {{ in_array($colorItem->id, $selectedColors) ? 'selected' : '' }}>
                                                {{ $colorItem->name_color }}
                                                <span class="badge"
                                                    style="background: {{ $colorItem->code_color }}"></span>
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>

                            </div>
                            <div class="form-group">
                                <label for="ukuran">Pilih Ukuran</label>
                                @php
                                    // Inisialisasi variabel selectedUkuran
                                    $selectedUkuran = [];

                                    // Ambil ID ukuran yang terkait dengan produk
                                    $selectedUkuranIds = $produkItem->produkUkuran->pluck('ukuran_id')->toArray();

                                    // Periksa setiap ukuran, jika ID ukuran ada di dalam selectedUkuranIds, tambahkan ke dalam array selectedUkuran
                                    foreach ($ukuran as $itemUkuran) {
                                        if (in_array($itemUkuran->id, $selectedUkuranIds)) {
                                            $selectedUkuran[] = $itemUkuran->id;
                                        }
                                    }
                                @endphp
                                <select class="choices form-select multiple-remove" id="ukuran" multiple="multiple"
                                    name="ukuran[]">
                                    <optgroup label="Ukuran">
                                        @foreach ($ukuran as $itemUkuran)
                                            <option value="{{ $itemUkuran->id }}"
                                                {{ in_array($itemUkuran->id, $selectedUkuran) ? 'selected' : '' }}>
                                                {{ $itemUkuran->ukuran }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                            <div class="form-check m-3">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="form-check-input form-check-primary form-check-glow"
                                        name="customCheck" id="checkboxGlow1"
                                        {{ $produkItem->lengan == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="checkboxGlow1">Tersedia ukuran lengan</label>
                                </div>
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
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    {{-- modal delete --}}
    @foreach ($produk as $item)
        <div class="modal fade text-left" id="delete{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" data-bs-backdrop="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Hapus Data Produk</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form action="{{ route('produk.delete', $item->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            Apakah anda yakin untuk menghapus data ?
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
    <script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/form-element-select.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('checkboxGlow1');
            const hiddenInput = document.getElementById('lengan');

            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    hiddenInput.value = '1';
                } else {
                    hiddenInput.value = '0';
                }
            });
        });
    </script>
@endpush
