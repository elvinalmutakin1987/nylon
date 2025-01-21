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
                            <li class="breadcrumb-item"><a href="{{ route('produksi.index') }}"
                                    class="text-dark">Produksi</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('permintaanmaterial.index') }}"
                                    class="text-dark">Permintaan
                                    Bahan Baku</a>
                            </li>
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
                        <form action="{{ route('permintaanmaterial.store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            @method('post')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Permintaan Bahan Baku</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <input type="text"
                                                class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                                                name="tanggal" value="{{ old('tanggal') ?? date('Y-m-d') }}" readonly>
                                            @error('tanggal')
                                                <span id="tanggal-error"
                                                    class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group table-responsive">
                                            <table id="table1" class="table border table-sm projects">
                                                <thead>
                                                    <tr>
                                                        <th>Jenis</th>
                                                        <th>Satuan</th>
                                                        <th>Jumlah</th>
                                                        <th>Keterangan</th>
                                                        <th style="width: 50px" class="text-center"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <select class="form-control select2 w-100 select-barang"
                                                                id="mamterial_id1" name="material_id[]">
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-control select2 w-100 select-satuan"
                                                                id="satuan1" name="satuan[]">
                                                                <option value="ZAK">ZAK</option>
                                                                <option value="KG">KG</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" id="jumlah1"
                                                                name="jumlah[]" onblur="ubah_format('jumlah1', this.value)">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" id="keterangan1"
                                                                name="keterangan[]">
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-danger" id="hapus"><i
                                                                    class="fa fa-trash"></i>
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
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="button" class="btn btn-default"
                                        href="{{ route('permintaanmaterial.index') }}"><i class="fa fa-reply"></i>
                                        Kembali</a>
                                    <button type="button" class="btn btn-success" data-toggle="dropdown"><i
                                            class="fa fa-save"></i>
                                        Simpan</button>
                                    <div class="dropdown-menu" role="menu">
                                        @if ($pengaturan->nilai == 'Ya')
                                            <button type="submit" class="dropdown-item" name="status" value="Draft"><i
                                                    class="fa fa-file"></i> Sebagai Draft</button>
                                        @endif
                                        <button type="submit" class="dropdown-item" name="status" value="Submit"><i
                                                class="fa fa-save"></i> Simpan Permintaan</button>
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
        $(document).ready(function() {
            format_select2();
        });

        function format_select2() {
            $('.select-satuan').select2({
                width: '100%'
            });

            $('.select-barang').select2({
                placeholder: "- Pilih Material -",
                allowClear: true,
                ajax: {
                    url: '{{ route('permintaanmaterial.get_material') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1
                        };
                    },
                    cache: true,
                },
                width: '100%'
            });
        }

        $("#table1").on("click", "#hapus", function() {
            $(this).closest("tr").remove();
        });

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
                            <option value="ZAK">ZAK</option>
                            <option value="KG">KG</option>
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

        function ubah_format(field, nilai) {
            var mynumeral = numeral(nilai).format('0,0');
            $("#" + field).val(mynumeral);
        }
    </script>
@endsection
