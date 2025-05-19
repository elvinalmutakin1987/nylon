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
                            <li class="breadcrumb-item">Check List Beaming</li>
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
                                <h3 class="card-title">Serah Terima Check List Beaming</h3>
                            </div>
                            <div class="card-body">
                                @if ($checklistbeaming_sebelumnya)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="tanggal">Tanggal</label>
                                                    <input type="text"
                                                        class="form-control @error('tanggal') is-invalid @enderror"
                                                        id="tanggal" name="tanggal"
                                                        value="{{ $checklistbeaming_sebelumnya->tanggal }}" readonly>
                                                    @error('tanggal')
                                                        <span id="tanggal-error"
                                                            class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="shift">Shift</label>
                                                <input type="text"
                                                    class="form-control @error('shift') is-invalid @enderror" id="shift"
                                                    name="shift" value="{{ $checklistbeaming_sebelumnya->shift }}"
                                                    readonly>
                                                @error('shift')
                                                    <span id="shift-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Motif Sesuai</label>
                                                <div class="form-check d-inline m-4">
                                                    <input type="checkbox" class="form-check-input" id="motif_sesuai_1"
                                                        name="motif_sesuai_1"
                                                        {{ $checklistbeaming_sebelumnya->motif_sesuai_1 == 1 ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check-label" for="motif_sesuai_1">1</label>
                                                </div>
                                                <div class="form-check d-inline m-4">
                                                    <input type="checkbox" class="form-check-input" id="motif_sesuai_2"
                                                        name="motif_sesuai_2"
                                                        {{ $checklistbeaming_sebelumnya->motif_sesuai_2 == 1 ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check-label" for="motif_sesuai_2">2</label>
                                                </div>
                                                <div class="form-check d-inline m-4">
                                                    <input type="checkbox" class="form-check-input" id="motif_sesuai_3"
                                                        name="motif_sesuai_3"
                                                        {{ $checklistbeaming_sebelumnya->motif_sesuai_3 == 1 ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check-label" for="motif_sesuai_3">3</label>
                                                </div>
                                                <div class="form-check d-inline m-4">
                                                    <input type="checkbox" class="form-check-input" id="motif_sesuai_4"
                                                        name="motif_sesuai_4"
                                                        {{ $checklistbeaming_sebelumnya->motif_sesuai_4 == 1 ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check-label" for="motif_sesuai_4">4</label>
                                                </div>
                                                <div class="form-check d-inline m-4">
                                                    <input type="checkbox" class="form-check-input" id="motif_sesuai_5"
                                                        name="motif_sesuai_5"
                                                        {{ $checklistbeaming_sebelumnya->motif_sesuai_5 == 1 ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check-label" for="motif_sesuai_5">5</label>
                                                </div>
                                                <div class="form-check d-inline m-4">
                                                    <input type="checkbox" class="form-check-input" id="motif_sesuai_6"
                                                        name="motif_sesuai_6"
                                                        {{ $checklistbeaming_sebelumnya->motif_sesuai_6 == 1 ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check-label" for="motif_sesuai_6">6</label>
                                                </div>
                                                <div class="form-check d-inline m-4">
                                                    <input type="checkbox" class="form-check-input" id="motif_sesuai_7"
                                                        name="motif_sesuai_7"
                                                        {{ $checklistbeaming_sebelumnya->motif_sesuai_7 == 1 ? 'checked' : '' }}
                                                        disabled>
                                                    <label class="form-check-label" for="motif_sesuai_7">7</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive p-0">
                                                <table id="table1" class="table projects table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="text-center" style="width: 30%">
                                                                Lingkaran (M)
                                                            </th>
                                                            <th scope="col" class="text-center" style="width: 30%">
                                                                Nilai (cm)
                                                            </th>
                                                            <th scope="col" class="text-center" style="width: 30%">
                                                                Waktu
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($checklistbeaming_sebelumnya->checklistbeamingdetail as $d)
                                                            <tr>
                                                                <td>
                                                                    {{ $d->diameter_beam_timur }}
                                                                </td>
                                                                <td>
                                                                    {{ $d->diameter_beam_barat }}
                                                                </td>
                                                                <td>
                                                                    {{ $d->diameter_beam_1m_dari_timur }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="jumlah_benang_putus">Jumlah Benang Putus</label>
                                                    <input type="text"
                                                        class="form-control @error('jumlah_benang_putus') is-invalid @enderror"
                                                        id="jumlah_benang_putus" name="jumlah_benang_putus"
                                                        value="{{ $checklistbeaming_sebelumnya->jumlah_benang_putus }}"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="jumlah_benang">Jumlah Benang</label>
                                                <input type="text"
                                                    class="form-control @error('jumlah_benang') is-invalid @enderror"
                                                    id="jumlah_benang" name="jumlah_benang"
                                                    value="{{ $checklistbeaming_sebelumnya->jumlah_benang }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="produksi">Produksi</label>
                                                    <input type="text"
                                                        class="form-control @error('produksi') is-invalid @enderror"
                                                        id="produksi" name="produksi"
                                                        value="{{ $checklistbeaming_sebelumnya->produksi }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lebar_beam">Lebar Beam</label>
                                                <input type="text"
                                                    class="form-control @error('lebar_beam') is-invalid @enderror"
                                                    id="lebar_beam" name="lebar_beam"
                                                    value="{{ $checklistbeaming_sebelumnya->lebar_beam }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if ($action == 'create')
                                                <a type="button" class="btn btn-success"
                                                    href="{{ route('produksiextruder.checklistbeaming.create_laporan', ['tanggal' => $tanggal, 'shift' => $shift, 'mesin_id' => $mesin_id]) }}"><i
                                                        class="fa fa-forward"></i>
                                                    Lanjutkan Buat Laporan</a>
                                            @else
                                                <a type="button" class="btn btn-success"
                                                    href="{{ route('produksiextruder.checklistbeaming.edit', $checklistbeaming->slug) }}"><i
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
                                                    href="{{ route('produksiextruder.checklistbeaming.create_laporan', ['tanggal' => $tanggal, 'shift' => $shift, 'mesin_id' => $mesin_id]) }}"><i
                                                        class="fa fa-forward"></i>
                                                    Lanjutkan Buat Laporan</a>
                                            @else
                                                <a type="button" class="btn btn-success"
                                                    href="{{ route('produksiextruder.checklistbeaming.edit', $checklistbeaming->slug) }}"><i
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
                                    href="{{ route('produksiextruder.checklistbeaming.index') }}"><i
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
                    url: '{{ route('produksiextruder.checklistbeaming.get_mesin') }}',
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
