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
                            <li class="breadcrumb-item">Gudang</li>
                            <li class="breadcrumb-item active">Barang Jadi</li>
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
                                <h3 class="card-title">Laporan Barang Jadi</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="input-group date" id="div_tanggal" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input"
                                                    data-target="#div_tanggal" id="tanggal" name="tanggal"
                                                    value="{{ \Carbon\Carbon::now() }}" />
                                                <div class="input-group-append" data-target="#div_tanggal"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select
                                                class="form-control select2 w-100 select-bentuk @error('bentuk') is-invalid @enderror"
                                                id="bentuk" name="bentuk">
                                                <option value="Roll">Roll</option>
                                                <option value="Terpal">Terpal</option>
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

    <input type="hidden" id="jenis" name="jenis" value="{{ $jenis }}">
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#div_tanggal').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            $(".select-bentuk").select2();
        });

        function get_data() {
            $.get("{{ route('laporangudang.detail') }}", {
                tanggal: $("#tanggal").val(),
                bentuk: $("#bentuk").val(),
                jenis: '{{ $jenis }}'
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
            $("#tanggal").attr('form', 'form-import');
            $("#bentuk").attr('form', 'form-import');
            $("#jenis").attr('form', 'form-import');
            $.post("{{ route('laporangudang.store_keterangan') }}", $("#form-import").serialize(), function(data) {
                if (data.status == 'success') {
                    var url = "{!! route('laporangudang.cetak', ['tanggal' => '_tanggal', 'bentuk' => '_bentuk', 'jenis' => $jenis]) !!}";
                    url = url.replace('_tanggal', $("#tanggal").val());
                    url = url.replace('_bentuk', $("#bentuk").val());
                    window.open(url, '_blank');
                }
            });

        }

        function export_() {
            $("#tanggal").attr('form', 'form-import');
            $("#bentuk").attr('form', 'form-import');
            $("#jenis").attr('form', 'form-import');
            $.post("{{ route('laporangudang.store_keterangan') }}", $("#form-import").serialize(), function(data) {
                if (data.status == 'success') {
                    var url = "{!! route('laporangudang.export', ['tanggal' => '_tanggal', 'bentuk' => '_bentuk', 'jenis' => $jenis]) !!}";
                    url = url.replace('_tanggal', $("#tanggal").val());
                    url = url.replace('_bentuk', $("#bentuk").val());
                    window.open(url, '_blank');
                }
            });

        }
    </script>
@endsection
