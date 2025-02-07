@php
    use Illuminate\Support\Number;
    use App\Models\Mesin;
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
                            <li class="breadcrumb-item">Laporan Produksi WJL</li>
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
                        <form action="{{ route('produksiwjl.operator.update', $produksiwjl->slug) }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            @method('put')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Laporan Produksi WJL</h3>
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
                                                        value="{{ old('tanggal') ?? $produksiwjl->tanggal }}" readonly>
                                                    @error('tanggal')
                                                        <span id="tanggal-error"
                                                            class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $mesin = Mesin::find($produksiwjl->mesin_id);
                                        @endphp
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="mesin_id">Mesin</label>
                                                <input type="text"
                                                    class="form-control @error('mesin_id') is-invalid @enderror"
                                                    id="mesin_id" name="mesin_id"
                                                    value="{{ old('mesin_id') ?? $mesin->nama }}" readonly>
                                                @error('mesin_id')
                                                    <span id="mesin_id-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="shift">Shift</label>
                                                <input type="text"
                                                    class="form-control @error('shift') is-invalid @enderror" id="shift"
                                                    name="shift" value="{{ old('shift') ?? $produksiwjl->shift }}"
                                                    readonly>
                                                @error('shift')
                                                    <span id="shift-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="jenis_kain">Jenis Kain</label>
                                                <input type="text"
                                                    class="form-control @error('jenis_kain') is-invalid @enderror"
                                                    id="jenis_kain" name="jenis_kain"
                                                    value="{{ old('jenis_kain') ?? $produksiwjl->jenis_kain }}">
                                                @error('jenis_kain')
                                                    <span id="jenis_kain-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="operator">Operator</label>
                                                <input type="text"
                                                    class="form-control @error('operator') is-invalid @enderror"
                                                    id="operator" name="operator"
                                                    value="{{ old('operator') ?? $produksiwjl->operator }}">
                                                @error('operator')
                                                    <span id="operator-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="meter_awal">Meter Awal</label>
                                                <input type="text"
                                                    class="form-control @error('meter_awal') is-invalid @enderror"
                                                    id="meter_awal" name="meter_awal"
                                                    value="{{ old('meter_awal') ?? Number::format($produksiwjl->meter_awal, precision: 1) }}"
                                                    onblur="ubah_format('meter_awal', this.value); hitung_hasil();">
                                                @error('meter_awal')
                                                    <span id="meter_awal-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="meter_akhir">Meter Akhir</label>
                                                <input type="text"
                                                    class="form-control @error('meter_akhir') is-invalid @enderror"
                                                    id="meter_akhir" name="meter_akhir"
                                                    value="{{ old('meter_akhir') ?? Number::format($produksiwjl->meter_akhir, precision: 1) }}"
                                                    onblur="ubah_format('meter_akhir', this.value); hitung_hasil();"">
                                                @error('meter_akhir')
                                                    <span id="meter_akhir-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="hasil">Hasil</label>
                                                <input type="text"
                                                    class="form-control @error('hasil') is-invalid @enderror"
                                                    id="hasil" name="hasil"
                                                    value="{{ old('hasil') ?? Number::format($produksiwjl->hasil, precision: 1) }}"
                                                    readonly>
                                                @error('hasil')
                                                    <span id="hasil-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="keterangan">Keterangan</label>
                                                <textarea class="form-control @error('keterangan') is-invalid @enderror" rows="10" id="keterangan"
                                                    name="keterangan">{!! $produksiwjl->keterangan !!}</textarea>
                                                @error('keterangan')
                                                    <span id="keterangan-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="lungsi">Lungsi</label>
                                                <input type="text"
                                                    class="form-control @error('lungsi') is-invalid @enderror"
                                                    id="lungsi" name="lungsi" value="{{ old('lungsi') }}"
                                                    onblur="ubah_format('lungsi', this.value);"
                                                    value="{{ Number::format($produksiwjl->lungsi, precision: 1) }}">
                                                @error('lungsi')
                                                    <span id="meter_awal-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="pakan">Pakan</label>
                                                <input type="text"
                                                    class="form-control @error('pakan') is-invalid @enderror"
                                                    id="pakan" name="pakan" value="{{ old('pakan') }}"
                                                    onblur="ubah_format('pakan', this.value);"
                                                    value="{{ Number::format($produksiwjl->pakan, precision: 1) }}">
                                                @error('pakan')
                                                    <span id="pakan-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="lubang">Lubang</label>
                                                <input type="text"
                                                    class="form-control @error('lubang') is-invalid @enderror"
                                                    id="lubang" name="lubang" value="{{ old('lubang') }}"
                                                    value="{{ $produksiwjl->lubang }}">
                                                @error('lubang')
                                                    <span id="lubang-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="pgr">PGR</label>
                                                <input type="text"
                                                    class="form-control @error('pgr') is-invalid @enderror"
                                                    id="pgr" name="pgr"
                                                    value="{{ old('pgr') ?? $produksiwjl->pgr }}">
                                                @error('pgr')
                                                    <span id="meter_awal-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="lebar">Lebar</label>
                                                <input type="text"
                                                    class="form-control @error('lebar') is-invalid @enderror"
                                                    id="lebar" name="lebar"
                                                    value="{{ old('lebar') ?? $produksiwjl->lebar }}"
                                                    onblur="ubah_format('lebar', this.value);">
                                                @error('lebar')
                                                    <span id="lebar-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="mesin">Mesin</label>
                                                <input type="text"
                                                    class="form-control @error('mesin') is-invalid @enderror"
                                                    id="mesin" name="mesin"
                                                    value="{{ old('mesin') ?? $produksiwjl->mesin }}">
                                                @error('mesin')
                                                    <span id="mesin-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="teknisi">Teknisi</label>
                                                <input type="text"
                                                    class="form-control @error('teknisi') is-invalid @enderror"
                                                    id="teknisi" name="teknisi"
                                                    value="{{ old('teknisi') ?? $produksiwjl->teknisi }}">
                                                @error('teknisi')
                                                    <span id="mesin-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Dokumentasi</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="foto"
                                                            name="foto[]" multiple>
                                                        <label class="custom-file-label" for="foto">Pilih foto</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="button" class="btn btn-default"
                                        href="{{ route('produksiwjl.operator.index') }}"><i class="fa fa-reply"></i>
                                        Kembali</a>
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>
                                        Simpan</button>
                                </div>
                            </div>
                            <!-- /.card -->
                        </form>
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
            $('#div_tanggal').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            format_select2();
        });

        function format_select2() {
            $('.select-shift').select2({
                width: '100%',
                minimumResultsForSearch: -1,
            });

            $('.select-mesin').select2({
                placeholder: "- Pilih Mesin -",
                allowClear: true,
                ajax: {
                    url: '{{ route('produksiwjl.operator.get_mesin') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1,
                        };
                    },
                    cache: true,
                }
            });
        }

        function ubah_format(field, nilai) {
            var mynumeral = numeral(nilai).format('0,0.0');
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
            var meter_awal = numeral($("#meter_awal").val()).format('0.0');
            var meter_akhir = numeral($("#meter_akhir").val()).format('0.0');
            var hasil = parseFloat(meter_akhir) - parseFloat(meter_awal);
            $("#hasil").val(numeral(hasil).format('0,0.0'));
        }
    </script>
@endsection
