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
                            <li class="breadcrumb-item">Check List Beaming</li>
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
                        <form action="{{ route('produksiextruder.checklistbeaming.store') }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            @method('POST')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Check List Beaming</h3>
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
                                            <div class="form-group">
                                                <label for="">Motif Sesuai</label>
                                                <div class="form-check d-inline m-4">
                                                    <input type="checkbox" class="form-check-input" id="motif_sesuai_1"
                                                        name="motif_sesuai_1">
                                                    <label class="form-check-label" for="motif_sesuai_1">1</label>
                                                </div>
                                                <div class="form-check d-inline m-4">
                                                    <input type="checkbox" class="form-check-input" id="motif_sesuai_2"
                                                        name="motif_sesuai_2">
                                                    <label class="form-check-label" for="motif_sesuai_2">2</label>
                                                </div>
                                                <div class="form-check d-inline m-4">
                                                    <input type="checkbox" class="form-check-input" id="motif_sesuai_3"
                                                        name="motif_sesuai_3">
                                                    <label class="form-check-label" for="motif_sesuai_3">3</label>
                                                </div>
                                                <div class="form-check d-inline m-4">
                                                    <input type="checkbox" class="form-check-input" id="motif_sesuai_4"
                                                        name="motif_sesuai_4">
                                                    <label class="form-check-label" for="motif_sesuai_4">4</label>
                                                </div>
                                                <div class="form-check d-inline m-4">
                                                    <input type="checkbox" class="form-check-input" id="motif_sesuai_5"
                                                        name="motif_sesuai_5">
                                                    <label class="form-check-label" for="motif_sesuai_5">5</label>
                                                </div>
                                                <div class="form-check d-inline m-4">
                                                    <input type="checkbox" class="form-check-input" id="motif_sesuai_6"
                                                        name="motif_sesuai_6">
                                                    <label class="form-check-label" for="motif_sesuai_6">6</label>
                                                </div>
                                                <div class="form-check d-inline m-4">
                                                    <input type="checkbox" class="form-check-input" id="motif_sesuai_7"
                                                        name="motif_sesuai_7">
                                                    <label class="form-check-label" for="motif_sesuai_7">7</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive p-0">
                                                <table id="table1" class="table projects table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="text-center" style="width: 30%">
                                                                Lingkaran (M)
                                                            </th>
                                                            <th scope="col" class="text-center" style="width: 30%">
                                                                Nilai (cm)
                                                            </th>
                                                            <th scope="col" class="text-center" style="width: 30%">
                                                                Waktu
                                                            </th>
                                                            <th style="width: 10%">

                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    id="diameter_beam_timur1" name="diameter_beam_timur[]"
                                                                    onblur="ubah_format('diameter_beam_timur1', this.value)">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    id="diameter_beam_barat1" name="diameter_beam_barat[]"
                                                                    onblur="ubah_format('diameter_beam_barat1', this.value)">
                                                            </td>
                                                            <td>
                                                                <div class="input-group date"
                                                                    id="div_diameter_beam_1m_dari_timur1"
                                                                    data-target-input="nearest">
                                                                    <input type="text"
                                                                        class="form-control datetimepicker-input"
                                                                        data-target="#div_diameter_beam_1m_dari_timur1"
                                                                        id="diameter_beam_1m_dari_timur1"
                                                                        name="diameter_beam_1m_dari_timur[]" />
                                                                </div>
                                                            </td>
                                                            <td class="text-center">
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="jumlah_benang_putus">Jumlah Benang Putus</label>
                                                    <input type="text"
                                                        class="form-control @error('jumlah_benang_putus') is-invalid @enderror"
                                                        id="jumlah_benang_putus" name="jumlah_benang_putus"
                                                        value="{{ old('jumlah_benang_putus') }}"
                                                        onblur="ubah_format('jumlah_benang_putus', this.value)">
                                                    @error('jumlah_benang_putus')
                                                        <span id="jumlah_benang_putus-error"
                                                            class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="jumlah_benang">Jumlah Benang</label>
                                                <input type="text"
                                                    class="form-control @error('jumlah_benang') is-invalid @enderror"
                                                    id="jumlah_benang" name="jumlah_benang"
                                                    value="{{ old('jumlah_benang') }}"
                                                    onblur="ubah_format('jumlah_benang', this.value)">
                                                @error('jumlah_benang')
                                                    <span id="jumlah_benang-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="produksi">Produksi</label>
                                                    <input type="text"
                                                        class="form-control @error('produksi') is-invalid @enderror"
                                                        id="produksi" name="produksi" value="{{ old('produksi') }}">
                                                    @error('produksi')
                                                        <span id="produksi-error"
                                                            class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lebar_beam">Lebar Beam</label>
                                                <input type="text"
                                                    class="form-control @error('lebar_beam') is-invalid @enderror"
                                                    id="lebar_beam" name="lebar_beam">
                                                @error('lebar_beam')
                                                    <span id="lebar_beam-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="button" class="btn btn-default"
                                        href="{{ route('produksiextruder.checklistbeaming.index') }}"><i
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
            $('#div_diameter_beam_1m_dari_timur1').datetimepicker({
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
            var diameter_beam_timur1 = $("#diameter_beam_timur1").val();
            var diameter_beam_barat1 = $("#diameter_beam_barat1").val();
            var diameter_beam_1m_dari_timur1 = $("#diameter_beam_1m_dari_timur1").val();
            $("#table1 > tbody > tr:last").before(`
                <tr>
                    <td>
                        <input type="text" class="form-control"
                            id="diameter_beam_timur${row_id}" name="diameter_beam_timur[]"
                            onblur="ubah_format('diameter_beam_timur${row_id}', this.value)"
                            value="${diameter_beam_timur1}">
                    </td>
                    <td>
                        <input type="text" class="form-control"
                            id="diameter_beam_barat${row_id}" name="diameter_beam_barat[]"
                            onblur="ubah_format('diameter_beam_barat${row_id}', this.value)"
                            value="${diameter_beam_barat1}">
                    </td>
                    <td>
                        <div class="input-group date"
                            id="div_diameter_beam_1m_dari_timur${row_id}"
                            data-target-input="nearest">
                            <input type="text"
                                class="form-control datetimepicker-input"
                                data-target="#div_diameter_beam_1m_dari_timur${row_id}"
                                id="diameter_beam_1m_dari_timur${row_id}"
                                name="diameter_beam_1m_dari_timur[]"
                                value="${diameter_beam_1m_dari_timur1}"/>
                        </div>
                    </td>
                    <td class="text-center">
                       <button type="button" class="btn btn-danger"
                            id="hapus"><i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
            $("#diameter_beam_timur1").val("");
            $("#diameter_beam_barat1").val("");
            $("#div_diameter_beam_1m_dari_timur" + row_id).datetimepicker({
                format: 'HH:mm',
            });
            $("#diameter_beam_1m_dari_timur1").val(null);

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
