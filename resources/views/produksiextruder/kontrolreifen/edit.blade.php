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
                            <li class="breadcrumb-item">Laporan Kontrol Reifen</li>
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
                            <form action="{{ route('produksiextruder-kontrol-reifen.update', $kontrolreifen->slug) }}"
                                enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('put')
                                <div class="card-header">
                                    <h3 class="card-title">Laporan Kontrol Denier</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal</label>
                                                <input type="text"
                                                    class="form-control @error('tanggal') is-invalid @enderror"
                                                    id="tanggal" name="tanggal"
                                                    value="{{ old('tanggal') ?? $kontrolreifen->tanggal }}" readonly>
                                                @error('tanggal')
                                                    <span id="tanggal-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="shift">Shift</label>
                                                <input type="text"
                                                    class="form-control @error('shift') is-invalid @enderror" id="shift"
                                                    name="shift" value="{{ old('shift') ?? $kontrolreifen->shift }}"
                                                    readonly>
                                                @error('shift')
                                                    <span id="shift-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="pengawas">Pengawas</label>
                                                <input type="text"
                                                    class="form-control @error('pengawas') is-invalid @enderror"
                                                    id="pengawas" name="pengawas"
                                                    value="{{ old('pengawas') ?? $kontrolreifen->pengawas }}">
                                                @error('pengawas')
                                                    <span id="pengawas-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="jenis">Jenis & Type Bahan Baku</label>
                                                <input type="text"
                                                    class="form-control @error('jenis') is-invalid @enderror" id="jenis"
                                                    name="jenis" value="{{ old('jenis') ?? $kontrolreifen->jenis }}">
                                                @error('jenis')
                                                    <span id="jenis-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="melt_flow">Melt Flow Index Bahan Baku</label>
                                                <input type="text"
                                                    class="form-control @error('melt_flow') is-invalid @enderror"
                                                    id="melt_flow" name="melt_flow"
                                                    value="{{ old('melt_flow') ?? $kontrolreifen->melt_flow }}">
                                                @error('melt_flow')
                                                    <span id="melt_flow-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="jenis_produksi">Jenis Produksi</label>
                                                <input type="text"
                                                    class="form-control @error('jenis_produksi') is-invalid @enderror"
                                                    id="jenis_produksi" name="jenis_produksi"
                                                    value="{{ old('jenis_produksi') ?? $kontrolreifen->jenis_produksi }}">
                                                @error('jenis_produksi')
                                                    <span id="jenis_produksi-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="bahan_campuran">Bahan Campuran</label>
                                                <input type="text"
                                                    class="form-control @error('bahan_campuran') is-invalid @enderror"
                                                    id="bahan_campuran" name="bahan_campuran"
                                                    value="{{ old('bahan_campuran') ?? $kontrolreifen->bahan_campuran }}">
                                                @error('bahan_campuran')
                                                    <span id="bahan_campuran-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="pengesetan_mesin">Pengesetan Mesin</label>
                                                <input type="text"
                                                    class="form-control @error('pengesetan_mesin') is-invalid @enderror"
                                                    id="pengesetan_mesin" name="pengesetan_mesin"
                                                    value="{{ old('pengesetan_mesin') ?? $kontrolreifen->pengetesan_mesin }}">
                                                @error('pengesetan_mesin')
                                                    <span id="pengesetan_mesin-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lebar_spacer">Lebar Spacer</label>
                                                <input type="text"
                                                    class="form-control @error('lebar_spacer') is-invalid @enderror"
                                                    id="lebar_spacer" name="lebar_spacer"
                                                    value="{{ old('lebar_spacer') ?? $kontrolreifen->lebar_spacer }}">
                                                @error('lebar_spacer')
                                                    <span id="lebar_spacer-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lebar_benang_jadi">Lebar Benang Jadi</label>
                                                <input type="text"
                                                    class="form-control @error('lebar_benang_jadi') is-invalid @enderror"
                                                    id="lebar_benang_jadi" name="lebar_benang_jadi"
                                                    value="{{ old('lebar_benang_jadi') ?? $kontrolreifen->lebar_benang_jadi }}">
                                                @error('lebar_benang_jadi')
                                                    <span id="lebar_benang_jadi-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="jumlah_benang_jadi">Jumlah Benang Jadi</label>
                                                <input type="text"
                                                    class="form-control @error('jumlah_benang_jadi') is-invalid @enderror"
                                                    id="jumlah_benang_jadi" name="jumlah_benang_jadi"
                                                    value="{{ old('jumlah_benang_jadi') ?? $kontrolreifen->jumlah_benang_jadi }}">
                                                @error('jumlah_benang_jadi')
                                                    <span id="jumlah_benang_jadi-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="denier">Denier</label>
                                                <input type="text"
                                                    class="form-control @error('denier') is-invalid @enderror"
                                                    id="denier" name="denier"
                                                    value="{{ old('denier') ?? $kontrolreifen->denier }}">
                                                @error('denier')
                                                    <span id="denier-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="srt">S.R.T</label>
                                                <input type="text"
                                                    class="form-control @error('srt') is-invalid @enderror"
                                                    id="srt" name="srt"
                                                    value="{{ old('srt') ?? $kontrolreifen->srt }}">
                                                @error('srt')
                                                    <span id="srt-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tebal_film">Tebal Film</label>
                                                <input type="text"
                                                    class="form-control @error('tebal_film') is-invalid @enderror"
                                                    id="tebal_film" name="tebal_film"
                                                    value="{{ old('tebal_film') ?? $kontrolreifen->tebal_film }}">
                                                @error('tebal_film')
                                                    <span id="tebal_film-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="screw_rpm">Screw RPM</label>
                                                <input type="text"
                                                    class="form-control @error('screw_rpm') is-invalid @enderror"
                                                    id="screw_rpm" name="screw_rpm"
                                                    value="{{ old('screw_rpm') ?? $kontrolreifen->screw_rpm }}">
                                                @error('screw_rpm')
                                                    <span id="screw_rpm-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="godet_1_rpm">Godet 1 RPM</label>
                                                <input type="text"
                                                    class="form-control @error('godet_1_rpm') is-invalid @enderror"
                                                    id="godet_1_rpm" name="godet_1_rpm"
                                                    value="{{ old('godet_1_rpm') ?? $kontrolreifen->godet_1_rpm }}">
                                                @error('godet_1_rpm')
                                                    <span id="godet_1_rpm-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="godet_2_rpm">Godet 2 RPM</label>
                                                <input type="text"
                                                    class="form-control @error('godet_2_rpm') is-invalid @enderror"
                                                    id="godet_2_rpm" name="godet_2_rpm"
                                                    value="{{ old('godet_2_rpm') ?? $kontrolreifen->godet_2_rpm }}">
                                                @error('godet_2_rpm')
                                                    <span id="godet_2_rpm-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="cylinder_1">Cylinder 1</label>
                                                <input type="text"
                                                    class="form-control @error('cylinder_1') is-invalid @enderror"
                                                    id="cylinder_1" name="cylinder_1"
                                                    value="{{ old('cylinder_1') ?? $kontrolreifen->cylinder_1 }}">
                                                @error('cylinder_1')
                                                    <span id="cylinder_1-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="cylinder_2">Cylinder 2</label>
                                                <input type="text"
                                                    class="form-control @error('cylinder_2') is-invalid @enderror"
                                                    id="cylinder_2" name="cylinder_2"
                                                    value="{{ old('cylinder_2') ?? $kontrolreifen->cylinder_2 }}">
                                                @error('cylinder_2')
                                                    <span id="cylinder_2-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="cylinder_3">Cylinder 3</label>
                                                <input type="text"
                                                    class="form-control @error('cylinder_3') is-invalid @enderror"
                                                    id="cylinder_3" name="cylinder_3"
                                                    value="{{ old('cylinder_3') ?? $kontrolreifen->cylinder_3 }}">
                                                @error('cylinder_3')
                                                    <span id="cylinder_3-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="cylinder_4">Cylinder 4</label>
                                                <input type="text"
                                                    class="form-control @error('cylinder_4') is-invalid @enderror"
                                                    id="cylinder_4" name="cylinder_4"
                                                    value="{{ old('cylinder_4') ?? $kontrolreifen->cylinder_4 }}">
                                                @error('cylinder_4')
                                                    <span id="cylinder_4-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="adaptor_1">Adaptor 1</label>
                                                <input type="text"
                                                    class="form-control @error('adaptor_1') is-invalid @enderror"
                                                    id="adaptor_1" name="adaptor_1"
                                                    value="{{ old('adaptor_1') ?? $kontrolreifen->adaptor_1 }}">
                                                @error('adaptor_1')
                                                    <span id="adaptor_1-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="adaptor_2">Adaptor 2</label>
                                                <input type="text"
                                                    class="form-control @error('adaptor_2') is-invalid @enderror"
                                                    id="adaptor_2" name="adaptor_2"
                                                    value="{{ old('adaptor_2') ?? $kontrolreifen->adaptor_2 }}">
                                                @error('adaptor_2')
                                                    <span id="adaptor_2-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="adaptor_3">Adaptor 3</label>
                                                <input type="text"
                                                    class="form-control @error('adaptor_3') is-invalid @enderror"
                                                    id="adaptor_3" name="adaptor_3"
                                                    value="{{ old('adaptor_3') ?? $kontrolreifen->adaptor_3 }}">
                                                @error('adaptor_3')
                                                    <span id="adaptor_3-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="dies_1">Dies 1</label>
                                                <input type="text"
                                                    class="form-control @error('dies_1') is-invalid @enderror"
                                                    id="dies_1" name="dies_1"
                                                    value="{{ old('dies_1') ?? $kontrolreifen->dies_1 }}">
                                                @error('dies_1')
                                                    <span id="dies_1-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="dies_2">Dies 2</label>
                                                <input type="text"
                                                    class="form-control @error('dies_2') is-invalid @enderror"
                                                    id="dies_2" name="dies_2"
                                                    value="{{ old('dies_2') ?? $kontrolreifen->dies_2 }}">
                                                @error('dies_2')
                                                    <span id="dies_2-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="dies_3">Dies 3</label>
                                                <input type="text"
                                                    class="form-control @error('dies_3') is-invalid @enderror"
                                                    id="dies_3" name="dies_3"
                                                    value="{{ old('dies_3') ?? $kontrolreifen->dies_3 }}">
                                                @error('dies_3')
                                                    <span id="dies_3-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="dies_4">Dies 4</label>
                                                <input type="text"
                                                    class="form-control @error('dies_4') is-invalid @enderror"
                                                    id="dies_4" name="dies_4"
                                                    value="{{ old('dies_4') ?? $kontrolreifen->dies_4s }}">
                                                @error('dies_4')
                                                    <span id="dies_4-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="dies_5">Dies 5</label>
                                                <input type="text"
                                                    class="form-control @error('dies_5') is-invalid @enderror"
                                                    id="dies_5" name="dies_5"
                                                    value="{{ old('dies_5') ?? $kontrolreifen->dies_5 }}">
                                                @error('dies_5')
                                                    <span id="dies_5-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="dies_6">Dies 6</label>
                                                <input type="text"
                                                    class="form-control @error('dies_6') is-invalid @enderror"
                                                    id="dies_6" name="dies_6"
                                                    value="{{ old('dies_6') ?? $kontrolreifen->dies_6 }}">
                                                @error('dies_6')
                                                    <span id="dies_6-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="dies_7">Dies 7</label>
                                                <input type="text"
                                                    class="form-control @error('dies_7') is-invalid @enderror"
                                                    id="dies_7" name="dies_7"
                                                    value="{{ old('dies_7') ?? $kontrolreifen->dies_7 }}">
                                                @error('dies_7')
                                                    <span id="dies_3-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="melt_presure">Melt. Presure</label>
                                                <input type="text"
                                                    class="form-control @error('melt_presure') is-invalid @enderror"
                                                    id="melt_presure" name="melt_presure"
                                                    value="{{ old('melt_presure') ?? $kontrolreifen->melt_presure }}">
                                                @error('melt_presure')
                                                    <span id="melt_presure-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="melt_temperatur">Melt. Temperatur</label>
                                                <input type="text"
                                                    class="form-control @error('melt_temperatur') is-invalid @enderror"
                                                    id="melt_temperatur" name="melt_temperatur"
                                                    value="{{ old('melt_temperatur') ?? $kontrolreifen->melt_temperatur }}">
                                                @error('melt_temperatur')
                                                    <span id="melt_temperatur-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="temp_olie_godet_2">Temp. Olie Godet 2</label>
                                                <input type="text"
                                                    class="form-control @error('temp_olie_godet_2') is-invalid @enderror"
                                                    id="temp_olie_godet_2" name="temp_olie_godet_2"
                                                    value="{{ old('temp_olie_godet_2') ?? $kontrolreifen->temp_olie_godet_2 }}">
                                                @error('temp_olie_godet_2')
                                                    <span id="temp_olie_godet_2-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="temp_oven">Temp. Oven</label>
                                                <input type="text"
                                                    class="form-control @error('temp_oven') is-invalid @enderror"
                                                    id="temp_oven" name="temp_oven"
                                                    value="{{ old('temp_oven') ?? $kontrolreifen->temp_oven }}">
                                                @error('temp_oven')
                                                    <span id="temp_oven-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="temp_pendingin_film">Temp. Pendingin Film</label>
                                                <input type="text"
                                                    class="form-control @error('temp_pendingin_film') is-invalid @enderror"
                                                    id="temp_pendingin_film" name="temp_pendingin_film"
                                                    value="{{ old('temp_pendingin_film') ?? $kontrolreifen->temp_pendingin_film }}">
                                                @error('temp_pendingin_film')
                                                    <span id="temp_pendingin_film-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="bak_air">Bak Air</label>
                                                <input type="text"
                                                    class="form-control @error('bak_air') is-invalid @enderror"
                                                    id="bak_air" name="bak_air"
                                                    value="{{ old('bak_air') ?? $kontrolreifen->bak_air }}">
                                                @error('bak_air')
                                                    <span id="bak_air-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="cylinder">Cylinder</label>
                                                <input type="text"
                                                    class="form-control @error('cylinder') is-invalid @enderror"
                                                    id="cylinder" name="cylinder"
                                                    value="{{ old('cylinder') ?? $kontrolreifen->cylinder }}">
                                                @error('cylinder')
                                                    <span id="cylinder-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="keterangan">Keterangan</label>
                                                <textarea class="form-control @error('keterangan') is-invalid @enderror" rows="10" id="keterangan"
                                                    name="keterangan">{!! $kontrolreifen->keterangan !!}</textarea>
                                                @error('keterangan')
                                                    <span id="keterangan-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="button" class="btn btn-default"
                                        href="{{ route('produksiextruder-kontrol-reifen.index') }}"><i
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
    </script>
@endsection
