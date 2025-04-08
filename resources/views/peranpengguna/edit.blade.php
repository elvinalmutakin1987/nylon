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
                            <li class="breadcrumb-item"><a href="{{ route('pengaturan.index') }}"
                                    class="text-dark">Pengaturan</a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{ route('peranpengguna.index') }}" class="text-dark">Peran
                                    Pengguna</a>
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
                        <form action="{{ route('peranpengguna.update', $role->id) }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            @method('put')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Peran Pengguna</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                                id="nama" name="nama" value="{{ old('nama') ?? $role->name }}">
                                            @error('nama')
                                                <span id="nama-error" class="error invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-5">
                                            <label>Hak Akses</label>
                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <label class="form-check-label text-bold">Order</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="order"
                                                            name="order"
                                                            {{ $role->hasPermissionTo('order') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="order">Order</label>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <label class="form-check-label text-bold">Gudang</label>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-check-label">Barang Jadi</label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.barangjadi.order"
                                                                    name="gudang.barangjadi.order"
                                                                    {{ $role->hasPermissionTo('gudang.barangjadi.order') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.barangjadi.order">Order</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.barangjadi.cekstok"
                                                                    name="gudang.barangjadi.cekstok"
                                                                    {{ $role->hasPermissionTo('gudang.barangjadi.cekstok') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.barangjadi.cekstok">Cek
                                                                    Stok</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.barangjadi.suratjalan"
                                                                    name="gudang.barangjadi.suratjalan"
                                                                    {{ $role->hasPermissionTo('gudang.barangjadi.suratjalan') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.barangjadi.suratjalan">Surat
                                                                    Jalan</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.barangjadi.barangkeluar"
                                                                    name="gudang.barangjadi.barangkeluar"
                                                                    {{ $role->hasPermissionTo('gudang.barangjadi.barangkeluar') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.barangjadi.barangkeluar">Barang
                                                                    Keluar</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.barangjadi.barangmasuk"
                                                                    name="gudang.barangjadi.barangmasuk"
                                                                    {{ $role->hasPermissionTo('gudang.barangjadi.barangmasuk') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.barangjadi.barangmasuk">Barang
                                                                    Masuk</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.barangjadi.retur"
                                                                    name="gudang.barangjadi.retur"
                                                                    {{ $role->hasPermissionTo('gudang.barangjadi.retur') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.barangjadi.retur">Retur</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-check-label">Bahan Baku</label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.bahanbaku.cekstok"
                                                                    name="gudang.bahanbaku.cekstok"
                                                                    {{ $role->hasPermissionTo('gudang.bahanbaku.cekstok') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.bahanbaku.cekstok">Cek
                                                                    Stok</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.bahanbaku.barangkeluar"
                                                                    name="gudang.bahanbaku.barangkeluar"
                                                                    {{ $role->hasPermissionTo('gudang.bahanbaku.barangkeluar') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.bahanbaku.barangkeluar">Barang
                                                                    Keluar</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.bahanbaku.barangmasuk"
                                                                    name="gudang.bahanbaku.barangmasuk"
                                                                    {{ $role->hasPermissionTo('gudang.bahanbaku.barangmasuk') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.bahanbaku.barangmasuk">Barang
                                                                    Masuk</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.bahanbaku.retur"
                                                                    name="gudang.bahanbaku.retur"
                                                                    {{ $role->hasPermissionTo('gudang.bahanbaku.retur') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.bahanbaku.retur">Retur</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-check-label">Avalan</label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.avalan.cekstok"
                                                                    name="gudang.avalan.cekstok"
                                                                    {{ $role->hasPermissionTo('gudang.avalan.cekstok') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.avalan.cekstok">Cek
                                                                    Stok</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.avalan.barangkeluar"
                                                                    name="gudang.avalan.barangkeluar"
                                                                    {{ $role->hasPermissionTo('gudang.avalan.barangkeluar') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.avalan.barangkeluar">Barang
                                                                    Keluar</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.avalan.barangmasuk"
                                                                    name="gudang.avalan.barangmasuk"
                                                                    {{ $role->hasPermissionTo('gudang.avalan.barangmasuk') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.avalan.barangmasuk">Barang
                                                                    Masuk</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.avalan.retur" name="gudang.avalan.retur"
                                                                    {{ $role->hasPermissionTo('gudang.avalan.retur') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.avalan.retur">Retur</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-check-label">Stock Opname</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <label class="form-check-label text-bold">Produksi</label>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-check-label">Extruder</label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.extruder.kontroldenier"
                                                                    name="produksi.extruder.kontroldenier"
                                                                    {{ $role->hasPermissionTo('produksi.extruder.kontrol-denier') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.extruder.kontroldenier">Laporan Kontrol
                                                                    Denier</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.extruder.kontrolbarmag"
                                                                    name="produksi.extruder.kontrolbarmag"
                                                                    {{ $role->hasPermissionTo('produksi.extruder.kontrol-barmag') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.extruder.kontrolbarmag">Laporan Kontrol
                                                                    Barmag</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-check-label">WJL</label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.wjl.operator"
                                                                    name="produksi.wjl.operator"
                                                                    {{ $role->hasPermissionTo('produksi.wjl.operator') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.wjl.operator">Laporan Produksi
                                                                    WJL</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.wjl.rekap" name="produksi.wjl.rekap"
                                                                    {{ $role->hasPermissionTo('produksi.wjl.rekap') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.wjl.rekap">Rekap Produksi
                                                                    WJL</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.wjl.edit" name="produksi.wjl.edit"
                                                                    {{ $role->hasPermissionTo('produksi.wjl.edit') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.wjl.edit">Edit Produksi
                                                                    WJL</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-check-label">Gudang Benang</label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.benang.cekstok"
                                                                    name="gudang.benang.cekstok"
                                                                    {{ $role->hasPermissionTo('gudang.benang.cekstok') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.benang.cekstok">Cek
                                                                    Stok</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.benang.barangkeluar"
                                                                    name="gudang.benang.barangkeluar"
                                                                    {{ $role->hasPermissionTo('gudang.benang.barangkeluar') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.benang.barangkeluar">Barang
                                                                    Keluar</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.benang.barangmasuk"
                                                                    name="gudang.benang.barangmasuk"
                                                                    {{ $role->hasPermissionTo('gudang.benang.barangmasuk') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.benang.barangmasuk">Barang
                                                                    Masuk</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.benang.retur" name="gudang.benang.retur"
                                                                    {{ $role->hasPermissionTo('gudang.benang.retur') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.benang.retur">Retur</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <label class="form-check-label text-bold">Laporan</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="rt"
                                                            name="rt">
                                                        <label class="form-check-label" for="rt">Daftar RT</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="pengguna_"
                                                            name="pengguna_">
                                                        <label class="form-check-label" for="pengguna_">Pengguna</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="profil"
                                                            name="profil">
                                                        <label class="form-check-label" for="profil">Profil</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="templatesurat" name="templatesurat">
                                                        <label class="form-check-label" for="templatesurat">Template
                                                            Surat</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="pengaturansistem" name="pengaturansistem">
                                                        <label class="form-check-label" for="pengaturansistem">Pengaturan
                                                            Sistem</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <label class="form-check-label text-bold">Data Master</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="agenda"
                                                            name="agenda">
                                                        <label class="form-check-label" for="agenda">Agenda &
                                                            Pengumuman</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="surat"
                                                            name="surat">
                                                        <label class="form-check-label" for="surat">Surat</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="kejadian"
                                                            name="kejadian">
                                                        <label class="form-check-label" for="kejadian">Kejadian</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <label class="form-check-label text-bold">Pengaturan</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="agenda"
                                                            name="agenda" onclick="semua_menu_jadi_cek()">
                                                        <label class="form-check-label" for="agenda">Agenda &
                                                            Pengumuman</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="surat"
                                                            name="surat" onclick="semua_menu_jadi_cek()">
                                                        <label class="form-check-label" for="surat">Surat</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="kejadian"
                                                            name="kejadian" onclick="semua_menu_jadi_cek()">
                                                        <label class="form-check-label" for="kejadian">Kejadian</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="button" class="btn btn-default"
                                        href="{{ route('peranpengguna.index') }}"><i class="fa fa-reply"></i>
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
    <script type="text/javascript"></script>
@endsection
