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
                            <li class="breadcrumb-item">Gudang</li>
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
                                <h3 class="card-title">Gudang Barang Jadi</h3>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        @if (auth()->user()->can('gudang.barangjadi.order'))
                                            <a class="btn btn-app" href="{{ route('gudangbarangjadiorder.index') }}">
                                                @if ($order->count() > 0)
                                                    <span class="badge bg-danger">{{ $order->count() }}</span>
                                                @endif
                                                <i class="fas fa-file-import"></i> Order
                                            </a>
                                        @endif

                                        @if (auth()->user()->can('gudang.barangjadi.cekstok'))
                                            <a class="btn btn-app"
                                                href="{{ route('cekstok.index', ['gudang' => 'barang-jadi']) }}">
                                                <i class="fa fa-search"></i> Cek Stok
                                            </a>
                                        @endif

                                        @if (auth()->user()->can('gudang.barangjadi.suratjalan'))
                                            <a class="btn btn-app" href="{{ route('suratjalan.index') }}">
                                                <i class="fa fa-truck"></i> Surat Jalan
                                            </a>
                                        @endif

                                        @if (auth()->user()->can('gudang.barangjadi.barangmasuk'))
                                            <a class="btn btn-app"
                                                href="{{ route('barangkeluar.index', ['gudang' => 'bahan-jadi']) }}">
                                                <i class="fa fa-download"></i> Barang Masuk
                                            </a>
                                        @endif

                                        @if (auth()->user()->can('gudang.barangjadi.barangkeluar'))
                                            <a class="btn btn-app"
                                                href="{{ route('barangkeluar.index', ['gudang' => 'barang-jadi']) }}">
                                                <i class="fa fa-upload"></i> Barang Keluar
                                            </a>
                                        @endif

                                        @if (auth()->user()->can('gudang.barangjadi.retur'))
                                            <a class="btn btn-app"
                                                href="{{ route('barangkeluar.index', ['gudang' => 'bahan-jadi']) }}">
                                                <i class="fa fa-mail-reply"></i> Retur
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- Application buttons -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Gudang Bahan Baku</h3>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        @if (auth()->user()->can('gudang.bahanbaku.barangmasuk'))
                                            <a class="btn btn-app"
                                                href="{{ route('barangkeluar.index', ['gudang' => 'bahan-baku']) }}">
                                                <i class="fa fa-search"></i> Cek Stok
                                            </a>
                                        @endif

                                        @if (auth()->user()->can('gudang.bahanbaku.barangmasuk'))
                                            <a class="btn btn-app"
                                                href="{{ route('barangkeluar.index', ['gudang' => 'bahan-baku']) }}">
                                                <i class="fa fa-download"></i> Barang Masuk
                                            </a>
                                        @endif

                                        @if (auth()->user()->can('gudang.bahanbaku.barangkeluar'))
                                            <a class="btn btn-app"
                                                href="{{ route('barangkeluar.index', ['gudang' => 'bahan-baku']) }}">
                                                <i class="fa fa-upload"></i> Barang Keluar
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- Application buttons -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Gudang Benang</h3>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        @if (auth()->user()->can('order'))
                                            <a class="btn btn-app" href="{{ route('order.index') }}">
                                                <i class="fa fa-download"></i> Order
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- Application buttons -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Stock Opname</h3>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        @if (auth()->user()->can('order'))
                                            <a class="btn btn-app" href="{{ route('order.index') }}">
                                                <i class="fa fa-download"></i> Order
                                            </a>
                                        @endif

                                        @if (auth()->user()->can('gudang.bahanbaku.barangmasuk'))
                                            <a class="btn btn-app"
                                                href="{{ route('barangkeluar.index', ['gudang' => 'bahan-baku']) }}">
                                                <i class="fa fa-search"></i> Cek Stok
                                            </a>
                                        @endif

                                        @if (auth()->user()->can('gudang.bahanbaku.barangmasuk'))
                                            <a class="btn btn-app"
                                                href="{{ route('barangkeluar.index', ['gudang' => 'bahan-baku']) }}">
                                                <i class="fa fa-download"></i> Barang Masuk
                                            </a>
                                        @endif

                                        @if (auth()->user()->can('gudang.bahanbaku.barangkeluar'))
                                            <a class="btn btn-app"
                                                href="{{ route('barangkeluar.index', ['gudang' => 'bahan-baku']) }}">
                                                <i class="fa fa-upload"></i> Barang Keluar
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
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
