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
                            <li class="breadcrumb-item"><a href="{{ route('laporan.index') }}" class="text-dark">Laporan</a>
                            </li>
                            <li class="breadcrumb-item">WJL</li>
                            <li class="breadcrumb-item active">Efisiensi</li>
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
                                <h3 class="card-title">Laporan Efisiensi</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="input-group date" id="div_tanggal_dari" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input"
                                                    data-target="#div_tanggal_dari" id="tanggal_dari" name="tanggal_dari"
                                                    value="{{ \Carbon\Carbon::now()->startOfMonth() }}" />
                                                <div class="input-group-append" data-target="#div_tanggal_dari"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <div class="input-group date" id="div_tanggal_sampai"
                                                data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input"
                                                    data-target="#div_tanggal_sampai" id="tanggal_sampai"
                                                    name="tanggal_sampai"
                                                    value="{{ \Carbon\Carbon::now()->endOfMonth() }}" />
                                                <div class="input-group-append" data-target="#div_tanggal_sampai"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <select
                                                class="form-control select2 w-100 select-bentuk @error('operator') is-invalid @enderror"
                                                id="operator" name="operator">
                                                @foreach ($operator as $d)
                                                    <option value="{{ $d->operator }}">{{ $d->operator }}</option>
                                                @endforeach
                                            </select>
                                            @error('jenis')
                                                <span id="jenis-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-secondary" onclick="get_data()"><i
                                                class="fa fa-search"></i>
                                            Cari</button>
                                        <button type="button" class="btn btn-primary" onclick="cetak()"><i
                                                class="fa fa-print"></i>
                                            Cetak</button>
                                        <button type="button" class="btn btn-success" onclick="export_()"><i
                                                class="fas fa-file-excel"></i>
                                            Export</button>
                                    </div>
                                    <div class="col-md-3">
                                        <a type="button" class="btn btn-secondary" href="{{ route('laporan.index') }}"><i
                                                class="fa fa-reply"></i> Kembali</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <form enctype="multipart/form-data" id="form-import">
                                            <div id="div-detail">
                                                <center>
                                                    <p>Tidak ada data yang ditampilkan</p>
                                                </center>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
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
            $('#div_tanggal_dari').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            $('#div_tanggal_sampai').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            $(".select-bentuk").select2();
        });

        function get_data() {
            $.get("{{ route('laporanwjl.efisiensi.detail') }}", {
                tanggal_dari: $("#tanggal_dari").val(),
                tanggal_sampai: $("#tanggal_sampai").val(),
                operator: $("#operator").val(),
            }, function(data) {
                if (data.status == 'success') {
                    $("#div-detail").html(`
                        <div class="d-flex justify-content-center m-2">
                            <button class="btn btn-primary" type="button" disabled>
                                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>
                    `);
                    setTimeout(() => {
                        $("#div-detail").html(data.data);
                    }, 500);
                }
            });
        }

        function cetak() {
            var url =
                '{!! route('laporanwjl.efisiensi.cetak', [
                    'tanggal_dari' => '_tanggal_dari',
                    'tanggal_sampai' => '_tanggal_sampai',
                    'operator' => '_operator',
                ]) !!}';
            url = url.replace('_tanggal_dari', $("#tanggal_dari").val());
            url = url.replace('_tanggal_sampai', $("#tanggal_sampai").val());
            url = url.replace('_operator', $("#operator").val());
            window.open(url);

        }

        function export_() {
            var url =
                '{!! route('laporanwjl.efisiensi.export', [
                    'tanggal_dari' => '_tanggal_dari',
                    'tanggal_sampai' => '_tanggal_sampai',
                    'operator' => '_operator',
                ]) !!}';
            url = url.replace('_tanggal_dari', $("#tanggal_dari").val());
            url = url.replace('_tanggal_sampai', $("#tanggal_sampai").val());
            url = url.replace('_operator', $("#operator").val());
            window.open(url);
        }
    </script>
@endsection
