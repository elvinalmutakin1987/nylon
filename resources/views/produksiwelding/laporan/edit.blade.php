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
                        <form action="{{ route('produksiwelding.laporan.update', $produksiwelding->slug) }}"
                            enctype="multipart/form-data" method="POST">
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
                                                <label for="tanggal">Tanggal</label>
                                                <div class="input-group date" id="div_tanggal" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        data-target="#div_tanggal" id="tanggal" name="tanggal"
                                                        value="{{ old('tanggal') ?? $produksiwelding->tanggal }}" />
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
                                                    <option value="Pagi"
                                                        {{ $produksiwelding->shift == 'Pagi' ? 'selected' : '' }}>Pagi
                                                    </option>
                                                    <option value="Sore"
                                                        {{ $produksiwelding->shift == 'Sore' ? 'selected' : '' }}>Sore
                                                    </option>
                                                    <option value="Malam"
                                                        {{ $produksiwelding->shift == 'Malam' ? 'selected' : '' }}>Malam
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
                                                    value="{{ old('operator') ?? $produksiwelding->operator }}">
                                                @error('operator')
                                                    <span id="operator-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="table-responsive p-0">
                                                <table id="table1" class="table table-bordered table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" style="vertical-align: middle"
                                                                width="20%">Jenis
                                                            </th>
                                                            <th class="text-center">
                                                                Ukuran
                                                            </th>
                                                            <th class="text-center">Jumlah</th>
                                                            <th class="text-center">Total</th>
                                                            <th class="text-center" width="30%">Keterangan</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $grand_total = 0; @endphp
                                                        @foreach ($produksiwelding->produksiweldingdetail as $d)
                                                            @if ($loop->last)
                                                                <tr>
                                                                    <td style="vertical-align: top">
                                                                        <input type="text"
                                                                            class="form-control @error('jenis') is-invalid @enderror"
                                                                            id="jenis1" name="jenis[]"
                                                                            value="{{ $d->jenis }}">
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <input type="text"
                                                                            class="form-control @error('ukuran1') is-invalid @enderror"
                                                                            id="ukuran11" name="ukuran1[]"
                                                                            style="display: inline-block; width: 40%; vertical-align: middle; text-align: center;"
                                                                            onkeyup="ubah_format('ukuran11', this.value); hitung_total(1);"
                                                                            value="{{ Number::format((float) $d->ukuran1) }}">
                                                                        <span
                                                                            style="display: inline-block; width: 10%; text-align: center;">X</span>
                                                                        <input type="text"
                                                                            class="form-control @error('ukuran2') is-invalid @enderror"
                                                                            id="ukuran21" name="ukuran2[]"
                                                                            style="display: inline-block; width: 40%; vertical-align: middle; text-align: center;"
                                                                            onkeyup="ubah_format('ukuran21', this.value); hitung_total(1);"
                                                                            value="{{ Number::format((float) $d->ukuran2) }}">
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <input type="text"
                                                                            class="form-control @error('jumlah') is-invalid @enderror"
                                                                            id="jumlah1" name="jumlah[]"
                                                                            style="text-align: center;"
                                                                            onkeyup="ubah_format('jumlah1', this.value); hitung_total(1);"
                                                                            value="{{ Number::format((float) $d->jumlah) }}">
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <input type="text"
                                                                            class="form-control @error('total') is-invalid @enderror"
                                                                            id="total1" name="total[]"
                                                                            style="text-align: center;"
                                                                            value="{{ Number::format((float) $d->total) }}"
                                                                            readonly>
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <input type="text"
                                                                            class="form-control @error('keterangan') is-invalid @enderror"
                                                                            id="keterangan1" name="keterangan[]"
                                                                            value="{{ $d->keterangan }}">
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
                                                                        <input type="text"
                                                                            class="form-control @error('jenis') is-invalid @enderror"
                                                                            id="jenis{{ $d->slug }}" name="jenis[]"
                                                                            value="{{ $d->jenis }}">
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <input type="text"
                                                                            class="form-control @error('ukuran1') is-invalid @enderror"
                                                                            id="ukuran1{{ $d->slug }}"
                                                                            name="ukuran1[]"
                                                                            style="display: inline-block; width: 40%; vertical-align: middle; text-align: center;"
                                                                            onkeyup="ubah_format('ukuran1{{ $d->slug }}', this.value); hitung_total(1);"
                                                                            value="{{ Number::format((float) $d->ukuran1) }}">
                                                                        <span
                                                                            style="display: inline-block; width: 10%; text-align: center;">X</span>
                                                                        <input type="text"
                                                                            class="form-control @error('ukuran2') is-invalid @enderror"
                                                                            id="ukuran2{{ $d->slug }}"
                                                                            name="ukuran2[]"
                                                                            style="display: inline-block; width: 40%; vertical-align: middle; text-align: center;"
                                                                            onkeyup="ubah_format('ukuran2{{ $d->slug }}', this.value); hitung_total(1);"
                                                                            value="{{ Number::format((float) $d->ukuran2) }}">
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <input type="text"
                                                                            class="form-control @error('jumlah') is-invalid @enderror"
                                                                            id="jumlah{{ $d->slug }}"
                                                                            name="jumlah[]" style="text-align: center"
                                                                            onkeyup="ubah_format('jumlah{{ $d->slug }}', this.value); hitung_total(1);"
                                                                            value="{{ Number::format((float) $d->jumlah) }}">
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <input type="text"
                                                                            class="form-control @error('total') is-invalid @enderror"
                                                                            id="total{{ $d->slug }}" name="total[]"
                                                                            readonly style="text-align: center"
                                                                            value="{{ Number::format((float) $d->total) }}">
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <input type="text"
                                                                            class="form-control @error('keterangan') is-invalid @enderror"
                                                                            id="keterangan{{ $d->slug }}"
                                                                            name="keterangan[]"
                                                                            value="{{ $d->keterangan }}">
                                                                    </td>
                                                                    <td style="vertical-align: top" class="text-center">
                                                                        <button type="button" class="btn btn-danger"
                                                                            id="hapus"><i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            @php $grand_total += (float) $d->total; @endphp
                                                        @endforeach
                                                        @if (count($produksiwelding->produksiweldingdetail) == 0)
                                                            <tr>
                                                                <td style="vertical-align: top">
                                                                    <input type="text"
                                                                        class="form-control @error('jenis') is-invalid @enderror"
                                                                        id="jenis1" name="jenis[]">
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <input type="text"
                                                                        class="form-control @error('ukuran1') is-invalid @enderror"
                                                                        id="ukuran11" name="ukuran1[]"
                                                                        style="display: inline-block; width: 40%; vertical-align: middle; text-align: center;"
                                                                        onkeyup="ubah_format('ukuran11', this.value); hitung_total(1);">
                                                                    <span
                                                                        style="display: inline-block; width: 10%; text-align: center;">X</span>
                                                                    <input type="text"
                                                                        class="form-control @error('ukuran2') is-invalid @enderror"
                                                                        id="ukuran21" name="ukuran2[]"
                                                                        style="display: inline-block; width: 40%; vertical-align: middle; text-align: center;"
                                                                        onkeyup="ubah_format('ukuran21', this.value); hitung_total(1);">
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <input type="text"
                                                                        class="form-control @error('jumlah') is-invalid @enderror"
                                                                        id="jumlah1" name="jumlah[]"
                                                                        style="text-align: center"
                                                                        onkeyup="ubah_format('jumlah1', this.value); hitung_total(1);">
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <input type="text"
                                                                        class="form-control @error('total') is-invalid @enderror"
                                                                        id="total1" name="total[]" readonly
                                                                        style="text-align: center">
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <input type="text"
                                                                        class="form-control @error('keterangan') is-invalid @enderror"
                                                                        id="keterangan1" name="keterangan[]">
                                                                </td>
                                                                <td style="vertical-align: top" class="text-center">
                                                                    <button type="button" class="btn btn-primary"
                                                                        onclick="tambah()"><i class="fa fa-plus"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th colspan="3" class="text-right">Total</th>
                                                            <th id="grand_total" class="text-center">
                                                                {{ Number::format($grand_total) }}</th>
                                                            <th colspan="2"></th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- /.card-body -->

                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="button" class="btn btn-default"
                                        href="{{ route('produksiwelding.laporan.index') }}"><i class="fa fa-reply"></i>
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
        }

        function tambah() {
            var tbody_row = $('#table1').find('tr').length;
            var row_id = Date.now().toString(36) + Math.random().toString(36).substr(2);
            var jenis = $("#jenis1").val();
            var ukuran1 = $("#ukuran11").val();
            var ukuran2 = $("#ukuran21").val();
            var jumlah = $("#jumlah1").val();
            var total = $("#total1").val();
            var keterangan = $("#keterangan1").val();
            $("#table1 > tbody > tr:last").before(`
            <tr>
                <td style="vertical-align: top">
                    <input type="text"
                        class="form-control @error('jenis') is-invalid @enderror"
                        id="jenis${row_id}" name="jenis[]" value="${jenis}">
                </td>
               <td style="vertical-align: top">
                    <input type="text"
                        class="form-control @error('ukuran1') is-invalid @enderror"
                        id="ukuran1${row_id}" name="ukuran1[]"
                        style="display: inline-block; width: 40%; vertical-align: middle; text-align: center"
                        onkeyup="ubah_format('ukuran1${row_id}', this.value); hitung_total(${row_id});" value="${ukuran1}">
                    <span
                        style="display: inline-block; width: 10%; text-align: center;">X</span>
                    <input type="text"
                        class="form-control @error('ukuran2') is-invalid @enderror"
                        id="ukuran2${row_id}" name="ukuran2[]"
                        style="display: inline-block; width: 40%; vertical-align: middle; text-align: center"
                        onkeyup="ubah_format('ukuran2${row_id}', this.value); hitung_total(${row_id});" value="${ukuran2}">
                </td>
                <td style="vertical-align: top">
                    <input type="text"
                        class="form-control @error('jumlah') is-invalid @enderror"
                        id="jumlah${row_id}" name="jumlah[]" style="text-align: center"
                        onkeyup="ubah_format('jumlah${row_id}', this.value); hitung_total(${row_id});" value="${jumlah}">
                </td>
                <td style="vertical-align: top">
                    <input type="text"
                        class="form-control @error('total') is-invalid @enderror"  style="text-align: center"
                        id="total${row_id}" name="total[]" readonly value="${total}">
                </td>
                <td style="vertical-align: top">
                    <input type="text"
                        class="form-control @error('keterangan') is-invalid @enderror"
                        id="keterangan${row_id}" name="keterangan[]" value="${keterangan}">
                </td>
                <td class="text-center" style="vertical-align: top">
                    <button type="button" class="btn btn-danger"
                        id="hapus"><i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `);
            $("#jenis1").val("");
            $("#ukuran11").val("");
            $("#ukuran21").val("");
            $("#jumlah1").val("");
            $("#total1").val("");
            $("#keterangan1").val("");

            format_select2();
        }

        function ubah_format(field, nilai) {
            var mynumeral = numeral(nilai).format('0,0');
            $("#" + field).val(mynumeral);
        }

        $("#table1").on("click", "#hapus", function() {
            $(this).closest("tr").remove();
        });

        function hitung_total(index) {
            var ukuran1 = numeral($("#ukuran1" + index).val()).format("0");
            var ukuran2 = numeral($("#ukuran2" + index).val()).format("0");
            var jumlah = numeral($("#jumlah" + index).val()).format("0");
            var total = parseFloat(ukuran1) * parseFloat(ukuran2) * parseFloat(jumlah);
            total = numeral(total).format("0,0");
            $("#total" + index).val(total);

            hitung_grand_total()
        }

        function hitung_grand_total() {
            var grand_total = 0;
            $("#table1 > tbody > tr").each(function() {
                var total = $(this).find("td:nth-child(4) input").val();
                if (total) {
                    grand_total += numeral(total).value();
                }
            });
            $("#grand_total").html(numeral(grand_total).format("0,0"));
        }
    </script>
@endsection
