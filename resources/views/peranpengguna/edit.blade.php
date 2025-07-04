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
                                                            <label class="form-check-label">Packing</label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.packing.cekstok"
                                                                    name="gudang.packing.cekstok"
                                                                    {{ $role->hasPermissionTo('gudang.packing.cekstok') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.packing.cekstok">Cek
                                                                    Stok</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.packing.barangkeluar"
                                                                    name="gudang.packing.barangkeluar"
                                                                    {{ $role->hasPermissionTo('gudang.packing.barangkeluar') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.packing.barangkeluar">Barang
                                                                    Keluar</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.packing.barangmasuk"
                                                                    name="gudang.packing.barangmasuk"
                                                                    {{ $role->hasPermissionTo('gudang.packing.barangmasuk') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.packing.barangmasuk">Barang
                                                                    Masuk</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.packing.retur" name="gudang.packing.retur"
                                                                    {{ $role->hasPermissionTo('gudang.packing.retur') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="gudang.packing.retur">Retur</label>
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
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <label class="form-check-label text-bold">Produksi</label>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label class="form-check-label">Produksi Depan</label>
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
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.extruder.kontrolreifen"
                                                                    name="produksi.extruder.kontrolreifen"
                                                                    {{ $role->hasPermissionTo('produksi.extruder.kontrol-reifen') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.extruder.kontrolreifen">Laporan Kontrol
                                                                    Reifen</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.extruder.laporansulzer"
                                                                    name="produksi.extruder.laporansulzer"
                                                                    {{ $role->hasPermissionTo('produksi.extruder.laporansulzer') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.extruder.laporansulzer">Laporan
                                                                    Sulzer</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.extruder.laporanrashel"
                                                                    name="produksi.extruder.laporanrashel"
                                                                    {{ $role->hasPermissionTo('produksi.extruder.laporanrashel') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.extruder.laporanrashel">Laporan
                                                                    Rashel</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.extruder.laporanbeaming"
                                                                    name="produksi.extruder.laporanbeaming"
                                                                    {{ $role->hasPermissionTo('produksi.extruder.laporanbeaming') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.extruder.laporanbeaming">Laporan
                                                                    Beaming</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.extruder.checklistbeaming"
                                                                    name="produksi.extruder.checklistbeaming"
                                                                    {{ $role->hasPermissionTo('produksi.extruder.checklistbeaming') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.extruder.checklistbeaming">Check List
                                                                    Beaming</label>
                                                            </div>
                                                            {{-- <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.extruder.beamatasmesin"
                                                                    name="produksi.extruder.beamatasmesin"
                                                                    {{ $role->hasPermissionTo('produksi.extruder.beamatasmesin') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.extruder.beamatasmesin">Beam Atas
                                                                    Mesin</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.extruder.beambawahmesin"
                                                                    name="produksi.extruder.beambawahmesin"
                                                                    {{ $role->hasPermissionTo('produksi.extruder.beambawahmesin') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.extruder.beambawahmesin">Beam Bawah
                                                                    Mesin</label>
                                                            </div> --}}
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.extruder.stockbeaming"
                                                                    name="produksi.extruder.stockbeaming"
                                                                    {{ $role->hasPermissionTo('produksi.extruder.stockbeaming') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.extruder.stockbeaming">Stock
                                                                    Beaming</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-check-label">Produksi Belakang</label>
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
                                                            <br>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.laminating.pengeringankain"
                                                                    name="produksi.laminating.pengeringankain"
                                                                    {{ $role->hasPermissionTo('produksi.laminating.pengeringankain') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.laminating.pengeringankain">Laporan
                                                                    Pengeringan Kain</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.laminating.rekap"
                                                                    name="produksi.laminating.rekap"
                                                                    {{ $role->hasPermissionTo('produksi.laminating.rekap') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.laminating.rekap">Rekap
                                                                    Pengeringan Kain</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.laminating.rekap"
                                                                    name="produksi.laminating.rekap"
                                                                    {{ $role->hasPermissionTo('produksi.laminating.rekap') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.laminating.rekap">Rekap
                                                                    Pengeringan Kain</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.laminating.edit.kering"
                                                                    name="produksi.laminating.edit.kering"
                                                                    {{ $role->hasPermissionTo('produksi.laminating.edit.kering') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.laminating.edit.kering">Edit
                                                                    Pengeringan Kain</label>
                                                            </div>
                                                            <br>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.welding.laporan"
                                                                    name="produksi.welding.laporan"
                                                                    {{ $role->hasPermissionTo('produksi.welding.laporan') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.welding.laporan">Laporan
                                                                    Welding</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.welding.rekap"
                                                                    name="produksi.welding.rekap"
                                                                    {{ $role->hasPermissionTo('produksi.welding.rekap') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.welding.rekap">Rekap Welding</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.welding.laporan.edit"
                                                                    name="produksi.welding.laporan.edit"
                                                                    {{ $role->hasPermissionTo('produksi.welding.laporan.edit') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.welding.laporan.edit">Edit
                                                                    Welding</label>
                                                            </div>
                                                            <br>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.wjl" name="produksi.wjl"
                                                                    {{ $role->hasPermissionTo('produksi.wjl') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.wjl">Produksi
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
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.wjl.panen" name="produksi.wjl.panen"
                                                                    {{ $role->hasPermissionTo('produksi.wjl.panen') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.wjl.panen">Panen WJL</label>
                                                            </div>
                                                            <br>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.laminating" name="produksi.laminating"
                                                                    {{ $role->hasPermissionTo('produksi.laminating') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.laminating">Produksi
                                                                    Laminating</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.laminating.edit"
                                                                    name="produksi.laminating.edit"
                                                                    {{ $role->hasPermissionTo('produksi.laminating.edit') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.laminating.edit">Edit Produksi
                                                                    Laminating</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.laminating.panen"
                                                                    name="produksi.laminating.panen"
                                                                    {{ $role->hasPermissionTo('produksi.laminating.panen') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.laminating.panen">Panen
                                                                    Laminating</label>
                                                            </div>
                                                            <br>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.welding" name="produksi.welding"
                                                                    {{ $role->hasPermissionTo('produksi.welding') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.welding">Produksi
                                                                    Welding</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.welding.edit"
                                                                    name="produksi.welding.edit"
                                                                    {{ $role->hasPermissionTo('produksi.welding.edit') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.welding.edit">Edit Produksi
                                                                    Welding</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.welding.panen"
                                                                    name="produksi.welding.panen"
                                                                    {{ $role->hasPermissionTo('produksi.welding.panen') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.welding.panen">Panen Welding</label>
                                                            </div>
                                                            <br>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.tarik" name="produksi.tarik"
                                                                    {{ $role->hasPermissionTo('produksi.tarik') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.tarik">Produksi
                                                                    Tarik</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.tarik.edit" name="produksi.tarik.edit"
                                                                    {{ $role->hasPermissionTo('produksi.tarik.edit') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.tarik.edit">Edit Produksi
                                                                    Tarik</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.tarik.panen" name="produksi.tarik.panen"
                                                                    {{ $role->hasPermissionTo('produksi.tarik.panen') ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="produksi.tarik.panen">Panen Tarik</label>
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
                                                        <input class="form-check-input" type="checkbox"
                                                            id="laporan.gudang" name="laporan.gudang"
                                                            {{ $role->hasPermissionTo('laporan.gudang') ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="laporan.gudang">Gudang</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="laporan.wjl.efisiensi" name="laporan.wjl.efisiensi"
                                                            {{ $role->hasPermissionTo('laporan.wjl.efisiensi') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="laporan.wjl.efisiensi">WJL -
                                                            Efisiensi</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <label class="form-check-label text-bold">Data Master</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="material"
                                                            name="material"
                                                            {{ $role->hasPermissionTo('material') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="material">Material</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="mesin"
                                                            name="mesin"
                                                            {{ $role->hasPermissionTo('mesin') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="mesin">Mesing</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="lokasi"
                                                            name="lokasi"
                                                            {{ $role->hasPermissionTo('lokasi') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="lokasi">Lokasi</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <label class="form-check-label text-bold">Pengaturan</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="peranpengguna" name="peranpengguna"
                                                            {{ $role->hasPermissionTo('peranpengguna') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="peranpengguna">Peran
                                                            Pengguna</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="pengguna"
                                                            name="pengguna"
                                                            {{ $role->hasPermissionTo('pengguna') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="pengguna">Pengguna</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="approval"
                                                            name="approval"
                                                            {{ $role->hasPermissionTo('approval') ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="approval">Approval</label>
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
