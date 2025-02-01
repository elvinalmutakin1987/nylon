@extends('partials.main')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-dark">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('gudang.index') }}" class="text-dark">Gudang</a>
                            </li>
                            <li class="breadcrumb-item">Bahan Baku</li>
                            <li class="breadcrumb-item">Barang Masuk</li>
                            <li class="breadcrumb-item" Active>Tambah Data</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Application buttons -->
                        <form action="{{ route('barangmasuk.store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            @method('post')
                            <input type="hidden" id="gudang" name="gudang" value="{{ $gudang }}">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Barang Masuk</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="asal">Gudang Asal</label>
                                                <select
                                                    class="form-control select2 w-100 select-asal @error('asal') is-invalid @enderror"
                                                    id="asal" name="asal">
                                                    <option value=""></option>
                                                </select>
                                                @error('asal')
                                                    <span id="asal-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="barangkeluar_id">No. Barang Keluar</label>
                                                <select
                                                    class="form-control select2 w-100 select-barang-keluar @error('barangkeluar_id') is-invalid @enderror"
                                                    id="barangkeluar_id" name="barangkeluar_id">
                                                </select>
                                                @error('barangkeluar_id')
                                                    <span id="barangkeluar_id-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal</label>
                                                <div class="input-group date" id="div_tanggal" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        data-target="#div_tanggal" id="tanggal" name="tanggal"
                                                        value="{{ old('tanggal') ?? date('Y-m-d') }}" />
                                                    <div class="input-group-append" data-target="#div_tanggal"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('tanggal')
                                                    <span id="nama-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive p-0">
                                                <table id="table1" class="table border table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 40%">Barang</th>
                                                            <th style="width: 10%">Satuan</th>
                                                            <th style="width: 15%">Jumlah</th>
                                                            <th>Keterangan</th>
                                                            <th style="width: 50px" class="text-center"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <select class="form-control select2 w-100 select-barang"
                                                                    id="material_id1" name="material_id[]">
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control select2 w-100 select-satuan"
                                                                    id="satuan1" name="satuan[]">
                                                                    @foreach ($satuan as $d)
                                                                        <option value="{{ $d->nama }}">
                                                                            {{ $d->nama }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" id="jumlah1"
                                                                    name="jumlah[]"
                                                                    onblur="ubah_format('jumlah1', this.value)">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" id="keterangan1"
                                                                    name="keterangan[]">
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-danger"
                                                                    id="hapus"><i class="fa fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-right text-bold" colspan="4"></td>
                                                            <td>
                                                                <button type="button" class="btn btn-primary"
                                                                    onclick="tambah()"><i class="fa fa-plus"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="catatan">Catatan</label>
                                                <textarea id="catatan" name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="button" class="btn btn-default"
                                        href="{{ route('barangmasuk.index', ['gudang' => $gudang]) }}"><i
                                            class="fa fa-reply"></i>
                                        Kembali</a>
                                    <button type="button" class="btn btn-success" data-toggle="dropdown"><i
                                            class="fa fa-save"></i>
                                        Simpan</button>
                                    <div class="dropdown-menu" role="menu">
                                        <button type="submit" class="dropdown-item" name="status" value="Draft"><i
                                                class="fa fa-file"></i> Sebagai Draft</button>
                                        <button type="submit" class="dropdown-item" name="status" value="Submit"><i
                                                class="fa fa-save"></i> Simpan Barang Masuk</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </form>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /. row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


@section('script')
    <script type="text/javascript">
        var gudang;

        var data2 = [{
                id: 'barang-jadi',
                text: 'Barang Jadi'
            },
            {
                id: 'bahan-baku',
                text: 'Bahan Baku'
            },
            {
                id: 'benang',
                text: 'Benang'
            },
            {
                id: 'extruder',
                text: 'Extruder'
            },
            {
                id: 'wjl',
                text: 'WJL'
            },
            {
                id: 'sulzer',
                text: 'Sulzer'
            },
            {
                id: 'rashel',
                text: 'Rashel'
            },
            {
                id: 'beaming',
                text: 'Beaming'
            }, {
                id: 'packing',
                text: 'Packing'
            }
        ];

        $(document).ready(function() {
            $('#div_tanggal').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            format_select2();
        });

        function format_select2() {
            $(".select-asal").select2({
                placeholder: "-- Pilih Asal --",
                allowClear: true,
                data: data2,
                minimumResultsForSearch: -1,
                width: '100%'
            });

            $('.select-barang-keluar').select2({
                placeholder: "- Pilih Barang Keluar -",
                allowClear: true,
                ajax: {
                    url: '{{ route('barangmasuk.get_barangkeluar') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1,
                            gudang: gudang
                        };
                    },
                    cache: true,
                }
            });

            $('.select-satuan').select2({
                width: '100%'
            });

            $('.select-barang').select2({
                placeholder: "- Pilih Barang -",
                allowClear: true,
                ajax: {
                    url: '{{ route('barangmasuk.get_material') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1,
                            gudang: '{{ $gudang }}'
                        };
                    },
                    cache: true,
                },
                width: '100%'
            });
        }

        function ubah_format(field, nilai) {
            var mynumeral = numeral(nilai).format('0,0');
            if (field.includes('jumlah')) {
                mynumeral = numeral(nilai).format('0,0.0');
            }
            $("#" + field).val(mynumeral);
        }

        function tambah() {
            var tbody_row = $('#table1').find('tr').length;
            var row_id = Date.now().toString(36) + Math.random().toString(36).substr(2);
            $("#table1 > tbody > tr:last").before(`
                <tr>
                    <td>
                        <select class="form-control select2 w-100 select-barang"
                            id="mamterial_id${row_id}" name="material_id[]">
                        </select>
                    </td>
                    <td>
                        <select class="form-control select2 w-100 select-satuan"
                            id="satuan${row_id}" name="satuan[]">
                            @foreach ($satuan as $d)
                                <option value="{{ $d->nama }}">{{ $d->nama }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control" id="jumlah${row_id}"
                            name="jumlah[]" onblur="ubah_format('jumlah${row_id}', this.value)">
                    </td>
                    <td>
                        <input type="text" class="form-control" id="keterangan${row_id}"
                            name="keterangan[]">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger" id="hapus"><i
                                class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);

            format_select2();
        }

        $("#table1").on("click", "#hapus", function() {
            $(this).closest("tr").remove();
        });

        $(".select-asal").on('change', function(e) {
            $('.select-barang-keluar').val('').trigger('change');
            gudang = $(".select-asal").val();
            $('.select-barang-keluar').select2({
                placeholder: "- Pilih Barang Keluar -",
                allowClear: true,
                ajax: {
                    url: '{{ route('barangmasuk.get_barangkeluar') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1,
                            gudang: gudang
                        };
                    },
                    cache: true,
                }
            });
        })
    </script>
@endsection
