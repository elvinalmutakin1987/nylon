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
                            <li class="breadcrumb-item">Produksi Laminating</li>
                            <li class="breadcrumb-item" Active>Detail Data</li>
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
                                <h3 class="card-title">Detail Produksi Laminating</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="nomor">Nomor</label>
                                            <p>{{ $prodlaminating->nomor }}</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="nomor">Nomor WJL</label>
                                            <p>{{ $prodlaminating->prodwjl->nomor }}</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="nomor_so">Nomor SO</label>
                                            <p>{{ $prodlaminating->nomor_so }}</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="mesin">Mesin</label>
                                            <p>{{ $prodlaminating->mesin->nama }}</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <p>{{ $prodlaminating->tanggal }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="shift">Shift</label>
                                            <p>{{ $prodlaminating->shift }}</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="operator">Operator</label>
                                            <p>{{ $prodlaminating->operator }}</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan</label>
                                            <p>{{ $prodlaminating->keterangan }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <table id="table1"
                                                class="table table-bordered table-sm table-striped projects">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3" class="text-center">Build Of Material</th>
                                                    </tr>
                                                    <tr>
                                                        <th rowspan="2" class="text-center"
                                                            style="vertical-align: middle">Material</th>
                                                        <th colspan="2" class="text-center">Satuan</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 15%" class="text-center">Meter</th>
                                                        <th style="width: 15%" class="text-center">KG</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($prodlaminating->prodlaminatingdetail as $d)
                                                        <tr>
                                                            <td>{{ $d->material->nama }}</td>
                                                            <td class="text-center">
                                                                {{ $d->jumlah ? Number::format($d->jumlah) : '-' }}</td>
                                                            <td class="text-center">
                                                                {{ $d->jumlah2 ? Number::format($d->jumlah2) : '-' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @if ($prodlaminating->status == 'Panen')
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="tanggal_panen">Tanggal Panen</label>
                                                <p>{{ $prodlaminating->tanggal_panen }}</p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="material_panen">Material Panen</label>
                                                <p>{{ $prodlaminating->material->nama }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="jumlah">Meter</label>
                                                <p>{{ $prodlaminating->jumlah ? Number::format((float) $prodlaminating->jumlah) : '' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="jumlah2">KG</label>
                                                <p>{{ $prodlaminating->jumlah2 ? Number::format((float) $prodlaminating->jumlah2) : '' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a type="button" class="btn btn-default" href="{{ route('prodlaminating.index') }}"><i
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
        });
    </script>
@endsection
