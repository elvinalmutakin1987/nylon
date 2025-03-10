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
                            <li class="breadcrumb-item">Laporan Pengeringan Kain</li>
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
                        <form action="{{ route('produksilaminating.pengeringankain.update', $pengeringankain->slug) }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            @method('put')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Laporan Pengeringan Kain</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="wjl_tanggal">Tanggal</label>
                                                    <input type="text"
                                                        class="form-control @error('wjl_tanggal') is-invalid @enderror"
                                                        id="wjl_tanggal" name="wjl_tanggal"
                                                        value="{{ old('wjl_tanggal') ?? $pengeringankain->wjl_tanggal }}"
                                                        readonly>
                                                    @error('wjl_tanggal')
                                                        <span id="wjl_tanggal-error"
                                                            class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="wjl_operator">Operator</label>
                                                <input type="text"
                                                    class="form-control @error('wjl_operator') is-invalid @enderror"
                                                    id="wjl_operator" name="wjl_operator"
                                                    value="{{ old('wjl_operator') ?? $pengeringankain->wjl_operator }}"
                                                    readonly>
                                                @error('wjl_operator')
                                                    <span id="wjl_operator-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="wjl_jenis_kain">Jenis Kain</label>
                                                <input type="text"
                                                    class="form-control @error('wjl_jenis_kain') is-invalid @enderror"
                                                    id="wjl_jenis_kain" name="wjl_jenis_kain"
                                                    value="{{ old('wjl_jenis_kain') ?? $pengeringankain->wjl_jenis_kain }}"
                                                    readonly>
                                                @error('wjl_jenis_kain')
                                                    <span id="jenis_kain-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="wjl_no_roll">No. Roll</label>
                                                <input type="text"
                                                    class="form-control @error('wjl_no_roll') is-invalid @enderror"
                                                    id="wjl_no_roll" name="wjl_no_roll"
                                                    value="{{ old('wjl_no_roll') ?? $pengeringankain->wjl_no_roll }}">
                                                @error('wjl_no_roll')
                                                    <span id="wjl_no_roll-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="mesin_id">No. Mesin</label>
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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="wjl_kondisi_kain">Kondisi Kain</label>
                                                <input type="text"
                                                    class="form-control @error('wjl_kondisi_kain') is-invalid @enderror"
                                                    id="wjl_kondisi_kain" name="wjl_kondisi_kain"
                                                    value="{{ old('wjl_kondisi_kain') ?? $pengeringankain->wjl_kondisi_kain }}"
                                                    readonly>
                                                @error('wjl_kondisi_kain')
                                                    <span id="wjl_kondisi_kain-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="wjl_panjang">Panjang</label>
                                                <input type="text"
                                                    class="form-control @error('wjl_panjang') is-invalid @enderror"
                                                    id="wjl_panjang" name="wjl_panjang"
                                                    value="{{ old('wjl_panjang') ?? $pengeringankain->wjl_panjang }}"
                                                    readonly>
                                                @error('wjl_panjang')
                                                    <span id="wjl_panjang-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="wjl_lebar">Lebar</label>
                                                <input type="text"
                                                    class="form-control @error('wjl_lebar') is-invalid @enderror"
                                                    id="wjl_lebar" name="wjl_lebar"
                                                    value="{{ old('wjl_lebar') ?? $pengeringankain->wjl_lebar }}"
                                                    readonly>
                                                @error('wjl_lebar')
                                                    <span id="wjl_lebar-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="wjl_berat">Berat</label>
                                                <input type="text"
                                                    class="form-control @error('wjl_berat') is-invalid @enderror"
                                                    id="wjl_berat" name="wjl_berat"
                                                    value="{{ old('wjl_berat') ?? $pengeringankain->wjl_berat }}"
                                                    readonly>
                                                @error('wjl_berat')
                                                    <span id="wjl_berat-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <table id="table1" class="table projects">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 150px">Meter Ke</th>
                                                        <th>Kerusakan</th>
                                                        <th class="text-center" style="width: 50px"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" id="meter1"
                                                                name="meter[]">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control w-100"
                                                                id="kerusakan1" name="kerusakan[]">
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-danger"
                                                                id="hapus"><i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-primary"
                                                                onclick="tambah()"><i class="fa fa-plus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="operator_1">Operator</label>
                                                <input type="text"
                                                    class="form-control @error('operator_1') is-invalid @enderror"
                                                    id="operator_1" name="operator_1" value="{{ old('operator_1') }}">
                                                @error('operator_1')
                                                    <span id="operator_1-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="tanggal_1">Tanggal</label>
                                                <div class="input-group date" id="div_tanggal_1"
                                                    data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        data-target="#div_tanggal_1" id="tanggal_1" name="tanggal_1"
                                                        value="{{ old('tanggal_1') ?? date('Y-m-d') }}" />
                                                    <div class="input-group-append" data-target="#div_tanggal_1"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('tanggal')
                                                    <span id="nama-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div> --}}
                                        <div class="col-md-4">
                                            <div class="card card-primary card-tabs">
                                                <div class="card-header p-0 pt-1">
                                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="custom-tabs-one-home-tab"
                                                                data-toggle="pill" href="#custom-tabs-one-home"
                                                                role="tab" aria-controls="custom-tabs-one-home"
                                                                aria-selected="true">Pengeringan 1</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="custom-tabs-one-profile-tab"
                                                                data-toggle="pill" href="#custom-tabs-one-profile"
                                                                role="tab" aria-controls="custom-tabs-one-profile"
                                                                aria-selected="false">Pengeringan 2</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="custom-tabs-one-messages-tab"
                                                                data-toggle="pill" href="#custom-tabs-one-messages"
                                                                role="tab" aria-controls="custom-tabs-one-messages"
                                                                aria-selected="false">Pengeringan 3</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="card-body">
                                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                                        <div class="tab-pane fade show active" id="custom-tabs-one-home"
                                                            role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                                            <div class="form-group">
                                                                <label for="operator_1">Operator</label>
                                                                <input type="text"
                                                                    class="form-control @error('operator_1') is-invalid @enderror"
                                                                    id="operator_1" name="operator_1"
                                                                    value="{{ old('operator_1') }}">
                                                                @error('operator_1')
                                                                    <span id="operator_1-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tanggal_1">Tanggal</label>
                                                                <div class="input-group date" id="div_tanggal_1"
                                                                    data-target-input="nearest">
                                                                    <input type="text"
                                                                        class="form-control datetimepicker-input"
                                                                        data-target="#div_tanggal_1" id="tanggal_1"
                                                                        name="tanggal_1"
                                                                        value="{{ old('tanggal_1') ?? date('Y-m-d') }}" />
                                                                    <div class="input-group-append"
                                                                        data-target="#div_tanggal_1"
                                                                        data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i
                                                                                class="fa fa-calendar"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @error('tanggal')
                                                                    <span id="nama-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="jam_1">Jam</label>
                                                                <div class="input-group date" id="div_jam_1"
                                                                    data-target-input="nearest">
                                                                    <input type="text"
                                                                        class="form-control datetimepicker-input"
                                                                        data-target="#div_jam_1" id="jam_1"
                                                                        name="jam_1"
                                                                        value="{{ old('jam_1') ?? date('h:i:s') }}" />
                                                                    <div class="input-group-append"
                                                                        data-target="#div_jam_1"
                                                                        data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i
                                                                                class="fa fa-clock"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @error('tanggal')
                                                                    <span id="nama-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kondisi_kain_1">Kondisi Kain</label>
                                                                <select
                                                                    class="form-control select2 w-100 select-kondisi @error('kondisi_kain_1') is-invalid @enderror"
                                                                    id="kondisi_kain_1" name="kondisi_kain_1">
                                                                    <option value="Kering">Kering</option>
                                                                    <option value="Basah">Basah</option>
                                                                </select>
                                                                @error('kondisi_kain_1')
                                                                    <span id="kondisi_kain_1-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="berat_1">Berat</label>
                                                                <input type="text"
                                                                    class="form-control @error('berat_1') is-invalid @enderror"
                                                                    id="berat_1" name="berat_1"
                                                                    value="{{ old('berat_1') }}">
                                                                @error('berat_1')
                                                                    <span id="berat_1-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="panjang_1">Panjang</label>
                                                                <input type="text"
                                                                    class="form-control @error('panjang_1') is-invalid @enderror"
                                                                    id="panjang_1" name="panjang_1"
                                                                    value="{{ old('panjang_1') }}">
                                                                @error('panjang_1')
                                                                    <span id="panjang_1-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="suhu_1">Suhu</label>
                                                                <input type="text"
                                                                    class="form-control @error('suhu_1') is-invalid @enderror"
                                                                    id="suhu_1" name="suhu_1"
                                                                    value="{{ old('suhu_1') }}">
                                                                @error('suhu_1')
                                                                    <span id="suhu_1-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kecepatan_screw_1">Kcpt. Screw</label>
                                                                <input type="text"
                                                                    class="form-control @error('kecepatan_screw_1') is-invalid @enderror"
                                                                    id="kecepatan_screw_1" name="kecepatan_screw_1"
                                                                    value="{{ old('kecepatan_screw_1') }}">
                                                                @error('kecepatan_screw_1')
                                                                    <span id="kecepatan_screw_1-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kecapatan_winder_1">Kcpt. Winder</label>
                                                                <input type="text"
                                                                    class="form-control @error('kecapatan_winder_1') is-invalid @enderror"
                                                                    id="kecapatan_winder_1" name="kecapatan_winder_1"
                                                                    value="{{ old('kecapatan_winder_1') }}">
                                                                @error('kecapatan_winder_1')
                                                                    <span id="kecapatan_winder_1-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kondisi_kain2_1">Kondisi Kain</label>
                                                                <select
                                                                    class="form-control select2 w-100 select-kondisi-2 @error('kondisi_kain2_1') is-invalid @enderror"
                                                                    id="kondisi_kain2_1" name="kondisi_kain2_1">
                                                                    <option value=""></option>
                                                                    <option value="Bagus">Bagus</option>
                                                                    <option value="Ngelewer">Ngelewer</option>
                                                                    <option value="Nglipat">Nglipat</option>
                                                                </select>
                                                                @error('kondisi_kain2_1')
                                                                    <span id="kondisi_kain2_1-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="custom-tabs-one-profile"
                                                            role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                                            Mauris tincidunt mi at erat gravida, eget tristique urna
                                                            bibendum. Mauris pharetra purus ut ligula tempor, et vulputate
                                                            metus facilisis. Lorem ipsum dolor sit amet, consectetur
                                                            adipiscing elit. Vestibulum ante ipsum primis in faucibus orci
                                                            luctus et ultrices posuere cubilia Curae; Maecenas sollicitudin,
                                                            nisi a luctus interdum, nisl ligula placerat mi, quis posuere
                                                            purus ligula eu lectus. Donec nunc tellus, elementum sit amet
                                                            ultricies at, posuere nec nunc. Nunc euismod pellentesque diam.
                                                        </div>
                                                        <div class="tab-pane fade" id="custom-tabs-one-messages"
                                                            role="tabpanel"
                                                            aria-labelledby="custom-tabs-one-messages-tab">
                                                            Morbi turpis dolor, vulputate vitae felis non, tincidunt congue
                                                            mauris. Phasellus volutpat augue id mi placerat mollis. Vivamus
                                                            faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac
                                                            tristique nulla. Integer vestibulum orci odio. Cras nec augue
                                                            ipsum. Suspendisse ut velit condimentum, mattis urna a,
                                                            malesuada nunc. Curabitur eleifend facilisis velit finibus
                                                            tristique. Nam vulputate, eros non luctus efficitur, ipsum odio
                                                            volutpat massa, sit amet sollicitudin est libero sed ipsum.
                                                            Nulla lacinia, ex vitae gravida fermentum, lectus ipsum gravida
                                                            arcu, id fermentum metus arcu vel metus. Curabitur eget sem eu
                                                            risus tincidunt eleifend ac ornare magna.
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- /.card -->
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
            $('#div_tanggal_1').datetimepicker({
                format: 'YYYY-MM-DD'
            });
            $('#div_jam_1').datetimepicker({
                format: 'h:m:s'
            });

            format_select2();
        });

        function format_select2() {
            $('.select-shift').select2({
                width: '100%',
                minimumResultsForSearch: -1,
            });

            $('.select-kondisi').select2({
                width: '100%',
                minimumResultsForSearch: -1,
            });

            $('.select-kondisi-2').select2({
                width: '100%',
                placeholder: "- Pilih Kondisi -",
                allowClear: true,
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
