@extends('layouts.main')
@section('title')
    Kategori
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}" />
@endpush
@section('container')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Tabel Kategori</h5>
                <button class="btn btn-primary float-end me-3" data-bs-toggle="modal" data-bs-target="#add">Tambah</button>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategori as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
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
    <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
        data-bs-backdrop="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel1">Tambah Data Kategori</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="{{ route('kategori.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="first-name-vertical">Nama Kategori</label>
                            <input type="text" id="first-name-vertical" required class="form-control" name="nama"
                                placeholder="First Name" />
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
    @foreach ($kategori as $item)
        <div class="modal fade text-left" id="update{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" data-bs-backdrop="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Edit Data Kategori</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form action="{{ route('kategori.update', $item->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="modal-body">
                            <div class="form-group">
                                <label for="first-name-vertical">Nama Kategori</label>
                                <input type="text" id="first-name-vertical" required value="{{ $item->nama }}"
                                    class="form-control" name="nama" placeholder="First Name" />
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

    {{-- modal delete --}}
    @foreach ($kategori as $item)
        <div class="modal fade text-left" id="delete{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" data-bs-backdrop="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Hapus Data Kategori</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form action="{{ route('kategori.delete', $item->id) }}" method="post">
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
@endpush
