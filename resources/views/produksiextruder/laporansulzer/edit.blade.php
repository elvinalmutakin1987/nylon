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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="meter_awal">Meter Awal</label>
                                                <input type="text"
                                                    class="form-control @error('meter_awal') is-invalid @enderror"
                                                    id="meter_awal" name="meter_awal"
                                                    value="{{ old('meter_awal') ?? $laporansulzer->meter_awal }}">
                                                @error('meter_awal')
                                                    <span id="meter_awal-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="meter_akhir">Meter Akhir</label>
                                                <input type="text"
                                                    class="form-control @error('meter_akhir') is-invalid @enderror"
                                                    id="meter_akhir" name="meter_akhir"
                                                    value="{{ old('meter_akhir') ?? $laporansulzer->meter_akhir }}">
                                                @error('meter_akhir')
                                                    <span id="meter_akhir-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="keterangan_produksi">Keterangan Trobel Produksi</label>
                                                <textarea class="form-control @error('keterangan_produksi') is-invalid @enderror" rows="5"
                                                    id="keterangan_produksi" name="keterangan_produksi">{!! old('keterangan_produksi') ?? $laporansulzer->keterangan_produksi !!}</textarea>
                                                @error('keterangan_produksi')
                                                    <span id="keterangan_produksi-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="keterangan_mesin">Keterangan Trobel Mesin</label>
                                                <textarea class="form-control @error('keterangan_mesin') is-invalid @enderror" rows="5" id="keterangan_mesin"
                                                    name="keterangan_mesin">{!! old('keterangan_mesin') ?? $laporansulzer->keterangan_mesin !!}</textarea>
                                                @error('keterangan_mesin')
                                                    <span id="keterangan_mesin-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="jam_stop">Stop</label>
                                                <div class="input-group date" id="div_jam_stop"
                                                    data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        data-target="#div_jam_stop" id="jam_stop" name="jam_stop"
                                                        value="{{ $laporansulzer->jam_stop ?? null }}" />
                                                    <div class="input-group-append" data-target="#div_jam_stop"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-clock"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('jam_stop')
                                                    <span id="jam_stop-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="jam_jalan">Jalan</label>
                                                <div class="input-group date" id="div_jam_jalan"
                                                    data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        data-target="#div_jam_jalan" id="jam_jalan" name="jam_jalan"
                                                        value="{{ $laporansulzer->jam_jalan ?? null }}" />
                                                    <div class="input-group-append" data-target="#div_jam_jalan"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-clock"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('jam_jalan')
                                                    <span id="jam_jalan-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
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
            $('#div_jam_stop').datetimepicker({
                format: 'h:m:s'
            });

            $('#div_jam_jalan').datetimepicker({
                format: 'h:m:s'
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
            $("#table1 > tbody > tr:last").before(`
                <tr>
                    <td>
                        <input type="text" class="form-control" id="meter${row_id}"
                            name="meter[]" onblur="ubah_format('meter${row_id}', this.value)">
                    </td>
                    <td>
                        <input type="text" class="form-control w-100"
                            id="kerusakan${row_id}" name="kerusakan[]">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger" id="hapus"><i
                                class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);

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
