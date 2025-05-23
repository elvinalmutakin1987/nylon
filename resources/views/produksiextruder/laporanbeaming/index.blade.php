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
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Laporan Beaming</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
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
                                                <span id="nama-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="beam_number">Beam Number</label>
                                            <div class="input-group date" id="beam_number" data-target-input="nearest">
                                                <input type="text"
                                                    class="form-control @error('beam_number') is-invalid @enderror"
                                                    id="beam_number" name="beam_number">
                                            </div>
                                            @error('tanggal')
                                                <span id="beam_number-error"
                                                    class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="jenis_produksi">Jenis Produksi</label>
                                            <select
                                                class="form-control select2 w-100 select-shift @error('jenis_produksi') is-invalid @enderror"
                                                id="jenis_produksi" name="jenis_produksi">
                                                <option value="GCGU/ GCBU">
                                                    GCGU/ GCBU</option>
                                                <option value="Wistaria">
                                                    Wistaria</option>
                                                <option value="30070i">
                                                    30070i</option>
                                                <option value="Natalia Phinisi (rajutan 12)">
                                                    Natalia Phinisi (rajutan 12)</option>
                                                <option value="Natalia Phinisi (rajutan 11)">
                                                    Natalia Phinisi (rajutan 11)</option>
                                                <option value="Natalia Standard">
                                                    Natalia Standard</option>
                                                <option value="CWU">
                                                    CWU</option>
                                                <option value="PWU">
                                                    PWU</option>
                                            </select>
                                            @error('jenis_produksi')
                                                <span id="jenis_produksi-error"
                                                    class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#modal-import" onclick="cek_laporan_beaming()"><i
                                                class="fa fa-plus"></i>
                                            Cek Laporan Beaming</button>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a type="button" class="btn btn-default" href="{{ route('produksi.index') }}"><i
                                        class="fa fa-reply"></i>
                                    Kembali</a>
                            </div>
                        </div>
                        <!-- /.card -->
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
            });
        }

        function ubah_format(field, nilai) {
            var mynumeral = numeral(nilai).format('0,0.0');
            $("#" + field).val(mynumeral);
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

        function cek_laporan_beaming() {
            var url =
                '{!! route('produksiextruder.laporanbeaming.create', [
                    'tanggal' => '_tanggal',
                    'jenis_produksi' => '_jenis_produksi',
                    'beam_number' => '_beam_number',
                ]) !!}';
            url = url.replace('_tanggal', $("#tanggal").val());
            url = url.replace('_jenis_produksi', $("#jenis_produksi").val());
            url = url.replace('_beam_number', $("#beam_number").val());
            window.open(url, "_self");
        }
    </script>
@endsection
