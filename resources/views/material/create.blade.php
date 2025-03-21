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
                            <li class="breadcrumb-item"><a href="{{ route('material.index') }}"
                                    class="text-dark">Material</a>
                            </li>
                            <li class="breadcrumb-item" Active>Tambah Data</li>
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
                        <form action="{{ route('material.store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            @method('post')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Material</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="kode">Kode</label>
                                            <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                                id="kode" name="kode" value="{{ old('kode') }}">
                                            @error('kode')
                                                <span id="kode-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                                id="nama" name="nama" value="{{ old('nama') }}">
                                            @error('nama')
                                                <span id="nama-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="group">Group</label>
                                            <select
                                                class="form-control select2 w-100 select-group @error('group') is-invalid @enderror"
                                                id="group" name="group">
                                                <option value=""></option>
                                            </select>
                                            @error('group')
                                                <span id="group-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis">Jenis</label>
                                            <select
                                                class="form-control select2 w-100 select-jenis @error('jenis') is-invalid @enderror"
                                                id="jenis" name="jenis">
                                                <option value="Bahan Baku">Bahan Baku</option>
                                                <option value="Bahan Penolong">Bahan Penolong</option>
                                                <option value="Work In Progress">Work In Progress</option>
                                                <option value="Barang Jadi">Barang Jadi</option>
                                                <option value="Avalan">Avalan</option>
                                            </select>
                                            @error('jenis')
                                                <span id="jenis-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="ukuran">Ukuran</label>
                                            <input type="text" class="form-control @error('ukuran') is-invalid @enderror"
                                                id="ukuran" name="ukuran" value="{{ old('ukuran') }}">
                                            @error('ukuran')
                                                <span id="ukuran-error"
                                                    class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="bentuk">Bentuk</label>
                                            <select
                                                class="form-control select2 w-100 select-bentuk @error('bentuk') is-invalid @enderror"
                                                id="bentuk" name="bentuk">
                                                <option value="Roll">Roll</option>
                                                <option value="Terpal">Terpal</option>
                                            </select>
                                            @error('jenis')
                                                <span id="jenis-error"
                                                    class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="keterangan">Keterangan</label>
                                            <input type="text"
                                                class="form-control @error('keterangan') is-invalid @enderror"
                                                id="keterangan" name="keterangan" value="{{ old('keterangan') }}">
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
                                    <a type="button" class="btn btn-default" href="{{ route('material.index') }}"><i
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
        var data = [{
                id: 'EXTRUDER',
                text: 'EXTRUDER'
            }, {
                id: 'RASHEL',
                text: 'RASHEL'
            },
            {
                id: 'SULZER',
                text: 'SULZER'
            },
            {
                id: 'BEAMING',
                text: 'BEAMING'
            },
            {
                id: 'WJL',
                text: 'WJL'
            },
            {
                id: 'WELDING',
                text: 'WELDING'
            },
            {
                id: 'PACKING',
                text: 'PACKING'
            },
            {
                id: 'GUDANG BELAKANG',
                text: 'GUDANG BELAKANG'
            },
        ];

        $(document).ready(function() {
            $(".select-jenis").select2();
            $(".select-bentuk").select2();

            $(".select-group").select2({
                placeholder: "-- Pilih Group --",
                allowClear: true,
                data: data,
                width: '100%'
            });
        });
    </script>
@endsection
