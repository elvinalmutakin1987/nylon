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
                            <li class="breadcrumb-item">Data Master</li>
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
                                <h3 class="card-title">Data Master</h3>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        @if (auth()->user()->can('material'))
                                            <a class="btn btn-app" href="{{ route('material.index') }}">
                                                <i class="fas fa-barcode"></i> Material
                                            </a>
                                        @endif
                                        @if (auth()->user()->can('mesin'))
                                            <a class="btn btn-app" href="{{ route('mesin.index') }}">
                                                <i class="fa fa-microchip"></i> Mesin
                                            </a>
                                        @endif
                                        @if (auth()->user()->can('lokasi'))
                                            <a class="btn btn-app" href="{{ route('lokasi.index') }}">
                                                <i class="fa fa-map-marker"></i> Lokasi
                                            </a>
                                        @endif
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
    <script type="text/javascript"></script>
@endsection
