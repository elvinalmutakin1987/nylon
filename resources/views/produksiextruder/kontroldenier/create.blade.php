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
                            <li class="breadcrumb-item">Laporan Kontrol Denier</li>
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
                                <h3 class="card-title">Laporan Kontrol Denier</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal</label>
                                                <input type="text"
                                                    class="form-control @error('tanggal') is-invalid @enderror"
                                                    id="tanggal" name="tanggal" value="{{ old('tanggal') ?? $tanggal }}"
                                                    readonly>
                                                @error('tanggal')
                                                    <span id="tanggal-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="shift">Shift</label>
                                            <input type="text" class="form-control @error('shift') is-invalid @enderror"
                                                id="shift" name="shift" value="{{ old('shift') ?? $shift }}" readonly>
                                            @error('shift')
                                                <span id="shift-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="material_id">Material</label>
                                            <input type="text"
                                                class="form-control @error('material_id') is-invalid @enderror"
                                                id="material_id" name="material_id"
                                                value="{{ old('material_id') ?? $material->nama }}" readonly>
                                            @error('material_id')
                                                <span id="material_id-error"
                                                    class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="lokasi">Lokasi</label>
                                            <div class="custom-control custom-radio">
                                                <input
                                                    class="custom-control-input custom-control-input-danger custom-control-input-outline"
                                                    type="radio" id="lokasi_kr" name="lokasi">
                                                <label for="lokasi_kr" class="custom-control-label">KR</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input
                                                    class="custom-control-input custom-control-input-danger custom-control-input-outline"
                                                    type="radio" id="lokasi_kn" name="lokasi">
                                                <label for="lokasi_kn" class="custom-control-label">KN</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="table1" class="table projects">
                                            <thead>
                                                <tr>
                                                    <th width="30">No.</th>
                                                    <th>Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 1; $i <= 64; $i++)
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                id="nilai{{ $i }}" name="nilai[]"
                                                                onblur="ubah_format('nilai{{ $i }}', this.value);">
                                                        </td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a type="button" class="btn btn-default"
                                    href="{{ route('produksiextruder-kontrol-denier.index') }}"><i class="fa fa-reply"></i>
                                    Kembali</a>
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>
                                    Simpan</button>
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

        <form action="{{ route('produksiextruder-kontrol-denier.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            @method('post')
        </form>
    </div>
    <!-- /.content-wrapper -->

    <div class="modal fade" id="modal-import">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Laporan Operator</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="div-detail">

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-reply"></i>
                        Kembali</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection


@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#div_tanggal').datetimepicker({
                format: 'YYYY-MM-DD'
            });

        });

        function ubah_format(field, nilai) {
            var mynumeral = numeral(nilai).format('0');
            mynumeral = parseFloat(mynumeral) / 1000
            mynumeral = numeral(mynumeral).format('0.000')
            $("#" + field).val(mynumeral);
        }

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

        function hitung_hasil() {

        }
    </script>
@endsection
