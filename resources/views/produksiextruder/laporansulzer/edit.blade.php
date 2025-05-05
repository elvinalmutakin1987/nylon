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
                            <li class="breadcrumb-item">Laporan Sulzer</li>
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
                        <form action="{{ route('produksiextruder.laporansulzer.store') }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            @method('POST')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Laporan Sulzer</h3>
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mesin_id">Mesin</label>
                                                <input type="text"
                                                    class="form-control @error('mesin_id') is-invalid @enderror"
                                                    id="nama_mesin" name="nama_mesin" value="{{ $mesin->nama }}" readonly>
                                                <input type="hidden" name="mesin_id" id="mesin_id"
                                                    value="{{ $mesin_id }}">
                                                @error('mesin_id')
                                                    <span id="shift-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="jenis_produksi">Jenis Produksi</label>
                                                <input type="text"
                                                    class="form-control @error('jenis_produksi') is-invalid @enderror"
                                                    id="jenis_produksi" name="jenis_produksi"
                                                    value="{{ old('jenis_produksi') ?? $laporansulzer->jenis_produksi }}">
                                                @error('jenis_produksi')
                                                    <span id="shift-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="table1" class="table projects table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" colspan="2">Hasil Meter</th>
                                                        <th class="text-center" rowspan="2">Keterangan <br> Trobel
                                                            Produksi</th>
                                                        <th class="text-center" rowspan="2">Keterangan <br> Trobel
                                                            Mesin/Rusak</th>
                                                        <th class="text-center" colspan="2">Jam</th>
                                                        <th style="width: 50px" class="text-center"></th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-center">Meter Awal</th>
                                                        <th class="text-center">Meter Akhir</th>
                                                        <th class="text-center">Stop</th>
                                                        <th class="text-center">Jalan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($laporansulzer->laporansulzerdetail as $d)
                                                        @if ($loop->last)
                                                            <tr>
                                                                <td style="vertical-align: top">
                                                                    <input type="text"
                                                                        class="form-control @error('meter_awal') is-invalid @enderror"
                                                                        id="meter_awal1" name="meter_awal[]"
                                                                        value="{{ $d->meter_awal ? Number::format($d->meter_awal) : null }}"
                                                                        onkeyup="ubah_format('meter_awal1', this.value)">
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <input type="text"
                                                                        class="form-control @error('meter_akhir') is-invalid @enderror"
                                                                        id="meter_akhir1" name="meter_akhir[]"
                                                                        value="{{ $d->meter_akhir ? Number::format($d->meter_akhir) : null }}"
                                                                        onkeyup="ubah_format('meter_akhir1', this.value)">
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <textarea class="form-control @error('keterangan_produksi') is-invalid @enderror" rows="5"
                                                                        id="keterangan_produksi1" name="keterangan_produksi[]">{!! $d->keterangan_produksi !!}</textarea>
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <textarea class="form-control @error('keterangan_mesin') is-invalid @enderror" rows="5" id="keterangan_mesin1"
                                                                        name="keterangan_mesin[]">{!! $d->keterangan_mesin !!}</textarea>
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <div class="input-group date" id="div_jam_stop1"
                                                                        data-target-input="nearest">
                                                                        <input type="text"
                                                                            class="form-control datetimepicker-input"
                                                                            data-target="#div_jam_stop1" id="jam_stop1"
                                                                            name="jam_stop[]"
                                                                            value="{{ $d->jam_stop }}" />
                                                                        <div class="input-group-append"
                                                                            data-target="#div_jam_stop1"
                                                                            data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i
                                                                                    class="fa fa-clock"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <div class="input-group date" id="div_jam_jalan1"
                                                                        data-target-input="nearest">
                                                                        <input type="text"
                                                                            class="form-control datetimepicker-input"
                                                                            data-target="#div_jam_jalan1" id="jam_jalan1"
                                                                            name="jam_jalan[]"
                                                                            value="{{ $d->jam_jalan }}" />
                                                                        <div class="input-group-append"
                                                                            data-target="#div_jam_jalan1"
                                                                            data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i
                                                                                    class="fa fa-clock"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <button type="button" class="btn btn-primary"
                                                                        onclick="tambah()"><i class="fa fa-plus"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <td style="vertical-align: top">
                                                                    <input type="text"
                                                                        class="form-control @error('meter_awal') is-invalid @enderror"
                                                                        id="meter_awal{{ $d->slug }}"
                                                                        name="meter_awal[]"
                                                                        value="{{ $d->meter_awal ? Number::format($d->meter_awal) : null }}"
                                                                        onkeyup="ubah_format('meter_awal{{ $d->slug }}', this.value)">
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <input type="text"
                                                                        class="form-control @error('meter_akhir') is-invalid @enderror"
                                                                        id="meter_akhir{{ $d->slug }}"
                                                                        name="meter_akhir[]"
                                                                        value="{{ $d->meter_akhir ? Number::format($d->meter_akhir) : null }}"
                                                                        onkeyup="ubah_format('meter_akhir{{ $d->slug }}', this.value)">
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <textarea class="form-control @error('keterangan_produksi') is-invalid @enderror" rows="5"
                                                                        id="keterangan_produksi{{ $d->slug }}" name="keterangan_produksi[]">{!! $d->keterangan_produksi !!}</textarea>
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <textarea class="form-control @error('keterangan_mesin') is-invalid @enderror" rows="5"
                                                                        id="keterangan_mesin{{ $d->slug }}" name="keterangan_mesin[]">{!! $d->keterangan_mesin !!}</textarea>
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <div class="input-group date"
                                                                        id="div_jam_stop{{ $d->slug }}"
                                                                        data-target-input="nearest">
                                                                        <input type="text"
                                                                            class="form-control datetimepicker-input"
                                                                            data-target="#div_jam_stop{{ $d->slug }}"
                                                                            id="jam_stop{{ $d->slug }}"
                                                                            name="jam_stop[]"
                                                                            value="{{ $d->jam_stop }}" />
                                                                        <div class="input-group-append"
                                                                            data-target="#div_jam_stop{{ $d->slug }}"
                                                                            data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i
                                                                                    class="fa fa-clock"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td style="vertical-align: top">
                                                                    <div class="input-group date"
                                                                        id="div_jam_jalan{{ $d->slug }}"
                                                                        data-target-input="nearest">
                                                                        <input type="text"
                                                                            class="form-control datetimepicker-input"
                                                                            data-target="#div_jam_jalan{{ $d->slug }}"
                                                                            id="jam_jalan{{ $d->slug }}"
                                                                            name="jam_jalan[]"
                                                                            value="{{ $d->jam_jalan }}" />
                                                                        <div class="input-group-append"
                                                                            data-target="#div_jam_jalan{{ $d->slug }}"
                                                                            data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i
                                                                                    class="fa fa-clock"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center" style="vertical-align: top">
                                                                    <button type="button" class="btn btn-danger"
                                                                        id="hapus"><i class="fa fa-trash"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    @if (count($laporansulzer->laporansulzerdetail) == 0)
                                                        <tr>
                                                            <td style="vertical-align: top">
                                                                <input type="text"
                                                                    class="form-control @error('meter_awal') is-invalid @enderror"
                                                                    id="meter_awal1" name="meter_awal[]"
                                                                    onkeyup="ubah_format('meter_awal1', this.value)">
                                                            </td>
                                                            <td style="vertical-align: top">
                                                                <input type="text"
                                                                    class="form-control @error('meter_akhir') is-invalid @enderror"
                                                                    id="meter_akhir1" name="meter_akhir[]"
                                                                    onkeyup="ubah_format('meter_akhir1', this.value)">
                                                            </td>
                                                            <td style="vertical-align: top">
                                                                <textarea class="form-control @error('keterangan_produksi') is-invalid @enderror" rows="5"
                                                                    id="keterangan_produksi1" name="keterangan_produksi[]"></textarea>
                                                            </td>
                                                            <td style="vertical-align: top">
                                                                <textarea class="form-control @error('keterangan_mesin') is-invalid @enderror" rows="5" id="keterangan_mesin1"
                                                                    name="keterangan_mesin[]"></textarea>
                                                            </td>
                                                            <td style="vertical-align: top">
                                                                <div class="input-group date" id="div_jam_stop1"
                                                                    data-target-input="nearest">
                                                                    <input type="text"
                                                                        class="form-control datetimepicker-input"
                                                                        data-target="#div_jam_stop1" id="jam_stop1"
                                                                        name="jam_stop[]" />
                                                                    <div class="input-group-append"
                                                                        data-target="#div_jam_stop1"
                                                                        data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i
                                                                                class="fa fa-clock"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td style="vertical-align: top">
                                                                <div class="input-group date" id="div_jam_jalan1"
                                                                    data-target-input="nearest">
                                                                    <input type="text"
                                                                        class="form-control datetimepicker-input"
                                                                        data-target="#div_jam_jalan1" id="jam_jalan1"
                                                                        name="jam_jalan[]" />
                                                                    <div class="input-group-append"
                                                                        data-target="#div_jam_jalan1"
                                                                        data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i
                                                                                class="fa fa-clock"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td style="vertical-align: top">
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
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="button" class="btn btn-default"
                                        href="{{ route('produksiextruder.laporansulzer.index') }}"><i
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
                format: 'h:m:s'
            });

            $('#div_jam_jalan1').datetimepicker({
                format: 'h:m:s'
            });

            @foreach ($laporansulzer->laporansulzerdetail as $d)
                $('#div_jam_stop{{ $d->slug }}').datetimepicker({
                    format: 'h:m:s'
                });

                $('#div_jam_jalan{{ $d->slug }}').datetimepicker({
                    format: 'h:m:s'
                });
            @endforeach

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
                    url: '{{ route('produksiextruder.laporansulzer.get_mesin') }}',
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
            var keterangan_produksi = $("#keterangan_produksi1").val();
            var keterangan_mesin = $("#keterangan_mesin1").val();
            var jam_stop = $("#jam_stop1").val();
            var jam_jalan = $("#jam_jalan1").val();
            $("#table1 > tbody > tr:last").before(`
                <tr>
                    <td style="vertical-align: top">
                        <input type="text"
                            class="form-control @error('meter_awal') is-invalid @enderror"
                            id="meter_awal${row_id}" name="meter_awal[]" value="${meter_awal}">
                    </td>
                    <td style="vertical-align: top">
                        <input type="text"
                            class="form-control @error('meter_akhir') is-invalid @enderror"
                            id="meter_akhir${row_id}"
                            name="meter_akhir[]" value="${meter_akhir}">
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
                        <div class="input-group date"
                            id="div_jam_stop${row_id}"
                            data-target-input="nearest">
                            <input type="text"
                                class="form-control datetimepicker-input"
                                data-target="#div_jam_stop${row_id}"
                                id="jam_stop${row_id}"
                                name="jam_stop[]" value="${jam_stop}"/>
                            <div class="input-group-append"
                                data-target="#div_jam_stop${row_id}"
                                data-toggle="datetimepicker">
                                <div class="input-group-text"><i
                                        class="fa fa-clock"></i>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td style="vertical-align: top">
                        <div class="input-group date"
                            id="div_jam_jalan${row_id}"
                            data-target-input="nearest">
                            <input type="text"
                                class="form-control datetimepicker-input"
                                data-target="#div_jam_jalan${row_id}"
                                id="jam_jalan${row_id}"
                                name="jam_jalan[]" value="${jam_jalan}"/>
                            <div class="input-group-append"
                                data-target="#div_jam_jalan${row_id}"
                                data-toggle="datetimepicker">
                                <div class="input-group-text"><i
                                        class="fa fa-clock"></i>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="text-center" style="vertical-align: top">
                        <button type="button" class="btn btn-danger"
                            id="hapus"><i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
            $("#meter_awal1").val("");
            $("#meter_akhir1").val("");
            $("#keterangan_produksi1").val("");
            $("#keterangan_mesin1").val("");
            $("#jam_stop1").val("");
            $("#jam_jalan1").val("");
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
    </script>
@endsection
