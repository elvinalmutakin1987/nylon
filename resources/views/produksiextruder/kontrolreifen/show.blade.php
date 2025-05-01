@php
    use Illuminate\Support\Number;
    use App\Models\Mesin;
    use App\Models\Material;
    use App\Models\Kontrolreifendetail;
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
                            <div class="card-header">
                                <h3 class="card-title">Serah Terima Laporan Kontrol Reifen</h3>
                            </div>
                            <div class="card-body">
                                @if ($kontrolreifen_sebelumnya)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="tanggal">Tanggal</label>
                                                    <input type="text"
                                                        class="form-control @error('tanggal') is-invalid @enderror"
                                                        id="tanggal" name="tanggal"
                                                        value="{{ old('tanggal') ?? $kontrolreifen_sebelumnya->tanggal }}"
                                                        readonly>
                                                    @error('tanggal')
                                                        <span id="tanggal-error"
                                                            class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="shift">Shift</label>
                                                <input type="text"
                                                    class="form-control @error('shift') is-invalid @enderror" id="shift"
                                                    name="shift"
                                                    value="{{ old('shift') ?? $kontrolreifen_sebelumnya->shift }}" readonly>
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
                                                    value="{{ old('pengawas') ?? $kontrolreifen_sebelumnya->pengawas }}"
                                                    readonly>
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
                                                    name="jenis"
                                                    value="{{ old('jenis') ?? $kontrolreifen_sebelumnya->jenis }}" readonly>
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
                                                    value="{{ old('melt_flow') ?? $kontrolreifen_sebelumnya->melt_flow }}"
                                                    readonly>
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
                                                    value="{{ old('jenis_produksi') ?? $kontrolreifen_sebelumnya->jenis_produksi }}"
                                                    readonly>
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
                                                    value="{{ old('bahan_campuran') ?? $kontrolreifen_sebelumnya->bahan_campuran }}"
                                                    readonly>
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
                                                    value="{{ old('pengesetan_mesin') ?? $kontrolreifen_sebelumnya->pengesetan_mesin }}"
                                                    readonly>
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
                                                    value="{{ old('lebar_spacer') ?? $kontrolreifen_sebelumnya->lebar_spacer }}"
                                                    readonly>
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
                                                    value="{{ old('lebar_benang_jadi') ?? $kontrolreifen_sebelumnya->lebar_benang_jadi }}"
                                                    readonly>
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
                                                    value="{{ old('jumlah_benang_jadi') ?? $kontrolreifen_sebelumnya->jumlah_benang_jadi }}"
                                                    readonly>
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
                                                    value="{{ old('denier') ?? $kontrolreifen_sebelumnya->denier }}"
                                                    readonly>
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
                                                    value="{{ old('srt') ?? $kontrolreifen_sebelumnya->srt }}" readonly>
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
                                                    value="{{ old('tebal_film') ?? $kontrolreifen_sebelumnya->tebal_film }}"
                                                    readonly>
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
                                                    value="{{ old('screw_rpm') ?? $kontrolreifen_sebelumnya->screw_rpm }}"
                                                    readonly>
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
                                                    value="{{ old('godet_1_rpm') ?? $kontrolreifen_sebelumnya->godet_1_rpm }}"
                                                    readonly>
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
                                                    value="{{ old('godet_2_rpm') ?? $kontrolreifen_sebelumnya->godet_2_rpm }}"
                                                    readonly>
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
                                                    value="{{ old('cylinder_1') ?? $kontrolreifen_sebelumnya->cylinder_1 }}"
                                                    readonly>
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
                                                    value="{{ old('cylinder_2') ?? $kontrolreifen_sebelumnya->cylinder_2 }}"
                                                    readonly>
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
                                                    value="{{ old('cylinder_3') ?? $kontrolreifen_sebelumnya->cylinder_3 }}"
                                                    readonly>
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
                                                    value="{{ old('cylinder_4') ?? $kontrolreifen_sebelumnya->cylinder_4 }}"
                                                    readonly>
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
                                                    value="{{ old('adaptor_1') ?? $kontrolreifen_sebelumnya->adaptor_1 }}"
                                                    readonly>
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
                                                    value="{{ old('adaptor_2') ?? $kontrolreifen_sebelumnya->adaptor_2 }}"
                                                    readonly>
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
                                                    value="{{ old('adaptor_3') ?? $kontrolreifen_sebelumnya->adaptor_3 }}"
                                                    readonly>
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
                                                    value="{{ old('dies_1') ?? $kontrolreifen_sebelumnya->dies_1 }}"
                                                    readonly>
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
                                                    value="{{ old('dies_2') ?? $kontrolreifen_sebelumnya->dies_2 }}"
                                                    readonly>
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
                                                    value="{{ old('dies_3') ?? $kontrolreifen_sebelumnya->dies_3 }}"
                                                    readonly>
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
                                                    value="{{ old('dies_4') ?? $kontrolreifen_sebelumnya->dies_4 }}"
                                                    readonly>
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
                                                    value="{{ old('dies_5') ?? $kontrolreifen_sebelumnya->dies_5 }}"
                                                    readonly>
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
                                                    value="{{ old('dies_6') ?? $kontrolreifen_sebelumnya->dies_6 }}"
                                                    readonly>
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
                                                    value="{{ old('dies_7') ?? $kontrolreifen_sebelumnya->dies_7 }}"
                                                    readonly>
                                                @error('dies_7')
                                                    <span id="dies_7-error"
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
                                                    value="{{ old('melt_presure') ?? $kontrolreifen_sebelumnya->melt_presure }}"
                                                    readonly>
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
                                                    value="{{ old('melt_temperatur') ?? $kontrolreifen_sebelumnya->melt_temperatur }}"
                                                    readonly>
                                                @error('melt_temperatur')
                                                    <span id="melt_temperatur-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="faltur_indicator">Faltur Indicator</label>
                                                <input type="text"
                                                    class="form-control @error('faltur_indicator') is-invalid @enderror"
                                                    id="faltur_indicator" name="faltur_indicator"
                                                    value="{{ old('faltur_indicator') ?? $kontrolreifen_sebelumnya->faltur_indicator }}"
                                                    readonly>
                                                @error('faltur_indicator')
                                                    <span id="faltur_indicator-error"
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
                                                    value="{{ old('temp_olie_godet_2') ?? $kontrolreifen_sebelumnya->temp_olie_godet_2 }} "
                                                    readonly>
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
                                                    value="{{ old('temp_oven') ?? $kontrolreifen_sebelumnya->temp_oven }}"
                                                    readonly>
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
                                                    value="{{ old('temp_pendingin_film') ?? $kontrolreifen_sebelumnya->temp_pendingin_film }}"
                                                    readonly>
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
                                                    value="{{ old('bak_air') ?? $kontrolreifen_sebelumnya->bak_air }}"
                                                    readonly>
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
                                                    value="{{ old('cylinder') ?? $kontrolreifen_sebelumnya->cylinder }} "
                                                    readonly>
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
                                                    name="keterangan" readonly>{!! old('keterangan') ?? $kontrolreifen_sebelumnya->keterangan !!}</textarea>
                                                @error('keterangan')
                                                    <span id="keterangan-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if ($action == 'create')
                                                <a type="button" class="btn btn-success"
                                                    href="{{ route('produksiextruder-kontrol-reifen.create_laporan', ['tanggal' => $tanggal, 'shift' => $shift]) }}"><i
                                                        class="fa fa-forward"></i>
                                                    Lanjutkan Buat Laporan</a>
                                            @else
                                                <a type="button" class="btn btn-success"
                                                    href="{{ route('produksiextruder-kontrol-reifen.edit', $kontrolreifen->slug) }}"><i
                                                        class="fa fa-forward"></i>
                                                    Lanjutkan Buat Laporan</a>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>Tidak ada data untuk di serah terima.</p>
                                            @if ($action == 'create')
                                                <a type="button" class="btn btn-success"
                                                    href="{{ route('produksiextruder-kontrol-reifen.create_laporan', ['tanggal' => $tanggal, 'shift' => $shift]) }}"><i
                                                        class="fa fa-forward"></i>
                                                    Lanjutkan Buat Laporan</a>
                                            @else
                                                <a type="button" class="btn btn-success"
                                                    href="{{ route('produksiextruder-kontrol-reifen.edit', $kontrolreifen->slug) }}"><i
                                                        class="fa fa-forward"></i>
                                                    Lanjutkan Buat Laporan</a>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <a type="button" class="btn btn-default"
                                    href="{{ route('produksiextruder-kontrol-reifen.index') }}"><i
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

        function ubah_format(field, nilai) {
            var mynumeral = numeral(nilai).format('0');
            // mynumeral = parseFloat(mynumeral) / 1000
            // mynumeral = numeral(mynumeral).format('0.000')
            $("#" + field).val(mynumeral);
        }
    </script>
@endsection
