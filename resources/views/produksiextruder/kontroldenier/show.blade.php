@php
    use Illuminate\Support\Number;
    use App\Models\Mesin;
    use App\Models\Material;
    use App\Models\Kontroldenierdetail;
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
                                <h3 class="card-title">Serah Terima Laporan Kontrol Denier</h3>
                            </div>
                            <div class="card-body">
                                @if ($kontroldenier_sebelumnya)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="tanggal">Tanggal</label>
                                                    <input type="text"
                                                        class="form-control @error('tanggal') is-invalid @enderror"
                                                        id="tanggal" name="tanggal"
                                                        value="{{ old('tanggal') ?? $kontroldenier_sebelumnya->tanggal }}"
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
                                                <input type="text"
                                                    class="form-control @error('shift') is-invalid @enderror" id="shift"
                                                    name="shift"
                                                    value="{{ old('shift') ?? $kontroldenier_sebelumnya->shift }}" readonly>
                                                @error('shift')
                                                    <span id="shift-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        @php
                                            $material = Material::find($kontroldenier_sebelumnya->material_id);
                                        @endphp
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="material_id">Jenis Benang</label>
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="d_bottom">Denier</label>
                                                <input type="text"
                                                    class="form-control @error('jenis_benang') is-invalid @enderror"
                                                    id="jenis_benang" name="jenis_benang"
                                                    value="{{ $kontroldenier_sebelumnya->jenis_benang }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="k_min_bottom">K -</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text"
                                                            class="form-control @error('k_min_bottom') is-invalid @enderror"
                                                            id="k_min_bottom" name="k_min_bottom"
                                                            value="{{ $kontroldenier_sebelumnya->k_min_bottom }}" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text"
                                                            class="form-control @error('k_min_top') is-invalid @enderror"
                                                            id="k_min_top" name="k_min_top"
                                                            value="{{ $kontroldenier_sebelumnya->k_min_top }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="k_bottom">K</label>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <input type="text"
                                                            class="form-control @error('k_bottom') is-invalid @enderror"
                                                            id="k_bottom" name="k_bottom"
                                                            value="{{ $kontroldenier_sebelumnya->k_bottom }}" readonly>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text"
                                                            class="form-control @error('k_top') is-invalid @enderror"
                                                            id="k_top" name="k_top"
                                                            value="{{ $kontroldenier_sebelumnya->k_top }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="n_bottom">N</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text"
                                                            class="form-control @error('n_bottom') is-invalid @enderror"
                                                            id="n_bottom" name="n_bottom"
                                                            value="{{ $kontroldenier_sebelumnya->n_bottom }}" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text"
                                                            class="form-control @error('n_top') is-invalid @enderror"
                                                            id="n_top" name="n_top"
                                                            value="{{ $kontroldenier_sebelumnya->n_top }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="d_bottom">D</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text"
                                                            class="form-control @error('d_bottom') is-invalid @enderror"
                                                            id="d_bottom" name="d_bottom"
                                                            value="{{ $kontroldenier_sebelumnya->d_bottom }}" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text"
                                                            class="form-control @error('d_top') is-invalid @enderror"
                                                            id="d_top" name="d_top"
                                                            value="{{ $kontroldenier_sebelumnya->d_top }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="d_plus_bottom">D +</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text"
                                                            class="form-control @error('d_plus_bottom') is-invalid @enderror"
                                                            id="d_plus_bottom" name="d_plus_bottom"
                                                            value="{{ $kontroldenier_sebelumnya->d_plus_bottom }}"
                                                            readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text"
                                                            class="form-control @error('d_plus_top') is-invalid @enderror"
                                                            id="d_plus_top" name="d_plus_top"
                                                            value="{{ $kontroldenier_sebelumnya->d_plus_top }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @if ($action == 'create')
                                                        <a type="button" class="btn btn-success"
                                                            href="{{ route('produksiextruder-kontrol-denier.create_laporan', ['material_id' => $material_id, 'tanggal' => $tanggal, 'shift' => $shift]) }}"><i
                                                                class="fa fa-forward"></i>
                                                            Lanjutkan Buat Laporan</a>
                                                    @else
                                                        <p> <span class="badge badge-success"><i
                                                                    class="fa fa-check"></i></span> Saya
                                                            telah
                                                            membaca, mengerti dan menyetujui serah terima laporan produksi
                                                            ini.
                                                        </p>

                                                        <a type="button" class="btn btn-success"
                                                            href="{{ route('produksiextruder-kontrol-denier.edit', $kontroldenier->slug) }}"><i
                                                                class="fa fa-forward"></i>
                                                            Lanjutkan Buat Laporan</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <table id="table1" class="table projects">
                                                <thead>
                                                    <tr>
                                                        <th width="30">No.</th>
                                                        <th>Nilai</th>
                                                        <th>Rank</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($kontroldenier_sebelumnya->kontroldenierdetail as $d)
                                                        <tr>
                                                            <td>{{ $d->no_lokasi }}</td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    id="nilai{{ $d->id }}" name="nilai[]"
                                                                    value="{{ $d->nilai == '0' ? '' : $d->nilai }}"
                                                                    readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control"
                                                                    id="rank{{ $d->id }}" name="rank[]"
                                                                    value="{{ $d->nilai == '0' ? '' : $d->rank }}"
                                                                    readonly>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="d_bottom">Denier</label>
                                                <input type="text"
                                                    class="form-control @error('jenis_benang') is-invalid @enderror"
                                                    id="jenis_benang" name="jenis_benang"
                                                    value="{{ $kontroldenier->jenis_benang }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="k_min_bottom">K -</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text"
                                                            class="form-control @error('k_min_bottom') is-invalid @enderror"
                                                            id="k_min_bottom" name="k_min_bottom"
                                                            value="{{ $kontroldenier->k_min_bottom }}" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text"
                                                            class="form-control @error('k_min_top') is-invalid @enderror"
                                                            id="k_min_top" name="k_min_top"
                                                            value="{{ $kontroldenier->k_min_top }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="k_bottom">K</label>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <input type="text"
                                                            class="form-control @error('k_bottom') is-invalid @enderror"
                                                            id="k_bottom" name="k_bottom"
                                                            value="{{ $kontroldenier->k_bottom }}" readonly>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text"
                                                            class="form-control @error('k_top') is-invalid @enderror"
                                                            id="k_top" name="k_top"
                                                            value="{{ $kontroldenier->k_top }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="n_bottom">N</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text"
                                                            class="form-control @error('n_bottom') is-invalid @enderror"
                                                            id="n_bottom" name="n_bottom"
                                                            value="{{ $kontroldenier->n_bottom }}" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text"
                                                            class="form-control @error('n_top') is-invalid @enderror"
                                                            id="n_top" name="n_top"
                                                            value="{{ $kontroldenier->n_top }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="d_bottom">D</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text"
                                                            class="form-control @error('d_bottom') is-invalid @enderror"
                                                            id="d_bottom" name="d_bottom"
                                                            value="{{ $kontroldenier->d_bottom }}" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text"
                                                            class="form-control @error('d_top') is-invalid @enderror"
                                                            id="d_top" name="d_top"
                                                            value="{{ $kontroldenier->d_top }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="d_plus_bottom">D +</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="text"
                                                            class="form-control @error('d_plus_bottom') is-invalid @enderror"
                                                            id="d_plus_bottom" name="d_plus_bottom"
                                                            value="{{ $kontroldenier->d_plus_bottom }}" readonly>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text"
                                                            class="form-control @error('d_plus_top') is-invalid @enderror"
                                                            id="d_plus_top" name="d_plus_top"
                                                            value="{{ $kontroldenier->d_plus_top }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <p> <span class="badge badge-success"><i
                                                                class="fa fa-check"></i></span> Saya
                                                        telah
                                                        membaca, mengerti dan menyetujui serah terima laporan produksi
                                                        ini.
                                                    </p>
                                                    @if ($action == 'create')
                                                        <a type="button" class="btn btn-success"
                                                            href="{{ route('produksiextruder-kontrol-denier.create_laporan', ['material_id' => $material_id, 'tanggal' => $tanggal, 'shift' => $shift]) }}"><i
                                                                class="fa fa-forward"></i>
                                                            Lanjutkan Buat Laporan</a>
                                                    @else
                                                        <a type="button" class="btn btn-success"
                                                            href="{{ route('produksiextruder-kontrol-denier.edit', $kontroldenier->slug) }}"><i
                                                                class="fa fa-forward"></i>
                                                            Lanjutkan Buat Laporan</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <p>Tidak ada data untuk di serah terima.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a type="button" class="btn btn-default"
                                    href="{{ route('produksiextruder-kontrol-denier.index') }}"><i
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

        function ubah_format(field, nilai) {
            var mynumeral = numeral(nilai).format('0');
            // mynumeral = parseFloat(mynumeral) / 1000
            // mynumeral = numeral(mynumeral).format('0.000')
            $("#" + field).val(mynumeral);
        }
    </script>
@endsection
