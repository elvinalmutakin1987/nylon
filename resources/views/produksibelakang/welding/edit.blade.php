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
                            <li class="breadcrumb-item"><a href="{{ route('prodwelding.index') }}"
                                    class="text-dark">Produksi
                                    Welding</a>
                            </li>
                            <li class="breadcrumb-item" Active>Edit Data</li>
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
                        <form action="{{ route('prodwelding.update', $prodwelding->slug) }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            @method('put')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Produksi Welding</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="prodwjl_id">Produksi WJL</label>
                                                <select
                                                    class="form-control select2 w-100 select-prodwjl @error('prodwjl_id') is-invalid @enderror"
                                                    id="prodwjl_id" name="prodwjl_id">
                                                    <option value="{{ $prodwelding->prodlaminating->prodwjl_id }}">
                                                        {{ $prodwelding->prodlaminating->prodwjl->nomor }}</option>
                                                </select>
                                                @error('prodwjl_id')
                                                    <span id="prodwjl_id-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="prodlaminating_id">Produksi Laminating</label>
                                                <select
                                                    class="form-control select2 w-100 select-prodlaminating @error('prodlaminating_id') is-invalid @enderror"
                                                    id="prodlaminating_id" name="prodlaminating_id">
                                                    <option value="{{ $prodwelding->prodlaminating_id }}">
                                                        {{ $prodwelding->prodlaminating->nomor }}</option>
                                                </select>
                                                @error('prodlaminating_id')
                                                    <span id="prodlaminating_id-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="nomor_so">Nomor SO</label>
                                                <input type="text"
                                                    class="form-control @error('nomor_so') is-invalid @enderror"
                                                    id="nomor_so" name="nomor_so" readonly
                                                    value="{{ $prodwelding->nomor_so }}">
                                                @error('nomor_so')
                                                    <span id="nomor_so-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="nomor_roll">Nomor Roll</label>
                                                <input type="text"
                                                    class="form-control @error('nomor_roll') is-invalid @enderror"
                                                    id="nomor_roll" name="nomor_roll"
                                                    value="{{ $prodwelding->nomor_roll }}">
                                                @error('nomor_roll')
                                                    <span id="nomor_roll-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="mesin_id">Mesin</label>
                                                <select
                                                    class="form-control select2 w-100 select-mesin @error('mesin_id') is-invalid @enderror"
                                                    id="mesin_id" name="mesin_id">
                                                    <option value="{{ $prodwelding->mesin_id }}">
                                                        {{ $prodwelding->mesin->nama }}
                                                    </option>
                                                </select>
                                                @error('mesin_id')
                                                    <span id="mesin_id-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal</label>
                                                <div class="input-group date" id="div_tanggal" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        data-target="#div_tanggal" id="tanggal" name="tanggal"
                                                        value="{{ old('tanggal') ?? $prodwelding->tanggal }}" />
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
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="shift">Shift</label>
                                                <select
                                                    class="form-control select2 w-100 select-shift @error('shift') is-invalid @enderror"
                                                    id="shift" name="shift">
                                                    <option value="Pagi"
                                                        {{ $prodwelding->shift == 'Pagi' ? 'selected' : '' }}>Pagi
                                                    </option>
                                                    <option value="Sore"
                                                        {{ $prodwelding->shift == 'Sore' ? 'selected' : '' }}>Sore
                                                    </option>
                                                    <option value="Malam"
                                                        {{ $prodwelding->shift == 'Malam' ? 'selected' : '' }}>Malam
                                                    </option>
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
                                                    id="operator" name="operator"
                                                    value="{{ old('operator') ?? $prodwelding->operator }}">
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
                                                    id="keterangan" name="keterangan"
                                                    value="{{ old('keterangan') ?? $prodwelding->keterangan }}">
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
                                                            <th class="text-center" colspan="4">Build Of Material</th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center" rowspan="2"
                                                                style="vertical-align: middle">
                                                                Material
                                                            </th>
                                                            <th class="text-center" colspan="2">Satuan</th>
                                                            <th class="text-center" rowspan="2" style="width: 50px">
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center" style="width: 200px">Meter</th>
                                                            <th class="text-center" style="width: 200px">KG</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($prodwelding->prodweldingdetail as $d)
                                                            @if ($loop->last)
                                                                <tr>
                                                                    <td style="vertical-align: top">
                                                                        <select
                                                                            class="form-control select2 w-100 select-material @error('mesin_id') is-invalid @enderror"
                                                                            id="material_id1" name="material_id[]">
                                                                            <option value="{{ $d->material_id }}">
                                                                                {{ $d->material->nama }}</option>
                                                                        </select>
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <input type="text"
                                                                            class="form-control @error('jumlah') is-invalid @enderror"
                                                                            id="jumlah1" name="jumlah[]"
                                                                            onkeyup="ubah_format('jumlah1', this.value);"
                                                                            value="{{ $d->jumlah ? Number::format($d->jumlah) : '' }}">
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <input type="text"
                                                                            class="form-control @error('jumlah2') is-invalid @enderror"
                                                                            id="jumlah21" name="jumlah2[]"
                                                                            onkeyup="ubah_format('jumlah21', this.value)"
                                                                            value="{{ $d->jumlah2 ? Number::format($d->jumlah2) : '' }}">
                                                                    </td>
                                                                    <td style="vertical-align: top" class="text-center">
                                                                        <button type="button" class="btn btn-primary"
                                                                            onclick="tambah()"><i class="fa fa-plus"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @else
                                                                <tr>
                                                                    <td style="vertical-align: top">
                                                                        <select
                                                                            class="form-control select2 w-100 select-material @error('material_id') is-invalid @enderror"
                                                                            id="material_id{{ $d->slug }}"
                                                                            name="material_id[]">
                                                                            <option value="{{ $d->material_id }}">
                                                                                {{ $d->material->nama }}</option>
                                                                        </select>
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <input type="text"
                                                                            class="form-control @error('jumlah') is-invalid @enderror"
                                                                            id="jumlah{{ $d->id }}"
                                                                            name="jumlah[]"
                                                                            onkeyup="ubah_format('jumlah{{ $d->id }}', this.value);"
                                                                            value="{{ $d->jumlah ? Number::format($d->jumlah) : '' }}">
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <input type="text"
                                                                            class="form-control @error('jumlah2') is-invalid @enderror"
                                                                            id="jumlah2{{ $d->id }}"
                                                                            name="jumlah2[]"
                                                                            onkeyup="ubah_format('jumlah2{{ $d->id }}', this.value)"
                                                                            value="{{ $d->jumlah2 ? Number::format($d->jumlah2) : '' }}">
                                                                    </td>
                                                                    <td class="text-center" style="vertical-align: top">
                                                                        <button type="button" class="btn btn-danger"
                                                                            id="hapus"><i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        @if (count($prodwelding->prodweldingdetail) == 0)
                                                            <tr>
                                                                <td style="vertical-align: top">
                                                                    <select
                                                                        class="form-control select2 w-100 select-material @error('mesin_id') is-invalid @enderror"
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
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="material_id_panen">Material Panen</label>
                                                <select
                                                    class="form-control select2 w-100 select-material @error('material_id_panen') is-invalid @enderror"
                                                    id="material_id_panen" name="material_id_panen[]">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="jumlah_panen2">Meter</label>
                                                <input type="text"
                                                    class="form-control @error('jumlah_panen') is-invalid @enderror"
                                                    id="jumlah_panen" name="jumlah_panen[]"
                                                    onkeyup="ubah_format('jumlah_panen', this.value)">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="jumlah_panen2">KG</label>
                                                <input type="text"
                                                    class="form-control @error('jumlah_panen2') is-invalid @enderror"
                                                    id="jumlah_panen2" name="jumlah_panen2[]"
                                                    onkeyup="ubah_format('jumlah_panen2', this.value)">
                                            </div>
                                        </div>
                                    </div> --}}
                                    <!-- /.card-body -->

                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="button" class="btn btn-default" href="{{ route('prodwelding.index') }}"><i
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
                ajax: {
                    url: '{{ route('prodwelding.get_mesin') }}',
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
                    url: '{{ route('prodwelding.get_material') }}',
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
                    url: '{{ route('prodwelding.get_prodwjl') }}',
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
                var url = "{!! route('prodwelding.get_prodwjl_by_id', ['prodwjl_id' => '_prodwjl_id']) !!}"
                url = url.replace('_prodwjl_id', this.value)
                $.get(url, function(data) {
                    $("#nomor_so").val(data.prodwjl.nomor_so);
                    $("#nomor_roll").val(data.prodwjl.nomor_roll);
                });
            });

            $('.select-prodlaminating').select2({
                placeholder: "- Pilih Produksi Laminating -",
                allowClear: true,
                ajax: {
                    url: '{{ route('prodwelding.get_prodlaminating') }}',
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
