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
                            <li class="breadcrumb-item"><a href="{{ route('prodtarik.index') }}" class="text-dark">Produksi
                                    Tarik</a>
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
                        <form action="{{ route('prodtarik.store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            @method('post')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Produksi Tarik</h3>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col">
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
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="shift">Shift</label>
                                                <select
                                                    class="form-control select2 w-100 select-shift @error('shift') is-invalid @enderror"
                                                    id="shift" name="shift">
                                                    <option value="Pagi">Pagi</option>
                                                    <option value="Sore">Sore</option>
                                                    <option value="Malam">Malam</option>
                                                </select>
                                                @error('shift')
                                                    <span id="shift-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="operator">Operator</label>
                                                <input type="text"
                                                    class="form-control @error('operator') is-invalid @enderror"
                                                    id="operator" name="operator" value="{{ old('operator') }}">
                                                @error('operator')
                                                    <span id="operator-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="keterangan">Keterangan</label>
                                                <input type="text"
                                                    class="form-control @error('keterangan') is-invalid @enderror"
                                                    id="keterangan" name="keterangan" value="{{ old('keterangan') }}">
                                                @error('keterangan')
                                                    <span id="keterangan-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="table-responsive p-0">
                                                <table id="table1" class="table projects table-bordered table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" colspan="7">Build Of Material</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center" rowspan="2"
                                                                style="vertical-align: middle" style="width: 15%">
                                                                Produksi Welding
                                                            </th>
                                                            <th class="text-center" rowspan="2"
                                                                style="vertical-align: middle" style="width: 15%">
                                                                Nomor SO
                                                            </th>
                                                            <th class="text-center" rowspan="2"
                                                                style="vertical-align: middle" style="width: 15%">
                                                                Mesin
                                                            </th>
                                                            <th class="text-center" rowspan="2"
                                                                style="vertical-align: middle" style="width: 15%">
                                                                Material
                                                            </th>
                                                            <th class="text-center" colspan="2" style="width: 20%">
                                                                Satuan</th>
                                                            <th class="text-center" rowspan="2">
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center" style="width: 10%">Meter</th>
                                                            <th class="text-center" style="width: 10%">KG</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="vertical-align: top">
                                                                <select
                                                                    class="form-control select2 w-100 select-welding @error('prodwelding_id') is-invalid @enderror"
                                                                    id="prodwelding_id1" name="prodwelding_id[]">
                                                                </select>
                                                            </td>
                                                            <td style="vertical-align: top">
                                                                <input type="text"
                                                                    class="form-control @error('nomor_so') is-invalid @enderror"
                                                                    id="nomor_so1" name="nomor_so[]">
                                                            </td>
                                                            <td style="vertical-align: top">
                                                                <select
                                                                    class="form-control select2 w-100 select-mesin @error('mesin_id') is-invalid @enderror"
                                                                    id="mesin_id1" name="mesin_id[]">
                                                                </select>
                                                            </td>
                                                            <td style="vertical-align: top">
                                                                <select
                                                                    class="form-control select2 w-100 select-material @error('material_id') is-invalid @enderror"
                                                                    id="material_id1" name="material_id[]">
                                                                </select>
                                                            </td>
                                                            <td style="vertical-align: top">
                                                                <input type="text"
                                                                    class="form-control @error('jumlah') is-invalid @enderror"
                                                                    id="jumlah1" name="jumlah[]"
                                                                    onkeyup="ubah_format('jumlah1', this.value);">
                                                            </td>
                                                            <td style="vertical-align: top">
                                                                <input type="text"
                                                                    class="form-control @error('jumlah2') is-invalid @enderror"
                                                                    id="jumlah21" name="jumlah2[]"
                                                                    onkeyup="ubah_format('jumlah21', this.value)">
                                                            </td>
                                                            <td style="vertical-align: top" class="text-center">
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

                                    <!-- /.card-body -->

                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="button" class="btn btn-default" href="{{ route('prodtarik.index') }}"><i
                                            class="fa fa-reply"></i>
                                        Kembali</a>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>
                                        Simpan</button>
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
            $('#div_tanggal').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            format_select2();

        });

        function format_select2() {
            $('.select-shift').select2({
                width: '100%',
                minimumResultsForSearch: -1,
            });

            $('.select-mesin').select2({
                placeholder: "- Pilih Mesin -",
                allowClear: true,
                width: '100%',
                ajax: {
                    url: '{{ route('prodtarik.get_mesin') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1,
                        };
                    },
                    cache: true,
                }
            });

            $('.select-welding').select2({
                placeholder: "- Pilih Produksi Welding -",
                allowClear: true,
                width: '100%',
                ajax: {
                    url: '{{ route('prodtarik.get_prodwelding') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1,
                        };
                    },
                    cache: true,
                }
            });

            $('.select-material').select2({
                placeholder: "- Pilih Material -",
                allowClear: true,
                width: '100%',
                ajax: {
                    url: '{{ route('prodtarik.get_material') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1,
                        };
                    },
                    cache: true,
                }
            });

            $('.select-prodwjl').select2({
                placeholder: "- Pilih Produksi WJL -",
                allowClear: true,
                ajax: {
                    url: '{{ route('prodtarik.get_prodwjl') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1,
                        };
                    },
                    cache: true,
                }
            }).on('select2:select', function(e) {
                var url = "{!! route('prodtarik.get_prodwjl_by_id', ['prodwjl_id' => '_prodwjl_id']) !!}"
                url = url.replace('_prodwjl_id', this.value)
                $.get(url, function(data) {});
            });

            $('.select-prodlaminating').select2({
                placeholder: "- Pilih Produksi Laminating -",
                allowClear: true,
                ajax: {
                    url: '{{ route('prodtarik.get_prodlaminating') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1,
                            prodwjl_id: $('#prodwjl_id').val() || null,
                        };
                    },
                    cache: true,
                }
            });
        }

        function tambah() {
            var tbody_row = $('#table1').find('tr').length;
            var row_id = Date.now().toString(36) + Math.random().toString(36).substr(2);
            var material_id = $("#material_id1 option:selected").val();
            var material = $("#material_id1 option:selected").text();
            var mesin_id = $("#mesin_id1 option:selected").val();
            var mesin = $("#mesin_id1 option:selected").text();
            var prodwelding_id = $("#prodwelding_id1 option:selected").val();
            var prodwelding = $("#prodwelding_id1 option:selected").text();
            var nomor_so = $("#nomor_so1").val();
            var jumlah = $("#jumlah1").val();
            var jumlah2 = $("#jumlah21").val();
            $("#table1 > tbody > tr:last").before(`
            <tr>
                <td style="vertical-align: top">
                    <select
                        class="form-control select2 w-100 select-welding @error('prodwelding_id') is-invalid @enderror"
                        id="prodwelding_id${row_id}" name="prodwelding_id[]">
                        <option value="${prodwelding_id}">${prodwelding}</option>
                    </select>
                </td>
                <td style="vertical-align: top">
                    <input type="text"
                        class="form-control @error('nomor_so') is-invalid @enderror"
                        id="nomor_so${row_id}" name="nomor_so[]"
                         value="${nomor_so}">
                </td>
                <td style="vertical-align: top">
                    <select
                        class="form-control select2 w-100 select-mesin @error('mesin_id') is-invalid @enderror"
                        id="mesin_id${row_id}" name="mesin_id[]">
                        <option value="${mesin_id}">${mesin}</option>
                    </select>
                </td>
                <td style="vertical-align: top">
                    <select
                        class="form-control select2 w-100 select-material @error('material_id') is-invalid @enderror"
                        id="material_id${row_id}" name="material_id[]">
                        <option value="${material_id}">${material}</option>
                    </select>
                </td>
                <td style="vertical-align: top">
                    <input type="text"
                        class="form-control @error('jumlah') is-invalid @enderror"
                        id="jumlah${row_id}" name="jumlah[]"
                        onkeyup="ubah_format('jumlah1', this.value);"
                         value="${jumlah}">
                </td>
                <td style="vertical-align: top">
                    <input type="text"
                        class="form-control @error('jumlah2') is-invalid @enderror"
                        id="jumlah2${row_id}" name="jumlah2[]"
                        onkeyup="ubah_format('jumlah21', this.value)"
                        value="${jumlah2}">
                </td>
                <td class="text-center" style="vertical-align: top">
                    <button type="button" class="btn btn-danger"
                        id="hapus"><i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `);
            $("#material_id1").val(null).trigger('change');
            $("#mesin_id1").val(null).trigger('change');
            $("#prodwelding_id1").val(null).trigger('change');
            $("#nomor_so1").val("");
            $("#jumlah1").val("");
            $("#jumlah21").val("");

            format_select2();
        }

        function ubah_format(field, nilai) {
            var mynumeral = numeral(nilai).format('0,0');
            $("#" + field).val(mynumeral);
        }

        $("#table1").on("click", "#hapus", function() {
            $(this).closest("tr").remove();
        });
    </script>
@endsection
