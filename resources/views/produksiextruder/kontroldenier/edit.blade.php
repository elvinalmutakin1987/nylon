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
                                    <div class="row mb-4">

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
                                                        value="{{ old('k_bottom') ?? $kontroldenier->k_bottom }}" readonly>
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
                                        <div class="col-md-6">
                                            <table id="table1" class="table projects table-bordered">
                                                <thead>
                                                    <tr style="background-color: red; color: white">
                                                        <th colspan="4" class="text-center">KR</th>
                                                    </tr>
                                                    <tr>
                                                        <th width="30">No.</th>
                                                        <th>Nilai</th>
                                                        <th>Rank</th>
                                                        <th width="50">

                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            1
                                                        </td>
                                                        <td>
                                                            <input class="kr_lokasi" type="hidden" id="kr_no_lokasi_1"
                                                                name="kr_no_lokasi[]" value="1">
                                                            <input type="text" class="form-control nilai_kiri"
                                                                id="kr_nilai_1" name="kr_nilai[]"
                                                                onblur="ubah_format('nilai_1', this.value)">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control kr_rank"
                                                                id="kr_rank_1" name="kr_rank[]" readonly>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"
                                                                onclick="tambah_kiri()"><i class="fa fa-plus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table id="table2" class="table projects table-bordered">
                                                <thead>
                                                    <tr style="background-color: blue; color: white">
                                                        <th colspan="4" class="text-center">KN</th>
                                                    </tr>
                                                    <tr>
                                                        <th width="30">No.</th>
                                                        <th>Nilai</th>
                                                        <th>Rank</th>
                                                        <th width="50"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            1
                                                        </td>
                                                        <td>
                                                            <input class="kn_lokasi" type="hidden" id="kn_no_lokasi_1"
                                                                name="kn_no_lokasi[]" value="1">
                                                            <input type="text" class="form-control nilai_kanan"
                                                                id="kn_nilai_1" name="kn_nilai[]"
                                                                onblur="ubah_format('nilai', this.value); hitung_hasil', this.value)">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control kn_rank"
                                                                id="kn_rank_1" name="kn_rank[]" readonly>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary"
                                                                onclick="tambah_kanan()"><i class="fa fa-plus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <table id="table3" class="table projects table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="30">No.</th>
                                                        <th>Rank</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>K -</td>
                                                        <td id="hasil_k_minus"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>K</td>
                                                        <td id="hasil_k"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>N</td>
                                                        <td id="hasil_n"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>B</td>
                                                        <td id="hasil_b"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>B +</td>
                                                        <td id="hasil_b_plus"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="">KR</label>
                                            <table id="table-kr" style="width: 100%; table-layout: fixed;;">

                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="">KN</label>
                                            <table id="table-kn" style="width: 100%; table-layout: fixed;">

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
        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $(document).ready(function() {
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
            //$("#" + field).val(hasil);
            return hasil
        }

        $("#table1").on("click", "#hapus", function() {
            $(this).closest("tr").remove();
            gen_urut_kiri();
            rekap_rank();
        });

        $("#table2").on("click", "#hapus", function() {
            $(this).closest("tr").remove();
            gen_urut_kanan();
            rekap_rank();
        });

        $(".nilai_kiri").on('keyup', function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) {
                var tr = $(this).closest('tr')
                var nilai = numeral(this.value).format('0');
                var hasil = hitung_hasil('', nilai);
                var tbody_row = $('#table1').find('tr').length;
                var row_id = Date.now().toString(36) + Math.random().toString(36).substr(2);
                $("#table1 > tbody > tr:last").before(`
            <tr>
                <td>
                    1
                </td>
                <td>
                    <input class="kr_lokasi" type="hidden" id="kr_no_lokasi_${row_id}"
                        name="kr_no_lokasi[]" value="1">
                    <input type="text" class="form-control nilai_kiri"
                        id="kr_nilai_${row_id}" name="kr_nilai[]"
                        onblur="ubah_format('kr_nilai_${row_id}', this.value);" value="${nilai}" readonly>
                </td>
                <td>
                    <input type="text" class="form-control kr_rank" id="kr_rank_${row_id}"
                        name="kr_rank[]" readonly value="${hasil}">
                </td>
                <td>
                    <button type="button" class="btn btn-danger"
                        id="hapus"><i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `);
                gen_urut_kiri();
                this.value = '';
                tr.find('.kr_rank').val('')
                rekap_rank()
            }
        })

        $(".nilai_kiri").blur(function(e) {
            var tr = $(this).closest('tr')
            var hasil = hitung_hasil('', this.value);
            tr.find('.kr_rank').val(this.value != '' ? hasil : '')
            rekap_rank()
        })

        $(".nilai_kanan").on('keyup', function(e) {
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) {
                var tr = $(this).closest('tr')
                var nilai = numeral(this.value).format('0');
                var hasil = hitung_hasil('', nilai);
                var tbody_row = $('#table2').find('tr').length;
                var row_id = Date.now().toString(36) + Math.random().toString(36).substr(2);
                var lokasi =
                    $("#table2 > tbody > tr:last").before(`
            <tr>
                <td>
                    1
                </td>
                <td>
                    <input class="kn_lokasi" type="hidden" id="kn_no_lokasi_${row_id}"
                        name="kn_no_lokasi[]" value="1">
                    <input type="text" class="form-control nilai_kanan"
                        id="kn_nilai_${row_id}" name="kn_nilai[]"
                        onblur="ubah_format('kn_nilai_${row_id}', this.value);" value="${nilai}" readonly>
                </td>
                <td>
                    <input type="text" class="form-control kn_rank" id="kn_rank_${row_id}"
                        name="kn_rank[]" readonly value="${hasil}">
                </td>
                <td>
                    <button type="button" class="btn btn-danger"
                        id="hapus"><i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `);
                gen_urut_kanan();
                this.value = '';
                tr.find('.kn_rank').val('')
                rekap_rank()
            }
        })

        $(".nilai_kanan").blur(function(e) {
            var tr = $(this).closest('tr')
            var hasil = hitung_hasil('', this.value);
            tr.find('.kn_rank').val(this.value != '' ? hasil : '')
            rekap_rank()
        })

        function gen_urut_kiri() {
            var no = 1;
            $('#table1 > tbody  > tr').each(function(index, tr) {
                $(this).find("td:first").html(index + 1);
                $(this).find(".kr_lokasi").val(index + 1);
            });
        }

        function gen_urut_kanan() {
            var no = 1;
            $('#table2 > tbody  > tr').each(function(index, tr) {
                $(this).find("td:first").html(index + 1);
                $(this).find(".kn_lokasi").val(index + 1);
            });
        }

        function tambah_kiri() {
            var nilai = numeral($("#kr_nilai_1").val()).format('0');
            var hasil = hitung_hasil('', nilai);
            var tbody_row = $('#table1').find('tr').length;
            var row_id = Date.now().toString(36) + Math.random().toString(36).substr(2);
            $("#table1 > tbody > tr:last").before(`
            <tr>
                <td>
                    1
                </td>
                <td>
                    <input class="kr_lokasi" type="hidden" id="kr_no_lokasi_${row_id}"
                        name="kr_no_lokasi[]" value="1">
                    <input type="text" class="form-control nilai_kiri"
                        id="kr_nilai_${row_id}" name="kr_nilai[]"
                        onblur="ubah_format('kr_nilai_${row_id}', this.value);" value="${nilai}" readonly>
                </td>
                <td>
                    <input type="text" class="form-control kr_rank" id="kr_rank_${row_id}"
                        name="kr_rank[]" readonly value="${hasil}">
                </td>
                <td>
                    <button type="button" class="btn btn-danger"
                        id="hapus"><i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `);
            gen_urut_kiri();
            $("#kr_nilai_1").val('')
            $("#kr_rank_1").val('')
            rekap_rank()
        }

        function tambah_kanan() {
            var nilai = numeral($("#kn_nilai_1").val()).format('0');
            var hasil = hitung_hasil('', nilai);
            var tbody_row = $('#table2').find('tr').length;
            var row_id = Date.now().toString(36) + Math.random().toString(36).substr(2);
            $("#table2 > tbody > tr:last").before(`
            <tr>
                <td>
                    1
                </td>
                <td>
                    <input class="kn_lokasi" type="hidden" id="kr_no_lokasi_${row_id}"
                        name="kr_no_lokasi[]" value="1">
                    <input type="text" class="form-control nilai_kanan"
                        id="kn_nilai_${row_id}" name="kn_nilai[]"
                        onblur="ubah_format('kn_nilai_${row_id}', this.value);" value="${nilai}" readonly>
                </td>
                <td>
                    <input type="text" class="form-control kn_rank" id="kn_rank_${row_id}"
                        name="kn_rank[]" readonly value="${hasil}">
                </td>
                <td>
                    <button type="button" class="btn btn-danger"
                        id="hapus"><i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `);
            gen_urut_kanan();
            $("#kn_nilai_1").val('')
            $("#kn_rank_1").val('')
            rekap_rank()
        }

        function rekap_rank() {
            $("#table-kr").empty()
            $("#table-kn").empty()
            var hasil_k = 0;
            var hasil_k_minus = 0;
            var hasil_n = 0;
            var hasil_b = 0;
            var hasil_b_plus = 0;
            var table1 = `<tr>`;
            var table2 = `<tr>`;
            $('#table1 > tbody  > tr').each(function(index, tr) {
                if ($(tr).find(".kr_rank").val() != '' && $(tr).find(".nilai_kiri").val() != '') {
                    if ($(tr).find(".kr_rank").val() == 'K -') {
                        hasil_k_minus += 1;
                        table1 += `
                    <td style="background-color: red; color:white"
                                                    class="text-center">${$(tr).find(".kr_lokasi").val()}</td>
                    `;
                    }
                    if ($(tr).find(".kr_rank").val() == 'K') {
                        hasil_k += 1;
                        table1 += `
                    <td style="background-color: yellow; color:black"
                                                    class="text-center">${$(tr).find(".kr_lokasi").val()}</td>
                    `;
                    }
                    if ($(tr).find(".kr_rank").val() == 'N') {
                        hasil_n += 1;
                        table1 += `
                    <td style="background-color: green; color:white"
                                                    class="text-center">${$(tr).find(".kr_lokasi").val()}</td>
                    `;
                    }
                    if ($(tr).find(".kr_rank").val() == 'B') {
                        hasil_b += 1;
                        table1 += `
                    <td style="background-color: aqua; color:black"
                                                    class="text-center">${$(tr).find(".kr_lokasi").val()}</td>
                    `;
                    }
                    if ($(tr).find(".kr_rank").val() == 'B +') {
                        hasil_b_plus += 1;
                        table1 += `
                    <td style="background-color: blue; color:white"
                                                    class="text-center">${$(tr).find(".kr_lokasi").val()}</td>
                    `;
                    }
                }
            });
            $('#table2 > tbody  > tr').each(function(index, tr) {
                if ($(tr).find(".kn_rank").val() != '' && $(tr).find(".nilai_kanan").val() != '') {
                    if ($(tr).find(".kn_rank").val() == 'K -') {
                        hasil_k_minus += 1;
                        table2 += `
                    <td style="background-color: red; color:white"
                                                    class="text-center">${$(tr).find(".kn_lokasi").val()}</td>
                    `;
                    }
                    if ($(tr).find(".kn_rank").val() == 'K') {
                        hasil_k += 1;
                        table2 += `
                    <td style="background-color: yellow; color:black"
                                                    class="text-center">${$(tr).find(".kn_lokasi").val()}</td>
                    `;
                    }
                    if ($(tr).find(".kn_rank").val() == 'N') {
                        hasil_n += 1;
                        table2 += `
                    <td style="background-color: green; color:white"
                                                    class="text-center">${$(tr).find(".kn_lokasi").val()}</td>
                    `;
                    }
                    if ($(tr).find(".kn_rank").val() == 'B') {
                        hasil_b += 1;
                        table2 += `
                    <td style="background-color: aqua; color:black"
                                                    class="text-center">${$(tr).find(".kn_lokasi").val()}</td>
                    `;
                    }
                    if ($(tr).find(".kn_rank").val() == 'B +') {
                        hasil_b_plus += 1;
                        table2 += `
                    <td style="background-color: blue; color:white"
                                                    class="text-center">${$(tr).find(".kn_lokasi").val()}</td>
                    `;
                    }
                }
            });
            $("#hasil_k_minus").html(hasil_k_minus);
            $("#hasil_k").html(hasil_k);
            $("#hasil_n").html(hasil_n);
            $("#hasil_b").html(hasil_b);
            $("#hasil_b_plus").html(hasil_b_plus);
            table1 += `</tr>`;
            table2 += `</tr>`;
            $("#table-kr").append(table1);
            $("#table-kn").append(table2);
        }
    </script>
@endsection
