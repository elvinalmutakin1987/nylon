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
                            <li class="breadcrumb-item">Stock Beaming</li>
                            <li class="breadcrumb-item" Active>Show</li>
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
                                <h3 class="card-title">Detail Stock Beaming</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <input type="text" class="form-control" id="tanggal" name="tanggal"
                                                value="{{ $stockbeaming->laporanbeaming->tanggal }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="beam_number">Beam Number</label>
                                            <input type="text" class="form-control" id="beam_number" name="beam_number"
                                                value="{{ $stockbeaming->laporanbeaming->beam_number }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <table id="table1" class="table border table-sm table-striped projects">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Shift</th>
                                                        <th>Posisi</th>
                                                        <th>Operator</th>
                                                        <th>Meter</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $meter_hasil = 0;
                                                    @endphp
                                                    @foreach ($stockbeaming->stockbeamingdetail as $d)
                                                        <tr>
                                                            <td>{{ $d->tanggal }}</td>
                                                            <td>{{ $d->shift }}</td>
                                                            <td>{{ $d->posisi }}</td>
                                                            <td>{{ $d->operator }}</td>
                                                            <td>{{ Number::format((float) $d->meter) }}</td>
                                                            <td>{!! $d->keterangan !!}</td>
                                                        </tr>
                                                        @php
                                                            $meter_hasil += (float) $d->meter;
                                                        @endphp
                                                    @endforeach
                                                </tbody>
                                                <thead>
                                                    <tr>
                                                        <th class="text-right" colspan="4">Total</th>
                                                        <th>{{ Number::format((float) $meter_hasil) }}</th>
                                                        <th>
                                                        </th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary" onclick="cetak()"><i
                                                class="fa fa-print"></i>
                                            Cetak</button>
                                        <button type="button" class="btn btn-success" onclick="export_()"><i
                                                class="fas fa-file-excel"></i>
                                            Export</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a type="button" class="btn btn-default"
                                    href="{{ route('produksiextruder.stockbeaming.index') }}"><i class="fa fa-reply"></i>
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

        function cetak() {
            let posisi = $("#posisi").val();
            let status = $("#status").val();
            let url = `{!! route('produksiextruder.stockbeaming.cetak', [
                'stockbeaming_id' => '_stockbeaming_id',
            ]) !!}`;
            url = url.replace('_stockbeaming_id', {{ $stockbeaming->id }});
            window.open(url, '_blank');
        }

        function export_() {
            let posisi = $("#posisi").val();
            let status = $("#status").val();
            let url = `{!! route('produksiextruder.stockbeaming.export', [
                'stockbeaming_id' => '_stockbeaming_id',
            ]) !!}`;
            url = url.replace('_stockbeaming_id', {{ $stockbeaming->id }});
            window.open(url, '_blank');
        }
    </script>
@endsection
