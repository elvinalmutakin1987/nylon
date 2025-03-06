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
                            <form action="{{ route('produksiextruder-kontrol-denier.update', $kontroldenier->slug) }}"
                                enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('put')
                                <div class="card-header">
                                    <h3 class="card-title">Laporan Kontrol Denier</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="tanggal">Tanggal</label>
                                                    <input type="text"
                                                        class="form-control @error('tanggal') is-invalid @enderror"
                                                        id="tanggal" name="tanggal"
                                                        value="{{ old('tanggal') ?? $tanggal }}" readonly>
                                                    @error('tanggal')
                                                        <span id="tanggal-error"
                                                            class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="shift">Shift</label>
                                                <input type="text"
                                                    class="form-control @error('shift') is-invalid @enderror" id="shift"
                                                    name="shift" value="{{ old('shift') ?? $shift }}" readonly>
                                                @error('shift')
                                                    <span id="shift-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
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
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="jenis_benang">Jenis Benang</label>
                                                <input type="text"
                                                    class="form-control @error('jenis_benang') is-invalid @enderror"
                                                    id="jenis_benang" name="jenis_benang"
                                                    value="{{ old('jenis_benang') ?? $kontroldenier->jenis_benang }}"
                                                    readonly>
                                                @error('jenis_benang')
                                                    <span id="jenis_benang-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="lokasi">Lokasi</label>
                                                <div class="custom-control custom-radio">
                                                    <input
                                                        class="custom-control-input custom-control-input-danger custom-control-input-outline"
                                                        type="radio" id="lokasi_kr" name="lokasi" value="KR">
                                                    <label for="lokasi_kr" class="custom-control-label">KR</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input
                                                        class="custom-control-input custom-control-input-danger custom-control-input-outline"
                                                        type="radio" id="lokasi_kn" name="lokasi" value="KN">
                                                    <label for="lokasi_kn" class="custom-control-label">KN</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="k_min_bottom">K -</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text"
                                                        class="form-control @error('k_min_bottom') is-invalid @enderror"
                                                        id="k_min_bottom" name="k_min_bottom"
                                                        value="{{ old('k_min_bottom') ?? $kontroldenier->k_min_bottom }}"
                                                        readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text"
                                                        class="form-control @error('k_min_top') is-invalid @enderror"
                                                        id="k_min_top" name="k_min_top"
                                                        value="{{ old('k_min_top') ?? $kontroldenier->k_min_top }}"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="k_bottom">K</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text"
                                                        class="form-control @error('k_bottom') is-invalid @enderror"
                                                        id="k_bottom" name="k_bottom"
                                                        value="{{ old('k_bottom') ?? $kontroldenier->k_bottom }}"
                                                        readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text"
                                                        class="form-control @error('k_top') is-invalid @enderror"
                                                        id="k_top" name="k_top"
                                                        value="{{ old('k_top') ?? $kontroldenier->k_top }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="n_bottom">N</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text"
                                                        class="form-control @error('n_bottom') is-invalid @enderror"
                                                        id="n_bottom" name="n_bottom"
                                                        value="{{ old('n_bottom') ?? $kontroldenier->n_bottom }}"
                                                        readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text"
                                                        class="form-control @error('n_top') is-invalid @enderror"
                                                        id="n_top" name="n_top"
                                                        value="{{ old('n_top') ?? $kontroldenier->n_top }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="d_bottom">B</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text"
                                                        class="form-control @error('d_bottom') is-invalid @enderror"
                                                        id="d_bottom" name="d_bottom"
                                                        value="{{ old('d_bottom') ?? $kontroldenier->d_bottom }}"
                                                        readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text"
                                                        class="form-control @error('d_top') is-invalid @enderror"
                                                        id="d_top" name="d_top"
                                                        value="{{ old('d_top') ?? $kontroldenier->d_top }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="d_plus_bottom">B +</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text"
                                                        class="form-control @error('d_plus_bottom') is-invalid @enderror"
                                                        id="d_plus_bottom" name="d_plus_bottom"
                                                        value="{{ old('d_plus_bottom') ?? $kontroldenier->d_plus_bottom }}"
                                                        readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text"
                                                        class="form-control @error('d_plus_top') is-invalid @enderror"
                                                        id="d_plus_top" name="d_plus_top"
                                                        value="{{ old('d_plus_top') ?? $kontroldenier->d_plus_top }}"
                                                        readonly>
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
                                                        <th>Rank</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @for ($i = 1; $i <= 200; $i++)
                                                        <tr>
                                                            <td>{{ $i }}
                                                                <input type="hidden" id="no_lokasi{{ $i }}"
                                                                    name="no_lokasi[]" value="{{ $i }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    id="nilai{{ $i }}" name="nilai[]"
                                                                    onblur="ubah_format('nilai{{ $i }}', this.value); hitung_hasil('{{ $i }}', this.value)">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    id="rank{{ $i }}" name="rank[]" readonly>
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
                                        href="{{ route('produksiextruder-kontrol-denier.index') }}"><i
                                            class="fa fa-reply"></i>
                                        Kembali</a>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>
                                        Simpan</button>
                                </div>
                            </form>
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
            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

            $('#div_tanggal').datetimepicker({
                format: 'YYYY-MM-DD'
            });

        });

        function ubah_format(field, nilai) {
            var mynumeral = numeral(nilai).format('0');
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

        function hitung_hasil(field, nilai) {
            var k_min_bottom = $("#k_min_bottom").val();
            var k_min_top = $("#k_min_top").val();
            var k_bottom = $("#k_bottom").val();
            var k_top = $("#k_top").val();
            var n_bottom = $("#n_bottom").val();
            var n_top = $("#n_top").val();
            var d_bottom = $("#d_bottom").val();
            var d_top = $("#d_top").val();
            var d_plus_bottom = $("#d_plus_bottom").val();
            var d_plus_top = $("#d_plus_top").val();
            var hasil = "";
            nilai = numeral(nilai).format('0');
            nilai = parseInt(nilai);

            if (nilai <= parseInt(k_min_top)) {
                hasil = "K -";
            } else if (nilai >= parseInt(k_bottom) && nilai <= parseInt(k_top)) {
                hasil = "K";
            } else if (nilai >= parseInt(n_bottom) && nilai <= parseInt(n_top)) {
                hasil = "N";
            } else if (nilai >= parseInt(d_bottom) && nilai <= parseInt(d_top)) {
                hasil = "B";
            } else if (nilai >= parseInt(d_plus_bottom)) {
                hasil = "B +";
            }
            $("#rank" + field).val(hasil);
        }
    </script>
@endsection
