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
                            <li class="breadcrumb-item">Laporan Beaming</li>
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
                        <form action="{{ route('produksiextruder.laporanbeaming.store') }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            @method('POST')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Laporan Beaming</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="beam_number">Beam Number</label>
                                                <input type="text"
                                                    class="form-control @error('beam_number') is-invalid @enderror"
                                                    id="beam_number" name="beam_number"
                                                    value="{{ old('beam_number') ?? $beam_number }}" readonly>
                                                @error('beam_number')
                                                    <span id="beam_number-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="jenis_produksi">Jenis Produksi</label>
                                                <input type="text"
                                                    class="form-control @error('jenis_produksi') is-invalid @enderror"
                                                    id="jenis_produksi" name="jenis_produksi"
                                                    value="{{ old('jenis_produksi') ?? $jenis_produksi }}" readonly>
                                                @error('jenis_produksi')
                                                    <span id="jenis_produksi-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="button" class="btn btn-default"
                                        href="{{ route('produksiextruder.laporanbeaming.index') }}"><i
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
                    url: '{{ route('produksiextruder.laporanbeaming.get_mesin') }}',
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
            $("#table1 > tbody > tr:last").before(`
            <tr>
                <td class="text-center" style="vertical-align: top">
                    <button type="button" class="btn btn-danger"
                        id="hapus"><i class="fa fa-trash"></i>
                    </button>
                </td>
                <td style="vertical-align: top">
                    <select
                        class="form-control select2 w-100 select-mesin @error('mesin_id${row_id}') is-invalid @enderror"
                        id="mesin_id${row_id}" name="mesin_id[]">
                        <option value="${mesin_id}">${mesin}</option>
                    </select>
                </td>
                <td style="vertical-align: top">
                    <select
                        class="form-control select2 w-100 select-jenis-produksi @error('jenis_produksi${row_id}') is-invalid @enderror"
                        id="jenis_produksi${row_id}" name="jenis_produksi[]">
                        <option value="${jenis_produksi}">
                            ${jenis_produksi}</option>
                    </select>
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
