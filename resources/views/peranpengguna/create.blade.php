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
                        <form action="{{ route('peranpengguna.store') }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            @method('post')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Peran Pengguna</h3>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                                id="nama" name="nama" value="{{ old('nama') }}">
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
                                                            name="order">
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
                                                                    name="gudang.barangjadi.order">
                                                                <label class="form-check-label"
                                                                    for="gudang.barangjadi.order">Order</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.barangjadi.cekstok"
                                                                    name="gudang.barangjadi.cekstok">
                                                                <label class="form-check-label"
                                                                    for="gudang.barangjadi.cekstok">Cek
                                                                    Stok</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.barangjadi.suratjalan"
                                                                    name="gudang.barangjadi.suratjalan">
                                                                <label class="form-check-label"
                                                                    for="gudang.barangjadi.suratjalan">Surat
                                                                    Jalan</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.barangjadi.barangkeluar"
                                                                    name="gudang.barangjadi.barangkeluar">
                                                                <label class="form-check-label"
                                                                    for="gudang.barangjadi.barangkeluar">Barang
                                                                    Keluar</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.barangjadi.barangmasuk"
                                                                    name="gudang.barangjadi.barangmasuk">
                                                                <label class="form-check-label"
                                                                    for="gudang.barangjadi.barangmasuk">Barang
                                                                    Masuk</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.barangjadi.retur"
                                                                    name="gudang.barangjadi.retur">
                                                                <label class="form-check-label"
                                                                    for="gudang.barangjadi.retur">Retur</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-check-label">Bahan Baku</label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.bahanbaku.cekstok"
                                                                    name="gudang.bahanbaku.cekstok">
                                                                <label class="form-check-label"
                                                                    for="gudang.bahanbaku.cekstok">Cek
                                                                    Stok</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.bahanbaku.barangkeluar"
                                                                    name="gudang.bahanbaku.barangkeluar">
                                                                <label class="form-check-label"
                                                                    for="gudang.bahanbaku.barangkeluar">Barang
                                                                    Keluar</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.bahanbaku.barangmasuk"
                                                                    name="gudang.bahanbaku.barangmasuk">
                                                                <label class="form-check-label"
                                                                    for="gudang.bahanbaku.barangmasuk">Barang
                                                                    Masuk</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.bahanbaku.retur"
                                                                    name="gudang.bahanbaku.retur">
                                                                <label class="form-check-label"
                                                                    for="gudang.bahanbaku.retur">Retur</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-check-label">Packing</label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.packing.cekstok"
                                                                    name="gudang.packing.cekstok">
                                                                <label class="form-check-label"
                                                                    for="gudang.packing.cekstok">Cek
                                                                    Stok</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.packing.barangkeluar"
                                                                    name="gudang.packing.barangkeluar">
                                                                <label class="form-check-label"
                                                                    for="gudang.packing.barangkeluar">Barang
                                                                    Keluar</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.packing.barangmasuk"
                                                                    name="gudang.packing.barangmasuk">
                                                                <label class="form-check-label"
                                                                    for="gudang.packing.barangmasuk">Barang
                                                                    Masuk</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.packing.retur" name="gudang.packing.retur">
                                                                <label class="form-check-label"
                                                                    for="gudang.packing.retur">Retur</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-check-label">Avalan</label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.avalan.cekstok"
                                                                    name="gudang.avalan.cekstok">
                                                                <label class="form-check-label"
                                                                    for="gudang.avalan.cekstok">Cek
                                                                    Stok</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.avalan.barangkeluar"
                                                                    name="gudang.avalan.barangkeluar">
                                                                <label class="form-check-label"
                                                                    for="gudang.avalan.barangkeluar">Barang
                                                                    Keluar</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.avalan.barangmasuk"
                                                                    name="gudang.avalan.barangmasuk">
                                                                <label class="form-check-label"
                                                                    for="gudang.avalan.barangmasuk">Barang
                                                                    Masuk</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.avalan.retur" name="gudang.avalan.retur">
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
                                                                    name="produksi.extruder.kontroldenier">
                                                                <label class="form-check-label"
                                                                    for="produksi.extruder.kontroldenier">Laporan Kontrol
                                                                    Denier</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.extruder.kontrolbarmag"
                                                                    name="produksi.extruder.kontrolbarmag">
                                                                <label class="form-check-label"
                                                                    for="produksi.extruder.kontrolbarmag">Laporan Kontrol
                                                                    Barmag</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.extruder.kontrolreifen"
                                                                    name="produksi.extruder.kontrolreifen">
                                                                <label class="form-check-label"
                                                                    for="produksi.extruder.kontrolreifen">Laporan Kontrol
                                                                    Reifen</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.extruder.laporansulzer"
                                                                    name="produksi.extruder.laporansulzer">
                                                                <label class="form-check-label"
                                                                    for="produksi.extruder.laporansulzer">Laporan
                                                                    Sulzer</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.extruder.laporanrashel"
                                                                    name="produksi.extruder.laporanrashel">
                                                                <label class="form-check-label"
                                                                    for="produksi.extruder.laporanrashel">Laporan
                                                                    Rashel</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.extruder.laporanbeaming"
                                                                    name="produksi.extruder.laporanbeaming">
                                                                <label class="form-check-label"
                                                                    for="produksi.extruder.laporanbeaming">Laporan
                                                                    Beaming</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.extruder.checklistbeaming"
                                                                    name="produksi.extruder.checklistbeaming">
                                                                <label class="form-check-label"
                                                                    for="produksi.extruder.checklistbeaming">Check List
                                                                    Beaming</label>
                                                            </div>
                                                            {{-- <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.extruder.beamatasmesin"
                                                                    name="produksi.extruder.beamatasmesin">
                                                                <label class="form-check-label"
                                                                    for="produksi.extruder.beamatasmesin">Beam Atas
                                                                    Mesin</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.extruder.beambawahmesin"
                                                                    name="produksi.extruder.beambawahmesin">
                                                                <label class="form-check-label"
                                                                    for="produksi.extruder.beambawahmesin">Beam Bawah
                                                                    Mesin</label>
                                                            </div> --}}
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.extruder.stockbeaming"
                                                                    name="produksi.extruder.stockbeaming">
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
                                                                    name="produksi.wjl.operator">
                                                                <label class="form-check-label"
                                                                    for="produksi.wjl.operator">Laporan Produksi
                                                                    WJL</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.wjl.rekap" name="produksi.wjl.rekap">
                                                                <label class="form-check-label"
                                                                    for="produksi.wjl.rekap">Rekap Produksi
                                                                    WJL</label>
                                                            </div>
                                                            <br>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.laminating.pengeringankain"
                                                                    name="produksi.laminating.pengeringankain">
                                                                <label class="form-check-label"
                                                                    for="produksi.laminating.pengeringankain">Laporan
                                                                    Pengeringan
                                                                    Kain</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.laminating.rekap"
                                                                    name="produksi.laminating.rekap">
                                                                <label class="form-check-label"
                                                                    for="produksi.laminating.rekap">Rekap Pengeringan
                                                                    Kain</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.laminating.edit.kering"
                                                                    name="produksi.laminating.edit.kering">
                                                                <label class="form-check-label"
                                                                    for="produksi.laminating.edit.kering">Edit Pengeringan
                                                                    Kain</label>
                                                            </div>
                                                            <br>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.welding.laporan"
                                                                    name="produksi.welding.laporan">
                                                                <label class="form-check-label"
                                                                    for="produksi.welding.laporan">Laporan
                                                                    Welding</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.welding.rekap"
                                                                    name="produksi.welding.rekap">
                                                                <label class="form-check-label"
                                                                    for="produksi.welding.rekap">Rekap Welding</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.welding.laporan.edit"
                                                                    name="produksi.welding.laporan.edit">
                                                                <label class="form-check-label"
                                                                    for="produksi.welding.laporan.edit">Edit
                                                                    Welding</label>
                                                            </div>
                                                            <br>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.wjl" name="produksi.wjl">
                                                                <label class="form-check-label" for="produksi.wjl">
                                                                    Produksi
                                                                    WJL</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.wjl.edit" name="produksi.wjl.edit">
                                                                <label class="form-check-label"
                                                                    for="produksi.wjl.edit">Edit Produksi
                                                                    WJL</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.wjl.panen" name="produksi.wjl.panen">
                                                                <label class="form-check-label"
                                                                    for="produksi.wjl.panen">Panen WJL</label>
                                                            </div>
                                                            <br>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.laminating" name="produksi.laminating">
                                                                <label class="form-check-label" for="produksi.laminating">
                                                                    Produksi
                                                                    Laminating</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.laminating.edit"
                                                                    name="produksi.laminating.edit">
                                                                <label class="form-check-label"
                                                                    for="produksi.laminating.edit">Edit Produksi
                                                                    Laminating</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.laminating.panen"
                                                                    name="produksi.laminating.panen">
                                                                <label class="form-check-label"
                                                                    for="produksi.laminating.panen">Panen
                                                                    Laminating</label>
                                                            </div>
                                                            <br>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.welding" name="produksi.welding">
                                                                <label class="form-check-label" for="produksi.welding">
                                                                    Produksi
                                                                    Welding</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.welding.edit"
                                                                    name="produksi.welding.edit">
                                                                <label class="form-check-label"
                                                                    for="produksi.welding.edit">Edit Produksi
                                                                    Welding</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="produksi.welding.panen"
                                                                    name="produksi.welding.panen">
                                                                <label class="form-check-label"
                                                                    for="produksi.welding.panen">Panen Welding</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-check-label">Gudang Benang</label>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.benang.cekstok"
                                                                    name="gudang.benang.cekstok">
                                                                <label class="form-check-label"
                                                                    for="gudang.benang.cekstok">Cek
                                                                    Stok</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.benang.barangkeluar"
                                                                    name="gudang.benang.barangkeluar">
                                                                <label class="form-check-label"
                                                                    for="gudang.benang.barangkeluar">Barang
                                                                    Keluar</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.benang.barangmasuk"
                                                                    name="gudang.benang.barangmasuk">
                                                                <label class="form-check-label"
                                                                    for="gudang.benang.barangmasuk">Barang
                                                                    Masuk</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="gudang.benang.retur" name="gudang.benang.retur">
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
                                                            id="laporan.gudang" name="laporan.gudang">
                                                        <label class="form-check-label"
                                                            for="laporan.gudang">Gudang</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="laporan.wjl.efisiensi" name="laporan.wjl.efisiensi">
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
                                                            name="material">
                                                        <label class="form-check-label" for="material">Material</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="mesin"
                                                            name="mesin">
                                                        <label class="form-check-label" for="mesin">Mesin</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="lokasi"
                                                            name="lokasi">
                                                        <label class="form-check-label" for="lokasi">Lokasi</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <label class="form-check-label text-bold">Pengaturan</label>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="peranpengguna" name="peranpengguna">
                                                        <label class="form-check-label" for="peranpengguna">Peran
                                                            Pengguna</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="pengguna"
                                                            name="pengguna">
                                                        <label class="form-check-label" for="pengguna">Pengguna</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="approval"
                                                            name="approval">
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
