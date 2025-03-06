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
                            <li class="breadcrumb-item">Gudang Benang</li>
                            <li class="breadcrumb-item">Barang Masuk</li>
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
                                <h3 class="card-title">Detail Barang Masuk</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="no_dokumen">No. Barang Masuk</label>
                                            <p>{{ $barangmasuk->no_dokumen }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="no_permintaan_material">Gudang Asal</label>
                                            <p>{{ $barangmasuk->asal }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="no_permintaan_material">No. Barang Keluar</label>
                                            <p>{{ $barangmasuk->permintaanmaterial->no_dokumen ?? '-' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <p>{{ $barangmasuk->tanggal ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <table id="table1" class="table border table-sm table-striped projects">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 40%">Barang</th>
                                                        <th style="width: 10%">Satuan</th>
                                                        <th style="width: 15%">Jumlah</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($barangmasuk->barangmasukdetail as $d)
                                                        <tr>
                                                            <td>{{ $d->material->nama }}</td>
                                                            <td>{{ $d->satuan }}</td>
                                                            <td>{{ Number::format((float) $d->jumlah, precision: 1) }}</td>
                                                            <td>{{ $d->keterangan }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="sopir">Catatan</label>
                                            <p>{{ $barangmasuk->catatan }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a type="button" class="btn btn-default"
                                    href="{{ route('barangmasuk.index', ['gudang' => $barangmasuk->gudang]) }}"><i
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
