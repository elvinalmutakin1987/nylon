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
                            <li class="breadcrumb-item">Beam Atas Mesin</li>
                            <li class="breadcrumb-item" Active>Edit Data</li>
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
                        <form action="{{ route('produksiextruder.beamatasmesin.update', $beamatasmesin->slug) }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            @method('put')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Beam Atas Mesin</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal</label>
                                                <div class="input-group date" id="div_tanggal" data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        data-target="#div_tanggal" id="tanggal" name="tanggal"
                                                        value="{{ old('tanggal') ?? $beamatasmesin->tanggal }}" />
                                                    <div class="input-group-append" data-target="#div_tanggal"
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
                                        </div>
                                        <div class="form-group">
                                            <label for="beam_number">Beam Number</label>
                                            <select
                                                class="form-control select2 w-100 select-beam-number @error('beam_number') is-invalid @enderror"
                                                id="beam_number" name="beam_number">
                                                <option value="{{ $beamatasmesin->beam_number }}">
                                                    {{ $beamatasmesin->beam_number }}</option>
                                            </select>
                                            @error('beam_number')
                                                <span id="beam_number-error"
                                                    class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_produksi">Jenis Produksi</label>
                                            <select
                                                class="form-control select2 w-100 select-jenis-produksi @error('jenis_produksi') is-invalid @enderror"
                                                id="jenis_produksi" name="jenis_produksi">
                                                <option value="GCGU/ GCBU"
                                                    {{ $beamatasmesin->jenis_produksi == 'GCGU/ GCBU' ? 'selected' : '' }}>
                                                    GCGU/ GCBU</option>
                                                <option value="Wistaria"
                                                    {{ $beamatasmesin->jenis_produksi == 'Wistaria' ? 'selected' : '' }}>
                                                    Wistaria</option>
                                                <option value="30070i"
                                                    {{ $beamatasmesin->jenis_produksi == '30070i' ? 'selected' : '' }}>
                                                    30070i</option>
                                                <option value="Natalia Phinisi (rajutan 12)"
                                                    {{ $beamatasmesin->jenis_produksi == 'Natalia Phinisi (rajutan 12)' ? 'selected' : '' }}>
                                                    Natalia Phinisi (rajutan 12)</option>
                                                <option value="Natalia Phinisi (rajutan 11)"
                                                    {{ $beamatasmesin->jenis_produksi == 'Natalia Phinisi (rajutan 11)' ? 'selected' : '' }}>
                                                    Natalia Phinisi (rajutan 11)</option>
                                                <option value="Natalia Standard"
                                                    {{ $beamatasmesin->jenis_produksi == 'Natalia Standard' ? 'selected' : '' }}>
                                                    Natalia Standard</option>
                                                <option value="CWU"
                                                    {{ $beamatasmesin->jenis_produksi == 'CWU' ? 'selected' : '' }}>
                                                    CWU</option>
                                                <option value="PWU"
                                                    {{ $beamatasmesin->jenis_produksi == 'PWU' ? 'selected' : '' }}>
                                                    PWU</option>
                                            </select>
                                            @error('jenis_produksi')
                                                <span id="jenis_produksi-error"
                                                    class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="beam_sisa">Beam Sisa</label>
                                            <input type="text"
                                                class="form-control @error('beam_sisa') is-invalid @enderror" id="beam_sisa"
                                                name="beam_sisa" onblur="ubah_format('beam_sisa', this.value)"
                                                value="{{ $beamatasmesin->beam_sisa ? Illuminate\Support\Number::format($beamatasmesin->beam_sisa) : '' }}">
                                            @error('beam_sisa')
                                                <span id="beam_sisa-error"
                                                    class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="berat">Berat</label>
                                            <input type="text" class="form-control @error('berat') is-invalid @enderror"
                                                id="berat" name="berat" onblur="ubah_format('berat', this.value)"
                                                value="{{ $beamatasmesin->berat ? Illuminate\Support\Number::format($beamatasmesin->berat) : '' }}">
                                            @error('berat')
                                                <span id="berat-error"
                                                    class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="button" class="btn btn-default"
                                        href="{{ route('produksiextruder.beamatasmesin.index') }}"><i
                                            class="fa fa-reply"></i>
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
@endsection


@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#div_tanggal').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            $('#div_tanggal').on('change.datetimepicker', function(e) {
                $('.select-beam-number').val(null).trigger('change');
            });

            format_select2();
        });

        function format_select2() {
            $('.select-beam-number').select2({
                placeholder: "- Beam Number -",
                allowClear: true,
                ajax: {
                    url: '{{ route('produksiextruder.beamatasmesin.get_beamnumber') }}',
                    dataType: 'json',
                    data: function(params) {
                        return {
                            term: params.term || '',
                            page: params.page || 1,
                            tanggal: $('#tanggal').val() || '{{ date('Y-m-d') }}',
                        };
                    },
                    cache: true,
                }
            });

            $('.select-jenis-produksi').select2({
                placeholder: "- Jenis Produksi -",
                allowClear: true,
            });
        }

        function ubah_format(field, nilai) {
            var mynumeral = numeral(nilai).format('0,0');
            $("#" + field).val(mynumeral);
        }
    </script>
@endsection
