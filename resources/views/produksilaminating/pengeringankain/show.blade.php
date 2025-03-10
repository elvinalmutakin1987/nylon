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
                            <li class="breadcrumb-item">Laporan Produksi Pengeringan Kain</li>
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
                                <h3 class="card-title">Serah Terima Laporan Produksi WJL</h3>
                            </div>
                            <div class="card-body">
                                @if ($produksiwjl_sebelumnya)
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="tanggal">Tanggal</label>
                                                    <input type="text"
                                                        class="form-control @error('tanggal') is-invalid @enderror"
                                                        id="tanggal" name="tanggal"
                                                        value="{{ old('tanggal') ?? $produksiwjl_sebelumnya->tanggal }}"
                                                        readonly>
                                                    @error('tanggal')
                                                        <span id="tanggal-error"
                                                            class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $mesin = Mesin::find($produksiwjl_sebelumnya->mesin_id);
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
                                                    name="shift"
                                                    value="{{ old('shift') ?? $produksiwjl_sebelumnya->shift }}" readonly>
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
                                                    value="{{ old('jenis_kain') ?? $produksiwjl_sebelumnya->jenis_kain }}"
                                                    readonly>
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
                                                    value="{{ old('operator') ?? $produksiwjl_sebelumnya->operator }}"
                                                    readonly>
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
                                                    value="{{ old('meter_awal') ?? Number::format($produksiwjl_sebelumnya->meter_awal, precision: 1) }}"
                                                    onblur="ubah_format('meter_awal', this.value); hitung_hasil();"
                                                    readonly>
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
                                                    value="{{ old('meter_akhir') ?? Number::format($produksiwjl_sebelumnya->meter_akhir, precision: 1) }}"
                                                    onblur="ubah_format('meter_akhir', this.value); hitung_hasil();"
                                                    readonly>
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
                                                    value="{{ old('hasil') ?? Number::format($produksiwjl_sebelumnya->meter_akhir - $produksiwjl_sebelumnya->meter_awal, precision: 1) }}"
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
                                                    name="keterangan" readonly>{!! $produksiwjl_sebelumnya->keterangan !!}</textarea>
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
                                                    value="{{ Number::format($produksiwjl_sebelumnya->lungsi, precision: 1) }}"
                                                    readonly>
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
                                                    value="{{ Number::format($produksiwjl_sebelumnya->pakan, precision: 1) }}"
                                                    readonly>
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
                                                    value="{{ $produksiwjl_sebelumnya->lubang }}" readonly>
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
                                                    value="{{ old('pgr') ?? $produksiwjl_sebelumnya->pgr }}" readonly>
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
                                                    value="{{ old('lebar') ?? $produksiwjl_sebelumnya->lebar }}"
                                                    onblur="ubah_format('lebar', this.value);" readonly>
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
                                                    value="{{ old('mesin') ?? $produksiwjl_sebelumnya->mesin }}" readonly>
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
                                                    value="{{ old('teknisi') ?? $produksiwjl_sebelumnya->teknisi }}"
                                                    readonly>
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p> <span class="badge badge-success"><i class="fa fa-check"></i></span> Saya
                                                telah
                                                membaca, mengerti dan menyetujui serah terima laporan produksi
                                                ini.
                                            </p>
                                            @if ($action == 'create')
                                                <a type="button" class="btn btn-success"
                                                    href="{{ route('produksiwjl.operator.create_laporan', ['mesin_id' => $mesin_id, 'tanggal' => $tanggal, 'shift' => $shift]) }}"><i
                                                        class="fa fa-forward"></i>
                                                    Lanjutkan Buat Laporan</a>
                                            @else
                                                <a type="button" class="btn btn-success"
                                                    href="{{ route('produksiwjl.operator.edit', $produksiwjl->slug) }}"><i
                                                        class="fa fa-forward"></i>
                                                    Lanjutkan Buat Laporan</a>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Tidak ada data untuk di serah terima.</p>
                                            @if ($action == 'create')
                                                <a type="button" class="btn btn-success"
                                                    href="{{ route('produksiwjl.operator.create_laporan', ['mesin_id' => $mesin_id, 'tanggal' => $tanggal, 'shift' => $shift]) }}"><i
                                                        class="fa fa-forward"></i>
                                                    Lanjutkan Buat Laporan</a>
                                            @else
                                                <a type="button" class="btn btn-success"
                                                    href="{{ route('produksiwjl.operator.edit', $produksiwjl->slug) }}"><i
                                                        class="fa fa-forward"></i>
                                                    Lanjutkan Buat Laporan</a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a type="button" class="btn btn-default"
                                    href="{{ route('produksiwjl.operator.index') }}"><i class="fa fa-reply"></i>
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
            var meter_awal = numeral($("#meter_awal").val()).format('0,0.0');
            var meter_akhir = numeral($("#meter_akhir").val()).format('0,0.0');
            var hasil = parseFloat(meter_akhir) - parseFloat(meter_awal);
            $("#hasil").val(numeral(hasil).format('0,0.0'));
        }
    </script>
@endsection
