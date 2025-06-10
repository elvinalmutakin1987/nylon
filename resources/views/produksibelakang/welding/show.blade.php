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
                            <li class="breadcrumb-item">Produksi Welding</li>
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
                                <h3 class="card-title">Detail Produksi Welding</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="nomor">Nomor</label>
                                            <p>{{ $prodwelding->nomor }}</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="nomor">Nomor WJL</label>
                                            <p>{{ $prodwelding->prodlaminating->prodwjl->nomor }}</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="nomor">Nomor Laminating</label>
                                            <p>{{ $prodwelding->prodlaminating->nomor }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="nomor_so">Nomor SO</label>
                                            <p>{{ $prodwelding->nomor_so }}</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="mesin">Mesin</label>
                                            <p>{{ $prodwelding->mesin->nama }}</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <p>{{ $prodwelding->tanggal }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="shift">Shift</label>
                                            <p>{{ $prodwelding->shift }}</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="operator">Operator</label>
                                            <p>{{ $prodwelding->operator }}</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan</label>
                                            <p>{{ $prodwelding->keterangan }}</p>
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
                                                    @foreach ($prodwelding->prodweldingdetail as $d)
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
                                @if ($prodwelding->status == 'Panen')
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="tanggal_panen">Tanggal Panen</label>
                                                <p>{{ $prodwelding->tanggal_panen }}</p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="material_panen">Material Panen</label>
                                                <p>{{ $prodwelding->material->nama }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="jumlah">Meter</label>
                                                <p>{{ $prodwelding->jumlah ? Number::format((float) $prodwelding->jumlah) : '' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="jumlah2">KG</label>
                                                <p>{{ $prodwelding->jumlah2 ? Number::format((float) $prodwelding->jumlah2) : '' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a type="button" class="btn btn-default" href="{{ route('prodwelding.index') }}"><i
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
