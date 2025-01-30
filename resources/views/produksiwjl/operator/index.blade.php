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
                            <li class="breadcrumb-item">WJL</li>
                            <li class="breadcrumb-item" Active>Laporan Produksi</li>
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
                        <form action="{{ route('produksiwjl.operator.store') }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            @method('post')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Laporan Produksi WJL</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="mesin_id">Mesin No.</label>
                                                <select
                                                    class="form-control select2 w-100 select-mesin @error('mesin_id') is-invalid @enderror"
                                                    id="mesin_id" name="mesin_id">
                                                </select>
                                                @error('mesin_id')
                                                    <span id="mesin_id-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="jenis_kain">Jenis Kain</label>
                                                <input type="text"
                                                    class="form-control @error('jenis_kain') is-invalid @enderror"
                                                    id="jenis_kain" name="jenis_kain" value="{{ old('jenis_kain') }}">
                                                @error('jenis_kain')
                                                    <span id="jenis_kain-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="meter_awal">Meter Awal</label>
                                                <input type="text"
                                                    class="form-control @error('meter_awal') is-invalid @enderror"
                                                    id="meter_awal" name="meter_awal" value="{{ old('meter_awal') }}"
                                                    onblur="ubah_format('meter_awal', this.value); hitung_hasil();">
                                                @error('meter_awal')
                                                    <span id="meter_awal-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="meter_akhir">Meter Akhir</label>
                                                <input type="text"
                                                    class="form-control @error('meter_akhir') is-invalid @enderror"
                                                    id="meter_akhir" name="meter_akhir" value="{{ old('meter_akhir') }}"
                                                    onblur="ubah_format('meter_akhir', this.value); hitung_hasil();">
                                                @error('meter_akhir')
                                                    <span id="meter_akhir-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="hasil">Hasil</label>
                                                <input type="text"
                                                    class="form-control @error('hasil') is-invalid @enderror"
                                                    id="hasil" name="hasil" value="{{ old('hasil') }}" readonly>
                                                @error('hasil')
                                                    <span id="hasil-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="keterangan">Keterangan</label>
                                                <textarea class="form-control @error('keterangan') is-invalid @enderror" rows="10" id="keterangan"
                                                    name="keterangan"></textarea>
                                                @error('keterangan')
                                                    <span id="keterangan-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="lungsi">Lungsi</label>
                                                <input type="text"
                                                    class="form-control @error('lungsi') is-invalid @enderror"
                                                    id="lungsi" name="lungsi" value="{{ old('lungsi') }}"
                                                    onblur="ubah_format('lungsi', this.value);">
                                                @error('lungsi')
                                                    <span id="meter_awal-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="pakan">Pakan</label>
                                                <input type="text"
                                                    class="form-control @error('pakan') is-invalid @enderror"
                                                    id="pakan" name="pakan" value="{{ old('pakan') }}"
                                                    onblur="ubah_format('pakan', this.value);">
                                                @error('pakan')
                                                    <span id="pakan-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="lubang">Lubang</label>
                                                <input type="text"
                                                    class="form-control @error('lubang') is-invalid @enderror"
                                                    id="lubang" name="lubang" value="{{ old('lubang') }}">
                                                @error('lubang')
                                                    <span id="lubang-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="pgr">PGR</label>
                                                <input type="text"
                                                    class="form-control @error('pgr') is-invalid @enderror"
                                                    id="pgr" name="pgr" value="{{ old('pgr') }}">
                                                @error('pgr')
                                                    <span id="meter_awal-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="lebar">Lebar</label>
                                                <input type="text"
                                                    class="form-control @error('lebar') is-invalid @enderror"
                                                    id="lebar" name="lebar" value="{{ old('lebar') }}"
                                                    onblur="ubah_format('lebar', this.value);">
                                                @error('lebar')
                                                    <span id="lebar-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="mesin">Mesin</label>
                                                <input type="text"
                                                    class="form-control @error('mesin') is-invalid @enderror"
                                                    id="mesin" name="mesin" value="{{ old('mesin') }}">
                                                @error('mesin')
                                                    <span id="mesin-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="teknisi">Teknisi</label>
                                                <input type="text"
                                                    class="form-control @error('teknisi') is-invalid @enderror"
                                                    id="teknisi" name="teknisi" value="{{ old('teknisi') }}">
                                                @error('teknisi')
                                                    <span id="mesin-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Dokumentasi</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="foto"
                                                            name="foto[]" multiple>
                                                        <label class="custom-file-label" for="foto">Pilih foto</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="button" class="btn btn-default" href="{{ route('produksi.index') }}"><i
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
                    url: '{{ route('produksiwjl.get_mesin') }}',
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
            var mynumeral = numeral(nilai).format('0,0.0');
            // if (field.includes('jumlah')) {
            //     mynumeral = numeral(nilai).format('0,0.0');
            // }
            $("#" + field).val(mynumeral);
        }

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
                            <option value="BOBIN">BOBIN</option>
                            <option value="PCS">PCS</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control" id="jumlah${row_id}"
                            name="jumlah[]" onblur="ubah_format('jumlah${row_id}', this.value)">
                    </td>
                    <td>
                        <input type="text" class="form-control" id="keterangan${row_id}"
                            name="keterangan_[]">
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

        $("#table1").on("click", "#hapus", function() {
            $(this).closest("tr").remove();
        });

        function hitung_hasil() {
            var meter_awal = numeral($("#meter_awal").val()).format('0.0');
            var meter_akhir = numeral($("#meter_akhir").val()).format('0.0');
            var hasil_ = parseFloat(meter_akhir) - parseFloat(meter_awal);
            var hasil = numeral(hasil_).format('0.0');
            $("#hasil").val(hasil);
        }

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
