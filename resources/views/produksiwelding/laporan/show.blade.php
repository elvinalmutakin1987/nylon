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
                            <li class="breadcrumb-item">Laporan Welding</li>
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
                                <h3 class="card-title">Detail Laporan Welding</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <p>{{ $produksiwelding->tanggal }}</p>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="operator">Operator</label>
                                            <p>{{ $produksiwelding->operator }}</p>
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
                                                        <th class="text-center" style="vertical-align: middle"
                                                            width="20%">Jenis
                                                        </th>
                                                        <th class="text-center">
                                                            Ukuran
                                                        </th>
                                                        <th class="text-center">Jumlah</th>
                                                        <th class="text-center">Total</th>
                                                        <th class="text-center" width="30%">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $grand_total = 0; @endphp
                                                    @foreach ($produksiwelding->produksiweldingdetail as $d)
                                                        <tr>
                                                            <td>{{ $d->jenis }}</td>
                                                            <td class="text-center">{{ Number::format($d->ukuran1) }} X
                                                                {{ Number::format($d->ukuran2) }}</td>
                                                            <td class="text-center"> {{ Number::format($d->jumlah) }}</td>
                                                            <td class="text-center"> {{ Number::format($d->total) }}</td>
                                                            <td>{{ $d->keterangan }}</td>
                                                        </tr>
                                                        @php $grand_total += (float) $d->total; @endphp
                                                    @endforeach
                                                </tbody>
                                                <thead>
                                                    <tr>
                                                        <th colspan="3" class="text-right">Total</th>
                                                        <th id="grand_total" class="text-center">
                                                            {{ Number::format($grand_total) }}</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a type="button" class="btn btn-default"
                                    href="{{ route('produksiwelding.laporan.index') }}"><i class="fa fa-reply"></i>
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
