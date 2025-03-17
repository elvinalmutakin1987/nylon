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
                                            <label for="tanggal">Tanggal</label>
                                            <div class="input-group date" id="div_tanggal" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input"
                                                    data-target="#div_tanggal" id="tanggal" name="tanggal"
                                                    value="{{ old('tanggal') ?? date('Y-m-d') }}" />
                                                <div class="input-group-append" data-target="#div_tanggal"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('tanggal')
                                                <span id="nama-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="shift">Shift</label>
                                            <select
                                                class="form-control select2 w-100 select-shift @error('shift') is-invalid @enderror"
                                                id="shift" name="shift">
                                                <option value="Pagi">Pagi</option>
                                                <option value="Sore">Sore</option>
                                                <option value="Malam">Malam</option>
                                            </select>
                                            @error('shift')
                                                <span id="shift-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mesin_id">Jenis Benang</label>
                                            <select
                                                class="form-control select2 w-100 select-jenis-benang @error('material_id') is-invalid @enderror"
                                                id="material_id" name="material_id">
                                            </select>
                                            @error('material_id')
                                                <span id="material_id-error"
                                                    class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="d_bottom">Denier</label>
                                    <input type="text" class="form-control @error('jenis_benang') is-invalid @enderror"
                                        id="jenis_benang" name="jenis_benang" value="{{ old('jenis_benang') }}">
                                </div>
                                <div class="form-group">
                                    <label for="k_min_bottom">K -</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text"
                                                class="form-control @error('k_min_bottom') is-invalid @enderror"
                                                id="k_min_bottom" name="k_min_bottom" value="{{ old('k_min_bottom') }}"
                                                onblur="ubah_format('k_min_bottom', this.value);">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text"
                                                class="form-control @error('k_min_top') is-invalid @enderror" id="k_min_top"
                                                name="k_min_top" value="{{ old('k_min_top') }}"
                                                onblur="ubah_format('k_min_top', this.value);">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="k_bottom">K</label>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <input type="text"
                                                class="form-control @error('k_bottom') is-invalid @enderror" id="k_bottom"
                                                name="k_bottom" value="{{ old('k_bottom') }}"
                                                onblur="ubah_format('k_bottom', this.value);">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control @error('k_top') is-invalid @enderror"
                                                id="k_top" name="k_top" value="{{ old('k_top') }}"
                                                onblur="ubah_format('k_top', this.value);">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="n_bottom">N</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text"
                                                class="form-control @error('n_bottom') is-invalid @enderror"
                                                id="n_bottom" name="n_bottom" value="{{ old('n_bottom') }}"
                                                onblur="ubah_format('n_bottom', this.value);">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text"
                                                class="form-control @error('n_top') is-invalid @enderror" id="n_top"
                                                name="n_top" value="{{ old('n_top') }}"
                                                onblur="ubah_format('n_top', this.value);">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="d_bottom">B</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text"
                                                class="form-control @error('d_bottom') is-invalid @enderror"
                                                id="d_bottom" name="d_bottom" value="{{ old('d_bottom') }}"
                                                onblur="ubah_format('d_bottom', this.value);">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text"
                                                class="form-control @error('d_top') is-invalid @enderror" id="d_top"
                                                name="d_top" value="{{ old('d_top') }}"
                                                onblur="ubah_format('d_top', this.value);">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="d_plus_bottom">B +</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text"
                                                class="form-control @error('d_plus_bottom') is-invalid @enderror"
                                                id="d_plus_bottom" name="d_plus_bottom"
                                                value="{{ old('d_plus_bottom') }}"
                                                onblur="ubah_format('d_plus_bottom', this.value);">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text"
                                                class="form-control @error('d_plus_top') is-invalid @enderror"
                                                id="d_plus_top" name="d_plus_top" value="{{ old('d_plus_top') }}"
                                                onblur="ubah_format('d_plus_top', this.value);">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#modal-import" onclick="lihat_laporan_sebelumnya()"><i
                                                class="fa fa-plus"></i>
                                            Buat Laporan Kontrol Denier</button>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a type="button" class="btn btn-default" href="{{ route('produksi.index') }}"><i
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

            $('.select-jenis-benang').select2({
                placeholder: "- Pilih Jenis Benang -",
                allowClear: true,
                ajax: {
                    url: '{{ route('produksiextruder-kontrol-denier.get_material') }}',
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

        function lihat_laporan_sebelumnya() {
            var url =
                '{!! route('produksiextruder-kontrol-denier.create', [
                    'material_id' => '_material',
                    'tanggal' => '_tanggal',
                    'shift' => '_shift',
                    'jenis_benang' => '_jenis_benang',
                    'd_plus_bottom' => '_d_plus_bottom',
                    'd_plus_top' => '_d_plus_top',
                    'd_bottom' => '_d_bottom',
                    'd_top' => '_d_top',
                    'n_bottom' => '_n_bottom',
                    'n_top' => '_n_top',
                    'k_bottom' => '_k_bottom',
                    'k_top' => '_k_top',
                    'k_min_bottom' => '_k_min_bottom',
                    'k_min_top' => '_k_min_top',
                ]) !!}';
            url = url.replace('_material', $("#material_id").val());
            url = url.replace('_tanggal', $("#tanggal").val());
            url = url.replace('_shift', $("#shift").val());
            url = url.replace('_jenis_benang', $("#jenis_benang").val());
            url = url.replace('_d_plus_bottom', $("#d_plus_bottom").val());
            url = url.replace('_d_plus_top', $("#d_plus_top").val());
            url = url.replace('_d_bottom', $("#d_bottom").val());
            url = url.replace('_d_top', $("#d_top").val());
            url = url.replace('_n_bottom', $("#n_bottom").val());
            url = url.replace('_n_top', $("#n_top").val());
            url = url.replace('_k_bottom', $("#k_bottom").val());
            url = url.replace('_k_top', $("#k_top").val());
            url = url.replace('_k_min_bottom', $("#k_min_bottom").val());
            url = url.replace('_k_min_top', $("#k_min_top").val());
            window.open(url, "_self");
        }

        $("#material_id").on('change', function() {
            var text = $("#material_id").select2('data')[0]['text'];
            $("#jenis_benang").val(text.substr(text.length - 4, 3));
        })
    </script>
@endsection
