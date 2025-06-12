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
                            <li class="breadcrumb-item" Active>Rekap Produksi Welding</li>
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
                                <h3 class="card-title">Rekap Produksi Welding</h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-default m-1" id="button-export"
                                            onclick="export_()"><i class="fa fa-upload"></i>
                                            Export</button>
                                        <button type="button" class="btn btn-default m-1" id="button-export"
                                            onclick="cetak()"><i class="fa fa-print"></i> Cetak</button>
                                        <a type="button" class="btn btn-secondary m-1"
                                            href="{{ route('produksi.index') }}"><i class="fa fa-reply"></i> Kembali</a>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col">
                                        <div class="form-group">
                                            <div class="input-group date" id="div_tanggal_dari" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input"
                                                    data-target="#div_tanggal_dari" id="tanggal_dari" name="tanggal_dari"
                                                    value="{{ \Carbon\Carbon::now()->startOfMonth()->toDateString() }}" />
                                                <div class="input-group-append" data-target="#div_tanggal_dari"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <div class="input-group date" id="div_tanggal_sampai"
                                                data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input"
                                                    data-target="#div_tanggal_sampai" id="tanggal_sampai"
                                                    name="tanggal_sampai"
                                                    value="{{ \Carbon\Carbon::now()->endOfMonth()->toDateString() }}" />
                                                <div class="input-group-append" data-target="#div_tanggal_sampai"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="div" id="div_detail">

                                        </div>
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

    <form enctype="multipart/form-data" id="form-delete" method="POST">
        @csrf
        @method('DELETE')
    </form>
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

            $('.select-mesin').select2({
                placeholder: "- Pilih Mesin -",
                allowClear: true,
                ajax: {
                    url: '{{ route('produksiwelding.rekap.get_mesin') }}',
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

            var url =
                '{!! route('produksiwelding.rekap.get_rekap', [
                    'tanggal_dari' => '_tanggal_dari',
                    'tanggal_sampai' => '_tanggal_sampai',
                ]) !!}';
            url = url.replace('_tanggal_dari', $("#tanggal_dari").val());
            url = url.replace('_tanggal_sampai', $("#tanggal_sampai").val());
            $.get(url, function(data) {
                if (data.status == 'success') {
                    $('#div_detail').html(`
                        <div class="d-flex justify-content-center m-2">
                        <button class="btn btn-primary" type="button" disabled>
                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                            Loading...
                            </button>
                        </div>
                    `);
                    setTimeout(() => {
                        $('#div_detail').html(data.data);
                    }, 500);
                }
            });
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

        $('#modal-default').on('hidden.bs.modal', function() {
            $("#card-tabs").html('');
        });

        $("#tanggal_dari").on('blur', function(e) {
            var url =
                '{!! route('produksiwelding.rekap.get_rekap', [
                    'tanggal_dari' => '_tanggal_dari',
                    'tanggal_sampai' => '_tanggal_sampai',
                ]) !!}';
            url = url.replace('_tanggal_dari', $("#tanggal_dari").val());
            url = url.replace('_tanggal_sampai', $("#tanggal_sampai").val());
            url = url.replace('_mesin_id', $("#mesin_id").val());
            $.get(url, function(data) {
                if (data.status == 'success') {
                    $('#div_detail').html(`
                        <div class="d-flex justify-content-center m-2">
                        <button class="btn btn-primary" type="button" disabled>
                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                            Loading...
                            </button>
                        </div>
                    `);
                    setTimeout(() => {
                        $('#div_detail').html(data.data);
                    }, 500);
                }
            });
        });

        $("#tanggal_sampai").on('blur', function(e) {
            var url =
                '{!! route('produksiwelding.rekap.get_rekap', [
                    'tanggal_dari' => '_tanggal_dari',
                    'tanggal_sampai' => '_tanggal_sampai',
                ]) !!}';
            url = url.replace('_tanggal_dari', $("#tanggal_dari").val());
            url = url.replace('_tanggal_sampai', $("#tanggal_sampai").val());
            url = url.replace('_mesin_id', $("#mesin_id").val());
            $.get(url, function(data) {
                if (data.status == 'success') {
                    $('#div_detail').html(`
                        <div class="d-flex justify-content-center m-2">
                        <button class="btn btn-primary" type="button" disabled>
                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                            Loading...
                            </button>
                        </div>
                    `);
                    setTimeout(() => {
                        $('#div_detail').html(data.data);
                    }, 500);
                }
            });
        });

        function cetak() {
            var url =
                '{!! route('produksiwelding.rekap.cetak', [
                    'tanggal_dari' => '_tanggal_dari',
                    'tanggal_sampai' => '_tanggal_sampai',
                ]) !!}';
            url = url.replace('_tanggal_dari', $("#tanggal_dari").val());
            url = url.replace('_tanggal_sampai', $("#tanggal_sampai").val());
            window.open(url);
        }

        function export_() {
            var url =
                '{!! route('produksiwelding.rekap.export', [
                    'tanggal_dari' => '_tanggal_dari',
                    'tanggal_sampai' => '_tanggal_sampai',
                ]) !!}';
            url = url.replace('_tanggal_dari', $("#tanggal_dari").val());
            url = url.replace('_tanggal_sampai', $("#tanggal_sampai").val());
            window.open(url);
        }
    </script>
@endsection
