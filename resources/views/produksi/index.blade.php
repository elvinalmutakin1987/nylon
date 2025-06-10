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
                            <li class="breadcrumb-item">Produksi</li>
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
                        @if (auth()->user()->can('produksi.extruder.kontrol-denier') ||
                                auth()->user()->can('produksi.extruder.kontrol-barmag') ||
                                auth()->user()->can('produksi.extruder.kontrol-reifen') ||
                                auth()->user()->can('produksi.extruder.laporansulzer') ||
                                auth()->user()->can('produksi.extruder.laporanrashel') ||
                                auth()->user()->can('produksi.extruder.checklistbeaming') ||
                                auth()->user()->can('produksi.extruder.laporanbeaming') ||
                                auth()->user()->can('produksi.extruder.beamatasmesin') ||
                                auth()->user()->can('produksi.extruder.beambawahmesin') ||
                                auth()->user()->can('produksi.extruder.stockbeaming'))
                            <!-- Application buttons -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Produksi Depan</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-12">
                                            @if (auth()->user()->can('produksi.extruder.kontrol-denier'))
                                                <a class="btn btn-app"
                                                    href="{{ route('produksiextruder-kontrol-denier.index') }}">
                                                    <i class="fa fa-pencil"></i> Laporan Kontrol Denier
                                                </a>
                                            @endif

                                            @if (auth()->user()->can('produksi.extruder.kontrol-barmag'))
                                                <a class="btn btn-app"
                                                    href="{{ route('produksiextruder-kontrol-barmag.index') }}">
                                                    <i class="far fa-compass"></i> Laporan Kontrol Barmag
                                                </a>
                                            @endif

                                            @if (auth()->user()->can('produksi.extruder.kontrol-reifen'))
                                                <a class="btn btn-app"
                                                    href="{{ route('produksiextruder-kontrol-reifen.index') }}">
                                                    <i class="fa fa-hourglass-1"></i> Laporan Kontrol Reifen
                                                </a>
                                            @endif

                                            @if (auth()->user()->can('produksi.extruder.laporansulzer'))
                                                <a class="btn btn-app"
                                                    href="{{ route('produksiextruder.laporansulzer.index') }}">
                                                    <i class="fas fa-toilet-paper"></i> Laporan Sulzer
                                                </a>
                                            @endif

                                            @if (auth()->user()->can('produksi.extruder.laporanrashel'))
                                                <a class="btn btn-app"
                                                    href="{{ route('produksiextruder.laporanrashel.index') }}">
                                                    <i class="fas fa-scroll"></i> Laporan Rashel
                                                </a>
                                            @endif

                                            @if (auth()->user()->can('produksi.extruder.laporanbeaming'))
                                                <a class="btn btn-app"
                                                    href="{{ route('produksiextruder.laporanbeaming.index') }}">
                                                    <i class="fas fa-cog"></i> Laporan Beaming
                                                </a>
                                            @endif

                                            @if (auth()->user()->can('produksi.extruder.checklistbeaming'))
                                                <a class="btn btn-app"
                                                    href="{{ route('produksiextruder.checklistbeaming.index') }}">
                                                    <i class="fas fa-check"></i> Check List Beaming
                                                </a>
                                            @endif

                                            {{-- @if (auth()->user()->can('produksi.extruder.beamatasmesin'))
                                                <a class="btn btn-app"
                                                    href="{{ route('produksiextruder.beamatasmesin.index') }}">
                                                    <i class="fa fa-arrow-up"></i> Beam Atas Mesin
                                                </a>
                                            @endif

                                            @if (auth()->user()->can('produksi.extruder.beambawahmesin'))
                                                <a class="btn btn-app"
                                                    href="{{ route('produksiextruder.beambawahmesin.index') }}">
                                                    <i class="fa fa-arrow-down"></i> Beam Bawah Mesin
                                                </a>
                                            @endif --}}

                                            @if (auth()->user()->can('produksi.extruder.stockbeaming'))
                                                <a class="btn btn-app"
                                                    href="{{ route('produksiextruder.stockbeaming.index') }}">
                                                    <i class="fas fa-boxes"></i> Stock Beaming
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        @endif
                        @if (auth()->user()->can('produksi.wjl.operator') ||
                                auth()->user()->can('produksi.wjl.rekap') ||
                                auth()->user()->can('produksi.laminating.pengeringankain') ||
                                auth()->user()->can('produksi.laminating.rekap'))
                            <!-- Application buttons -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Produksi Belakang</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-12">
                                            @if (auth()->user()->can('produksi.wjl.operator'))
                                                <a class="btn btn-app" href="{{ route('produksiwjl.operator.index') }}">
                                                    <i class="fa fa-pencil"></i> Laporan Produksi WJL
                                                </a>
                                            @endif

                                            @if (auth()->user()->can('produksi.laminating.pengeringankain'))
                                                <a class="btn btn-app"
                                                    href="{{ route('produksilaminating.pengeringankain.index') }}">
                                                    <i class="fa fa-pencil"></i> Laporan Pengeringan Kain
                                                </a>
                                            @endif

                                            @if (auth()->user()->can('produksi.wjl.rekap'))
                                                <a class="btn btn-app" href="{{ route('produksiwjl.rekap.index') }}">
                                                    <i class="fa fa-file"></i> Rekap Produksi WJL
                                                </a>
                                            @endif

                                            @if (auth()->user()->can('produksi.laminating.rekap'))
                                                <a class="btn btn-app"
                                                    href="{{ route('produksilaminating.rekap.index') }}">
                                                    <i class="fa fa-file"></i> Rekap Pengeringan Kain
                                                </a>
                                            @endif

                                            <br>

                                            @if (auth()->user()->can('produksi.wjl'))
                                                <a class="btn btn-app" href="{{ route('prodwjl.index') }}">
                                                    <i class="fa fa-asterisk"></i> Produksi WJL
                                                </a>
                                            @endif

                                            @if (auth()->user()->can('produksi.laminating'))
                                                <a class="btn btn-app" href="{{ route('prodlaminating.index') }}">
                                                    <i class="fa fa-asterisk"></i> Produksi Laminating
                                                </a>
                                            @endif

                                            @if (auth()->user()->can('produksi.welding'))
                                                <a class="btn btn-app" href="{{ route('prodwelding.index') }}">
                                                    <i class="fa fa-asterisk"></i> Produksi Welding
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        @endif

                        @if (auth()->user()->can('gudang.benang.barangkeluar') ||
                                auth()->user()->can('gudang.benang.barangmasuk') ||
                                auth()->user()->can('gudang.benang.retur') ||
                                auth()->user()->can('gudang.benang.cekstok'))
                            <!-- Application buttons -->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Gudang Benang</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-12">
                                            @if (auth()->user()->can('gudang.benang.cekstok'))
                                                <a class="btn btn-app"
                                                    href="{{ route('cekstok.index', ['gudang' => 'benang']) }}">
                                                    <i class="fa fa-search"></i> Cek Stok
                                                </a>
                                            @endif

                                            @if (auth()->user()->can('gudang.benang.barangkeluar'))
                                                <a class="btn btn-app"
                                                    href="{{ route('barangkeluar.index', ['gudang' => 'benang']) }}">
                                                    <i class="fa fa-upload"></i> Barang Keluar
                                                </a>
                                            @endif

                                            @if (auth()->user()->can('gudang.benang.barangmasuk'))
                                                <a class="btn btn-app"
                                                    href="{{ route('barangmasuk.index', ['gudang' => 'benang']) }}">
                                                    <i class="fa fa-download"></i> Barang Masuk
                                                </a>
                                            @endif

                                            @if (auth()->user()->can('gudang.benang.retur'))
                                                <a class="btn btn-app"
                                                    href="{{ route('retur.index', ['gudang' => 'benang']) }}">
                                                    <i class="fa fa-mail-reply"></i> Retur
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
