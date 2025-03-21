@php
    use Illuminate\Support\Number;
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
                            <li class="breadcrumb-item"><a href="{{ route('datamaster.index') }}" class="text-dark">Data
                                    Master</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('mesin.index') }}" class="text-dark">Mesin</a>
                            </li>
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
                        <form action="{{ route('mesin.update', $mesin->slug) }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            @method('put')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Mesin</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                                id="nama" name="nama" value="{{ old('nama') ?? $mesin->nama }}">
                                            @error('nama')
                                                <span id="nama-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="lokasi_id">Lokasi</label>
                                            <select
                                                class="form-control select2 w-100 select-lokasi @error('lokasi_id') is-invalid @enderror"
                                                id="lokasi_id" name="lokasi_id">
                                                <option value="{{ $mesin->lokasi_id }}">{{ $mesin->lokasi->nama }}</option>
                                            </select>
                                            @error('lokasi_id')
                                                <span id="lokasi_id-error"
                                                    class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="target_produksi">Target Produksi</label>
                                            <input type="text"
                                                class="form-control @error('target_produksi') is-invalid @enderror"
                                                id="target_produksi" name="target_produksi"
                                                value="{{ old('target_produksi') ?? Number::format($mesin->target_produksi) }}"
                                                onblur="ubah_format('target_produksi', this.value)">>
                                            @error('target_produksi')
                                                <span id="target_produksi-error"
                                                    class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan</label>
                                            <input type="text"
                                                class="form-control @error('keterangan') is-invalid @enderror"
                                                id="keterangan" name="keterangan"
                                                value="{{ old('keterangan') ?? $mesin->keterangan }}">
                                            @error('keterangan')
                                                <span id="keterangan-error"
                                                    class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="button" class="btn btn-default" href="{{ route('mesin.index') }}"><i
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
            format_select2();
        });

        function format_select2() {
            $('.select-lokasi').select2({
                placeholder: "- Pilih Lokasi -",
                allowClear: true,
                ajax: {
                    url: '{{ route('mesin.get_lokasi') }}',
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
            var mynumeral = numeral(nilai).format('0,0');
            if (field.includes('jumlah')) {
                mynumeral = numeral(nilai).format('0,0');
            }
            $("#" + field).val(mynumeral);
        }
    </script>
@endsection
