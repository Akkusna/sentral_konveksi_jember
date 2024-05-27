@extends('layouts.main')
@section('title')
    Warna
@endsection
@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/monolith.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/nano.min.css" />
@endpush
@section('container')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Tabel Warna</h5>
                <button class="btn btn-primary float-end me-3" data-bs-toggle="modal" data-bs-target="#add">Tambah</button>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Warna</th>
                            <th>Warna</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($colors as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name_color }}</td>
                                <td>
                                    <a class="btn"
                                        style="background: {{ $item->code_color }}">{{ $item->code_color }}</a>
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
    <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
        data-bs-backdrop="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel1">Tambah Data Warna</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="{{ route('colors.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="first-name-vertical">Nama Warna</label>
                            <input type="text" id="first-name-vertical" required class="form-control" name="name_color"
                                placeholder="First Name" />
                        </div>
                        <div class="form-group">
                            <label for="color">Pilih Warna</label>
                            <div class="input-group">
                                <div class="me-2">
                                    <div class="color-picker" id="color"></div>
                                </div>
                                <input type="text" id="color_hex" required name="code_color" class="form-control" />
                            </div>
                        </div>
                        <div class="card-body px-4 py-5" style="background: #ffff;" id="panel"></div>
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
    @foreach ($colors as $item)
        <div class="modal fade text-left" id="update{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" data-bs-backdrop="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Edit Data Warna</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form action="{{ route('colors.update', $item->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="first-name-vertical">Nama Warna</label>
                                <input type="text" id="first-name-vertical" required value="{{ $item->name_color }}"
                                    class="form-control" name="name_color" placeholder="Name" />
                            </div>
                            <div class="form-group">
                                <label for="color">Pilih Warna</label>
                                <div class="input-group">
                                    <div class="me-2">
                                        <div class="color-picker-edit" id="color_edit_{{ $item->id }}"></div>
                                    </div>
                                    <input type="text" id="color_hex_edit_{{ $item->id }}" required
                                        name="code_color" value="{{ $item->code_color }}" class="form-control" />
                                </div>
                            </div>
                            <div class="card-body px-4 py-5" style="background: {{ $item->code_color }};"
                                id="panel{{ $item->id }}"></div>
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
    @foreach ($colors as $item)
        <div class="modal fade text-left" id="delete{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" data-bs-backdrop="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Hapus Data Warna</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <form action="{{ route('colors.delete', $item->id) }}" method="post">
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
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.es5.min.js"></script>
    <script>
        const pickr = Pickr.create({
            el: '.color-picker',
            theme: 'classic',

            swatches: [
                'rgba(244, 67, 54, 1)',
                'rgba(233, 30, 99, 0.95)',
                'rgba(156, 39, 176, 0.9)',
                'rgba(103, 58, 183, 0.85)',
                'rgba(63, 81, 181, 0.8)',
                'rgba(33, 150, 243, 0.75)',
                'rgba(3, 169, 244, 0.7)',
                'rgba(0, 188, 212, 0.7)',
                'rgba(0, 150, 136, 0.75)',
                'rgba(76, 175, 80, 0.8)',
                'rgba(139, 195, 74, 0.85)',
                'rgba(205, 220, 57, 0.9)',
                'rgba(255, 235, 59, 0.95)',
                'rgba(255, 193, 7, 1)'
            ],

            components: {

                preview: true,
                opacity: true,
                hue: true,
                palette: false,

                interaction: {
                    hex: true,
                    rgba: true,
                    hsla: true,
                    hsva: true,
                    cmyk: true,
                    input: true,
                    clear: false,
                    save: false
                }
            }
        });
        pickr.on('change', (color, _source, _instance) => {
            console.log('Event: "change"', color);
            const hexColor = color.toHEXA().toString();
            document.getElementById('panel').style.backgroundColor = hexColor;
            document.getElementById('color_hex').value = hexColor;

        });
        var colorInput = document.getElementById("color_hex");
        var panel = document.getElementById("panel");

        colorInput.addEventListener("input", function() {
            var colorCode = colorInput.value;

            panel.style.background = colorCode;
        });
    </script>
    <script>
        @foreach ($colors as $item)
            const pickrEdit_{{ $item->id }} = Pickr.create({
                el: '.color-picker-edit', // Menggunakan class baru
                theme: 'classic',

                swatches: [
                    'rgba(244, 67, 54, 1)',
                    'rgba(233, 30, 99, 0.95)',
                    'rgba(156, 39, 176, 0.9)',
                    'rgba(103, 58, 183, 0.85)',
                    'rgba(63, 81, 181, 0.8)',
                    'rgba(33, 150, 243, 0.75)',
                    'rgba(3, 169, 244, 0.7)',
                    'rgba(0, 188, 212, 0.7)',
                    'rgba(0, 150, 136, 0.75)',
                    'rgba(76, 175, 80, 0.8)',
                    'rgba(139, 195, 74, 0.85)',
                    'rgba(205, 220, 57, 0.9)',
                    'rgba(255, 235, 59, 0.95)',
                    'rgba(255, 193, 7, 1)'
                ],

                components: {
                    preview: true,
                    opacity: true,
                    hue: true,
                    palette: false,
                    interaction: {
                        hex: true,
                        rgba: true,
                        hsla: true,
                        hsva: true,
                        cmyk: true,
                        input: true,
                        clear: false,
                        save: false
                    }
                }
            });

            pickrEdit_{{ $item->id }}.on('change', (color, _source, _instance) => {
                console.log('Event: "change"', color);
                const hexColor = color.toHEXA().toString();
                document.getElementById('panel{{ $item->id }}').style.backgroundColor = hexColor;
                document.getElementById('color_hex_edit_{{ $item->id }}').value = hexColor;
            });

            var colorInput = document.getElementById("color_hex_edit_{{ $item->id }}");
            var panel = document.getElementById("panel{{ $item->id }}");

            colorInput.addEventListener("input", function() {
                var colorCode = colorInput.value;
                panel.style.background = colorCode;
            });
        @endforeach
    </script>
@endpush
