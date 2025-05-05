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
                            <li class="breadcrumb-item">Laporan</li>
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
                        @if (auth()->user()->can('laporan.gudang'))
                            <!-- Application buttons -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Laporan Gudang</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-12">
                                            <a class="btn btn-app"
                                                href="{{ route('laporangudang.index', ['jenis' => 'barangjadi']) }}">
                                                <i class="fa fa-pencil"></i> Barang Jadi
                                            </a>

                                            <a class="btn btn-app"
                                                href="{{ route('laporangudang.index', ['jenis' => 'bahanbaku']) }}">
                                                <i class="fa fa-pencil"></i> Bahan Baku
                                            </a>

                                            <a class="btn btn-app"
                                                href="{{ route('laporangudang.index', ['jenis' => 'bahanpenolong']) }}">
                                                <i class="fa fa-pencil"></i> Bahan Penolong
                                            </a>

                                            <a class="btn btn-app"
                                                href="{{ route('laporangudang.index', ['jenis' => 'workinprogress']) }}">
                                                <i class="fa fa-pencil"></i> Work In Progress
                                            </a>

                                            <a class="btn btn-app"
                                                href="{{ route('laporangudang.index', ['jenis' => 'avalan']) }}">
                                                <i class="fa fa-pencil"></i> Avalan
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        @endif
                        @if (auth()->user()->can('laporan.wjl.efisiensi'))
                            <!-- Application buttons -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Laporan WJL</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-12">
                                            @if (auth()->user()->can('laporan.wjl.efisiensi'))
                                                <a class="btn btn-app" href="{{ route('laporanwjl.efisiensi.index') }}">
                                                    <i class="fa fa-pencil"></i> Efisiensi
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        @endif
                    </div>
                </div>
                <!-- /. row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


@section('script')
    <script type="text/javascript"></script>
@endsection
