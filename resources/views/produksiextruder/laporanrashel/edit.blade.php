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
                            <li class="breadcrumb-item">Laporan Rashel</li>
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
                        <form action="{{ route('produksiextruder.laporanrashel.store') }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            @method('POST')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Laporan Rashel</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="tanggal">Tanggal</label>
                                                    <input type="text"
                                                        class="form-control @error('tanggal') is-invalid @enderror"
                                                        id="tanggal" name="tanggal"
                                                        value="{{ old('tanggal') ?? $tanggal }}" readonly>
                                                    @error('tanggal')
                                                        <span id="tanggal-error"
                                                            class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="shift">Shift</label>
                                                <input type="text"
                                                    class="form-control @error('shift') is-invalid @enderror" id="shift"
                                                    name="shift" value="{{ old('shift') ?? $shift }}" readonly>
                                                @error('shift')
                                                    <span id="shift-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive p-0">
                                                <table id="table1" class="table projects table-bordered table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center"></th>
                                                            <th class="text-center" style="width: 150px">
                                                                Mesin
                                                            </th>
                                                            <th class="text-center" style="width: 150px">
                                                                Jenis
                                                                Produksi
                                                            </th>
                                                            <th class="text-center" style="width: 150px">
                                                                Operator
                                                            </th>
                                                            <th class="text-center">Hasil Meter</th>
                                                            <th class="text-center">Keterangan <br> Trobel
                                                                Produksi</th>
                                                            <th class="text-center">Keterangan <br> Trobel
                                                                Mesin/Rusak</th>
                                                            <th class="text-center">Jam</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($laporanrashel->laporanrasheldetail as $d)
                                                            @if ($loop->last)
                                                                <tr>
                                                                    <td style="vertical-align: top">
                                                                        <button type="button" class="btn btn-primary"
                                                                            onclick="tambah()"><i class="fa fa-plus"></i>
                                                                        </button>
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <select
                                                                            class="form-control select2 w-100 select-mesin @error('mesin_id') is-invalid @enderror"
                                                                            id="mesin_id1" name="mesin_id[]">
                                                                            <option value="{{ $d->mesin_id }}">
                                                                                {{ $d->mesin->nama }}</option>
                                                                        </select>
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <select
                                                                            class="form-control select2 w-100 select-jenis-produksi @error('jenis_produksi') is-invalid @enderror"
                                                                            id="jenis_produksi1" name="jenis_produksi[]">
                                                                            <option value="⁠RH3/ 2.150"
                                                                                {{ $d->jenis_produksi == '⁠RH3/ 2.150' ? 'selected' : '' }}>
                                                                                ⁠RH3/ 2.150</option>
                                                                        </select>
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <input type="text"
                                                                            class="form-control @error('operator') is-invalid @enderror"
                                                                            id="operator1" name="operator[]"
                                                                            value="{{ $d->operator }}">
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <label for="meter_awal1">Meter
                                                                            Awal</label>
                                                                        <input type="text"
                                                                            class="form-control @error('meter_awal') is-invalid @enderror"
                                                                            id="meter_awal1" name="meter_awal[]"
                                                                            value="{{ $d->meter_awal ? Number::format($d->meter_awal) : null }}"
                                                                            onkeyup="ubah_format('meter_awal1', this.value); hitung_hasil('1')">
                                                                        <br>
                                                                        <label for="meter_akhir1">Meter
                                                                            Akhir</label>
                                                                        <input type="text"
                                                                            class="form-control @error('meter_akhir') is-invalid @enderror"
                                                                            id="meter_akhir1" name="meter_akhir[]"
                                                                            value="{{ $d->meter_akhir ? Number::format($d->meter_akhir) : null }}"
                                                                            onkeyup="ubah_format('meter_akhir1', this.value); hitung_hasil('1')">
                                                                        <br>
                                                                        <label for="hasil1">Hasil</label>
                                                                        <input type="text"
                                                                            class="form-control @error('hasil') is-invalid @enderror"
                                                                            id="hasil1" name="hasil[]"
                                                                            value="{{ $d->hasil ? Number::format($d->hasil) : null }}"
                                                                            onkeyup="ubah_format('hasil1', this.value)">
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <textarea class="form-control @error('keterangan_produksi') is-invalid @enderror" rows="10"
                                                                            id="keterangan_produksi1" name="keterangan_produksi[]">{!! $d->keterangan_produksi !!}</textarea>
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <textarea class="form-control @error('keterangan_mesin') is-invalid @enderror" rows="10" id="keterangan_mesin1"
                                                                            name="keterangan_mesin[]">{!! $d->keterangan_mesin !!}</textarea>
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <label for="div_jam_stop1">Jam
                                                                            Stop</label>
                                                                        <div class="input-group date" id="div_jam_stop1"
                                                                            data-target-input="nearest">
                                                                            <input type="text"
                                                                                class="form-control datetimepicker-input"
                                                                                data-target="#div_jam_stop1"
                                                                                id="jam_stop1" name="jam_stop[]"
                                                                                value="{{ $d->jam_stop }}" />
                                                                        </div>
                                                                        <br>
                                                                        <label for="div_jam_stop1">Jam
                                                                            Jalan</label>
                                                                        <div class="input-group date" id="div_jam_jalan1"
                                                                            data-target-input="nearest">
                                                                            <input type="text"
                                                                                class="form-control datetimepicker-input"
                                                                                data-target="#div_jam_jalan1"
                                                                                id="jam_jalan1" name="jam_jalan[]"
                                                                                value="{{ $d->jam_jalan }}" />
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @else
                                                                <tr>
                                                                    <td class="text-center" style="vertical-align: top">
                                                                        <button type="button" class="btn btn-danger"
                                                                            id="hapus"><i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <select
                                                                            class="form-control select2 w-100 select-mesin @error('mesin_id') is-invalid @enderror"
                                                                            id="mesin_id{{ $d->slug }}"
                                                                            name="mesin_id[]">
                                                                            <option value="{{ $d->mesin_id }}">
                                                                                {{ $d->mesin->nama }}</option>
                                                                        </select>
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <select
                                                                            class="form-control select2 w-100 select-jenis-produksi @error('jenis_produksi') is-invalid @enderror"
                                                                            id="jenis_produksi{{ $d->slug }}"
                                                                            name="jenis_produksi[]">
                                                                            <option value="⁠RH3/ 2.150"
                                                                                {{ $d->jenis_produksi == '⁠RH3/ 2.150' ? 'selected' : '' }}>
                                                                                ⁠RH3/ 2.150</option>
                                                                        </select>
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <input type="text"
                                                                            class="form-control @error('operator') is-invalid @enderror"
                                                                            id="operator{{ $d->slug }}"
                                                                            name="operator[]"
                                                                            value="{{ $d->operator }}">
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <label for="meter_awal{{ $d->slug }}">Meter
                                                                            Awal</label>
                                                                        <input type="text"
                                                                            class="form-control @error('meter_awal') is-invalid @enderror"
                                                                            id="meter_awal{{ $d->slug }}"
                                                                            name="meter_awal[]"
                                                                            value="{{ $d->meter_awal ? Number::format($d->meter_awal) : null }}"
                                                                            onkeyup="ubah_format('meter_awal{{ $d->slug }}', this.value); hitung_hasil('{{ $d->slug }}')">
                                                                        <br>
                                                                        <label for="meter_akhir{{ $d->slug }}">Meter
                                                                            Akhir</label>
                                                                        <input type="text"
                                                                            class="form-control @error('meter_akhir') is-invalid @enderror"
                                                                            id="meter_akhir{{ $d->slug }}"
                                                                            name="meter_akhir[]"
                                                                            value="{{ $d->meter_akhir ? Number::format($d->meter_akhir) : null }}"
                                                                            onkeyup="ubah_format('meter_akhir{{ $d->slug }}', this.value); hitung_hasil('{{ $d->slug }}')">
                                                                        <br>
                                                                        <label
                                                                            for="hasil{{ $d->slug }}">Hasil</label>
                                                                        <input type="text"
                                                                            class="form-control @error('hasil') is-invalid @enderror"
                                                                            id="hasil{{ $d->slug }}" name="hasil[]"
                                                                            value="{{ $d->hasil ? Number::format($d->hasil) : null }}"
                                                                            onkeyup="ubah_format('hasil{{ $d->slug }}', this.value)">
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <textarea class="form-control @error('keterangan_produksi') is-invalid @enderror" rows="10"
                                                                            id="keterangan_produksi{{ $d->slug }}" name="keterangan_produksi[]">{!! $d->keterangan_produksi !!}</textarea>
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <textarea class="form-control @error('keterangan_mesin') is-invalid @enderror" rows="10"
                                                                            id="keterangan_mesin{{ $d->slug }}" name="keterangan_mesin[]">{!! $d->keterangan_mesin !!}</textarea>
                                                                    </td>
                                                                    <td style="vertical-align: top">
                                                                        <label for="div_jam_stop{{ $d->slug }}">Jam
                                                                            Stop</label>
                                                                        <div class="input-group date"
                                                                            id="div_jam_stop{{ $d->slug }}"
                                                                            data-target-input="nearest">
                                                                            <input type="text"
                                                                                class="form-control datetimepicker-input"
                                                                                data-target="#div_jam_stop{{ $d->slug }}"
                                                                                id="jam_stop{{ $d->slug }}"
                                                                                name="jam_stop[]"
                                                                                value="{{ $d->jam_stop }}" />
                                                                        </div>
                                                                        <br>
                                                                        <label for="div_jam_jalan{{ $d->slug }}">Jam
                                                                            Jalan</label>
                                                                        <div class="input-group date"
                                                                            id="div_jam_jalan{{ $d->slug }}"
                                                                            data-target-input="nearest">
                                                                            <input type="text"
                                                                                class="form-control datetimepicker-input"
                                                                                data-target="#div_jam_jalan{{ $d->slug }}"
                                                                                id="jam_jalan{{ $d->slug }}"
                                                                                name="jam_jalan[]"
                                                                                value="{{ $d->jam_jalan }}" />
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        @if (count($laporanrashel->laporanrasheldetail) == 0)
                                                            <tr>
                                                                <td style="vertical-align: top">
                                                                    <button type="button" class="btn btn-primary"
                                                                        onclick="tambah()"><i class="fa fa-plus"></i>
                                                                    </button>
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <select
                                                                        class="form-control select2 w-100 select-mesin @error('mesin_id') is-invalid @enderror"
                                                                        id="mesin_id1" name="mesin_id[]">
                                                                    </select>
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <select
                                                                        class="form-control select2 w-100 select-jenis-produksi @error('jenis_produksi') is-invalid @enderror"
                                                                        id="jenis_produksi1" name="jenis_produksi[]">
                                                                        <option value="⁠RH3/ 2.150">
                                                                            ⁠RH3/ 2.150</option>
                                                                    </select>
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <input type="text"
                                                                        class="form-control @error('operator') is-invalid @enderror"
                                                                        id="operator1" name="operator[]">
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <label for="meter_awal1">Meter Awal</label>
                                                                    <input type="text"
                                                                        class="form-control @error('meter_awal') is-invalid @enderror"
                                                                        id="meter_awal1" name="meter_awal[]"
                                                                        onkeyup="ubah_format('meter_awal1', this.value); hitung_hasil('1')">
                                                                    <br>
                                                                    <label for="meter_akhir1">Meter Akhir</label>
                                                                    <input type="text"
                                                                        class="form-control @error('meter_akhir') is-invalid @enderror"
                                                                        id="meter_akhir1" name="meter_akhir[]"
                                                                        onkeyup="ubah_format('meter_akhir1', this.value); hitung_hasil('1')">
                                                                    <br>
                                                                    <label for="hasil1">Hasil</label>
                                                                    <input type="text"
                                                                        class="form-control @error('hasil') is-invalid @enderror"
                                                                        id="hasil1" name="hasil[]" readonly>
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <textarea class="form-control @error('keterangan_produksi') is-invalid @enderror" rows="10"
                                                                        id="keterangan_produksi1" name="keterangan_produksi[]"></textarea>
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <textarea class="form-control @error('keterangan_mesin') is-invalid @enderror" rows="10" id="keterangan_mesin1"
                                                                        name="keterangan_mesin[]"></textarea>
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <label for="div_jam_stop1">Jam Stop</label>
                                                                    <div class="input-group date" id="div_jam_stop1"
                                                                        data-target-input="nearest">
                                                                        <input type="text"
                                                                            class="form-control datetimepicker-input"
                                                                            data-target="#div_jam_stop1" id="jam_stop1"
                                                                            name="jam_stop[]" />
                                                                    </div>
                                                                    <br>
                                                                    <label for="div_jam_jalan1">Jam Jalan</label>
                                                                    <div class="input-group date" id="div_jam_jalan1"
                                                                        data-target-input="nearest">
                                                                        <input type="text"
                                                                            class="form-control datetimepicker-input"
                                                                            data-target="#div_jam_jalan1" id="jam_jalan1"
                                                                            name="jam_jalan[]" />
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="button" class="btn btn-default"
                                        href="{{ route('produksiextruder.laporanrashel.index') }}"><i
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
            $('#div_jam_stop1').datetimepicker({
                format: 'HH:mm',
            });

            $('#div_jam_jalan1').datetimepicker({
                format: 'HH:mm',
            });

            @foreach ($laporanrashel->laporanrasheldetail as $d)
                $('#div_jam_stop{{ $d->slug }}').datetimepicker({
                    format: 'HH:mm',
                });

                $('#div_jam_jalan{{ $d->slug }}').datetimepicker({
                    format: 'HH:mm',
                });
            @endforeach

            format_select2();
        });

        function format_select2() {
            $('.select-shift').select2({
                width: '100%',
                minimumResultsForSearch: -1,
            });

            $('.select-jenis-produksi').select2({
                width: '100%',
            });

            $('.select-mesin').select2({
                placeholder: "- Pilih Mesin -",
                allowClear: true,
                ajax: {
                    url: '{{ route('produksiextruder.laporanrashel.get_mesin') }}',
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

        function ubah_format(field, nilai) {
            var mynumeral = numeral(nilai).format('0,0');
            $("#" + field).val(mynumeral);
        }

        function tambah() {
            var tbody_row = $('#table1').find('tr').length;
            var row_id = Date.now().toString(36) + Math.random().toString(36).substr(2);
            var meter_awal = $("#meter_awal1").val();
            var meter_akhir = $("#meter_akhir1").val();
            var hasil = parseFloat(numeral(meter_akhir).format('0')) - parseFloat(numeral(meter_awal).format('0'));
            var keterangan_produksi = $("#keterangan_produksi1").val();
            var keterangan_mesin = $("#keterangan_mesin1").val();
            var jam_stop = $("#jam_stop1").val();
            var jam_jalan = $("#jam_jalan1").val();
            var mesin_id = $("#mesin_id1 option:selected").val();
            var mesin = $("#mesin_id1 option:selected").text();
            var jenis_produksi = $("#jenis_produksi1 option:selected").val();
            var operator = $("#operator1").val();
            $("#table1 > tbody > tr:last").before(`
                <tr>
                    <td class="text-center" style="vertical-align: top">
                        <button type="button" class="btn btn-danger"
                            id="hapus"><i class="fa fa-trash"></i>
                        </button>
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
                            class="form-control select2 w-100 select-jenis-produksi @error('jenis_produksi') is-invalid @enderror"
                            id="jenis_produksi${row_id}" name="jenis_produksi[]">
                            <option value="${jenis_produksi}">
                                ${jenis_produksi}</option>
                        </select>
                    </td>
                     <td style="vertical-align: top">
                        <input type="text"
                            class="form-control @error('operator') is-invalid @enderror"
                            id="operator${row_id}" name="operator[]">
                    </td>
                    <td style="vertical-align: top">
                        <label for="meter_awal${row_id}">Meter Awal</label>
                        <input type="text"
                            class="form-control @error('meter_awal') is-invalid @enderror"
                            id="meter_awal${row_id}" name="meter_awal[]" value="${meter_awal}" onkeyup="ubah_format('meter_awal${row_id}', this.value); hitung_hasil('${row_id}')">
                        <br>
                        <label for="meter_akhir${row_id}">Meter Akhir</label>
                        <input type="text"
                            class="form-control @error('meter_akhir') is-invalid @enderror"
                            id="meter_akhir${row_id}"
                            name="meter_akhir[]" value="${meter_akhir}" onkeyup="ubah_format('meter_akhir${row_id}', this.value); hitung_hasil('${row_id}')">
                        <br>
                        <label for="hasil${row_id}">Hasil</label>
                        <input type="text"
                            class="form-control @error('hasil') is-invalid @enderror"
                            id="hasil${row_id}"
                            name="hasil[]" value="${numeral(hasil).format('0,0')}" readonly>
                    </td>
                    <td style="vertical-align: top">
                        <textarea class="form-control @error('keterangan_produksi') is-invalid @enderror" rows="5"
                            id="keterangan_produksi${row_id}" name="keterangan_produksi[]">${keterangan_produksi}</textarea>
                    </td>
                    <td style="vertical-align: top">
                        <textarea class="form-control @error('keterangan_mesin') is-invalid @enderror" rows="5"
                            id="keterangan_mesin${row_id}" name="keterangan_mesin[]">${keterangan_mesin}</textarea>
                    </td>
                    <td style="vertical-align: top">
                        <label for="div_jam_stop${row_id}">Jam Stop</label>
                        <div class="input-group date"
                            id="div_jam_stop${row_id}"
                            data-target-input="nearest">
                            <input type="text"
                                class="form-control datetimepicker-input"
                                data-target="#div_jam_stop${row_id}"
                                id="jam_stop${row_id}"
                                name="jam_stop[]" value="${jam_stop}"/>
                        </div>
                        <br>
                        <label for="div_jam_jalan${row_id}">Jam Jalan</label>
                        <div class="input-group date"
                            id="div_jam_jalan${row_id}"
                            data-target-input="nearest">
                            <input type="text"
                                class="form-control datetimepicker-input"
                                data-target="#div_jam_jalan${row_id}"
                                id="jam_jalan${row_id}"
                                name="jam_jalan[]" value="${jam_jalan}"/>
                        </div>
                    </td>
                </tr>
            `);
            $("#hasil1").val("");
            $("#mesin_id1").val(null).trigger('change');
            $("#jenis_produksi1").val(null).trigger('change');
            $("#meter_awal1").val("");
            $("#meter_akhir1").val("");
            $("#keterangan_produksi1").val("");
            $("#keterangan_mesin1").val("");
            $("#jam_stop1").val("");
            $("#jam_jalan1").val("");

            format_select2();
        }

        $("#table1").on("click", "#hapus", function() {
            $(this).closest("tr").remove();
        });

        @if (Session::has('message'))
            let timerInterval;
            Swal.fire({
                title: "{{ Session::get('message') }}",
                type: "{{ Session::get('status') }}",
                timer: 2000,
                icon: "{{ Session::get('status') }}",
                didOpen: () => {
                    timerInterval = setInterval(() => {}, 100)
                },
                willClose: () => {

                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {

                }
            });
        @endif

        function hitung_hasil(field) {
            var meter_awal = numeral($("#meter_awal" + field).val()).format('0');
            var meter_akhir = numeral($("#meter_akhir" + field).val()).format('0');
            var hasil = parseFloat(meter_akhir) - parseFloat(meter_awal);
            $("#hasil" + field).val(numeral(hasil).format('0,0'));
        }
    </script>
@endsection
