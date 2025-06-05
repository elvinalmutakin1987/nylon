@php
    use Illuminate\Support\Number;
@endphp
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
                            <li class="breadcrumb-item"><a href="{{ route('prodwjl.index') }}" class="text-dark">Produksi
                                    WJL</a>
                            </li>
                            <li class="breadcrumb-item" Active>Panen</li>
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
                        <form action="{{ route('prodwjl.update_panen', $prodwjl->slug) }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Panen</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="nomor">Nomor</label>
                                                <input type="text"
                                                    class="form-control @error('nomor') is-invalid @enderror" id="nomor"
                                                    name="nomor" value="{{ old('nomor') ?? $prodwjl->nomor }}" readonly>
                                                @error('nomor')
                                                    <span id="nomor-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="tanggal_panen">tanggal_panen</label>
                                                <div class="input-group date" id="div_tanggal_panen"
                                                    data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        data-target="#div_tanggal_panen" id="tanggal_panen"
                                                        name="tanggal_panen"
                                                        value="{{ old('tanggal_panen') ?? date('Y-m-d') }}" />
                                                    <div class="input-group-append" data-target="#div_tanggal_panen"
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
                                                <label for="material_id_panen">Material Panen</label>
                                                <select
                                                    class="form-control select2 w-100 select-material @error('material_id_panen') is-invalid @enderror"
                                                    id="material_id_panen" name="material_id_panen">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="jumlah_panen">Meter</label>
                                                <input type="text"
                                                    class="form-control @error('jumlah_panen') is-invalid @enderror"
                                                    id="jumlah_panen" name="jumlah_panen"
                                                    onkeyup="ubah_format('jumlah_panen', this.value)">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="jumlah_panen2">KG</label>
                                                <input type="text"
                                                    class="form-control @error('jumlah_panen2') is-invalid @enderror"
                                                    id="jumlah_panen2" name="jumlah_panen2"
                                                    onkeyup="ubah_format('jumlah_panen2', this.value)">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="button" class="btn btn-default" href="{{ route('prodwjl.index') }}"><i
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
            $('#div_tanggal_panen').datetimepicker({
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
                ajax: {
                    url: '{{ route('prodwjl.get_mesin') }}',
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
                ajax: {
                    url: '{{ route('prodwjl.get_material') }}',
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
        }

        function tambah() {
            var tbody_row = $('#table1').find('tr').length;
            var row_id = Date.now().toString(36) + Math.random().toString(36).substr(2);
            var material_id = $("#material_id1 option:selected").val();
            var material = $("#material_id1 option:selected").text();
            var jumlah = $("#jumlah1").val();
            var jumlah2 = $("#jumlah21").val();
            $("#table1 > tbody > tr:last").before(`
            <tr>
                <td style="vertical-align: top">
                    <select
                        class="form-control select2 w-100 select-material @error('mesin_id') is-invalid @enderror"
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
