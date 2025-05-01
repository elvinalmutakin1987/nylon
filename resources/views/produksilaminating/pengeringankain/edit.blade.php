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
                            <li class="breadcrumb-item"><a href="{{ route('produksi.index') }}"
                                    class="text-dark">Produksi</a>
                            </li>
                            <li class="breadcrumb-item">Laporan Pengeringan Kain</li>
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
                        <form action="{{ route('produksilaminating.pengeringankain.update', $pengeringankain->slug) }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            @method('put')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Laporan Pengeringan Kain</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="wjl_tanggal">Tanggal</label>
                                                    <input type="text"
                                                        class="form-control @error('wjl_tanggal') is-invalid @enderror"
                                                        id="wjl_tanggal" name="wjl_tanggal"
                                                        value="{{ old('wjl_tanggal') ?? $pengeringankain->wjl_tanggal }}"
                                                        readonly>
                                                    @error('wjl_tanggal')
                                                        <span id="wjl_tanggal-error"
                                                            class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="wjl_operator">Operator</label>
                                                <input type="text"
                                                    class="form-control @error('wjl_operator') is-invalid @enderror"
                                                    id="wjl_operator" name="wjl_operator"
                                                    value="{{ old('wjl_operator') ?? $pengeringankain->wjl_operator }}"
                                                    readonly>
                                                @error('wjl_operator')
                                                    <span id="wjl_operator-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="wjl_jenis_kain">Jenis Kain</label>
                                                <input type="text"
                                                    class="form-control @error('wjl_jenis_kain') is-invalid @enderror"
                                                    id="wjl_jenis_kain" name="wjl_jenis_kain"
                                                    value="{{ old('wjl_jenis_kain') ?? $pengeringankain->wjl_jenis_kain }}"
                                                    readonly>
                                                @error('wjl_jenis_kain')
                                                    <span id="jenis_kain-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="wjl_no_roll">No. Roll</label>
                                                <input type="text"
                                                    class="form-control @error('wjl_no_roll') is-invalid @enderror"
                                                    id="wjl_no_roll" name="wjl_no_roll"
                                                    value="{{ old('wjl_no_roll') ?? $pengeringankain->wjl_no_roll }}">
                                                @error('wjl_no_roll')
                                                    <span id="wjl_no_roll-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="mesin_id">No. Mesin</label>
                                                <input type="text"
                                                    class="form-control @error('mesin_id') is-invalid @enderror"
                                                    id="mesin_id" name="mesin_id"
                                                    value="{{ old('mesin_id') ?? $mesin->nama }}" readonly>
                                                @error('mesin_id')
                                                    <span id="mesin_id-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="wjl_kondisi_kain">Kondisi Kain</label>
                                                <input type="text"
                                                    class="form-control @error('wjl_kondisi_kain') is-invalid @enderror"
                                                    id="wjl_kondisi_kain" name="wjl_kondisi_kain"
                                                    value="{{ old('wjl_kondisi_kain') ?? $pengeringankain->wjl_kondisi_kain }}"
                                                    readonly>
                                                @error('wjl_kondisi_kain')
                                                    <span id="wjl_kondisi_kain-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="wjl_panjang">Panjang</label>
                                                <input type="text"
                                                    class="form-control @error('wjl_panjang') is-invalid @enderror"
                                                    id="wjl_panjang" name="wjl_panjang"
                                                    value="{{ old('wjl_panjang') ?? $pengeringankain->wjl_panjang }}"
                                                    readonly>
                                                @error('wjl_panjang')
                                                    <span id="wjl_panjang-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="wjl_lebar">Lebar</label>
                                                <input type="text"
                                                    class="form-control @error('wjl_lebar') is-invalid @enderror"
                                                    id="wjl_lebar" name="wjl_lebar"
                                                    value="{{ old('wjl_lebar') ?? $pengeringankain->wjl_lebar }}"
                                                    readonly>
                                                @error('wjl_lebar')
                                                    <span id="wjl_lebar-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="wjl_berat">Berat</label>
                                                <input type="text"
                                                    class="form-control @error('wjl_berat') is-invalid @enderror"
                                                    id="wjl_berat" name="wjl_berat"
                                                    value="{{ old('wjl_berat') ?? $pengeringankain->wjl_berat }}"
                                                    readonly>
                                                @error('wjl_berat')
                                                    <span id="wjl_berat-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <table id="table1" class="table projects">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 150px">Meter Ke</th>
                                                        <th>Kerusakan</th>
                                                        <th class="text-center" style="width: 50px"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($pengeringankain->pengeringankaindetail as $d)
                                                        <tr>
                                                            <td>
                                                                <input type="text" class="form-control" id="meter1"
                                                                    name="meter[]"
                                                                    onblur="ubah_format('meter1', this.value)"
                                                                    value="{{ Number::format((float) $d->meter, precision: 0) }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control w-100"
                                                                    id="kerusakan1" name="kerusakan[]"
                                                                    value="{{ $d->kerusakan }}">
                                                            </td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-danger"
                                                                    id="hapus"><i class="fa fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-primary"
                                                                onclick="tambah()"><i class="fa fa-plus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="card card-primary card-outline card-outline-tabs">
                                                <div class="card-header p-0 border-bottom-0">
                                                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="custom-tabs-one-home-tab"
                                                                data-toggle="pill" href="#custom-tabs-one-home"
                                                                role="tab" aria-controls="custom-tabs-one-home"
                                                                aria-selected="true">Pengeringan 1</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="custom-tabs-one-profile-tab"
                                                                data-toggle="pill" href="#custom-tabs-one-profile"
                                                                role="tab" aria-controls="custom-tabs-one-profile"
                                                                aria-selected="false">Pengeringan 2</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="custom-tabs-one-messages-tab"
                                                                data-toggle="pill" href="#custom-tabs-one-messages"
                                                                role="tab" aria-controls="custom-tabs-one-messages"
                                                                aria-selected="false">Pengeringan 3</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="card-body">
                                                    <div class="tab-content" id="custom-tabs-one-tabContent">
                                                        <div class="tab-pane fade show active" id="custom-tabs-one-home"
                                                            role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                                            <div class="form-group">
                                                                <label for="operator_1">Operator</label>
                                                                <input type="text"
                                                                    class="form-control @error('operator_1') is-invalid @enderror"
                                                                    id="operator_1" name="operator_1"
                                                                    value="{{ old('operator_1') ?? $pengeringankain->operator_1 }}">
                                                                @error('operator_1')
                                                                    <span id="operator_1-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tanggal_1">Tanggal</label>
                                                                <div class="input-group date" id="div_tanggal_1"
                                                                    data-target-input="nearest">
                                                                    <input type="text"
                                                                        class="form-control datetimepicker-input"
                                                                        data-target="#div_tanggal_1" id="tanggal_1"
                                                                        name="tanggal_1"
                                                                        value="{{ old('tanggal_1') ?? $pengeringankain->tanggal_1 }}" />
                                                                    <div class="input-group-append"
                                                                        data-target="#div_tanggal_1"
                                                                        data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i
                                                                                class="fa fa-calendar"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @error('tanggal')
                                                                    <span id="nama-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="jam_1">Jam</label>
                                                                <div class="input-group date" id="div_jam_1"
                                                                    data-target-input="nearest">
                                                                    <input type="text"
                                                                        class="form-control datetimepicker-input"
                                                                        data-target="#div_jam_1" id="jam_1"
                                                                        name="jam_1"
                                                                        value="{{ old('jam_1') ?? $pengeringankain->jam_1 }}" />
                                                                    <div class="input-group-append"
                                                                        data-target="#div_jam_1"
                                                                        data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i
                                                                                class="fa fa-clock"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @error('tanggal')
                                                                    <span id="nama-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kondisi_kain_1">Kondisi Kain</label>
                                                                <select
                                                                    class="form-control select2 w-100 select-kondisi @error('kondisi_kain_1') is-invalid @enderror"
                                                                    id="kondisi_kain_1" name="kondisi_kain_1">
                                                                    <option value=""></option>
                                                                    <option value="Kering"
                                                                        {{ $pengeringankain->kondisi_kain_1 == 'Kering' ? 'selected' : '' }}>
                                                                        Kering</option>
                                                                    <option value="Basah"
                                                                        {{ $pengeringankain->kondisi_kain_2 == 'Basah' ? 'selected' : '' }}>
                                                                        Basah</option>
                                                                </select>
                                                                @error('kondisi_kain_1')
                                                                    <span id="kondisi_kain_1-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="berat_1">Berat</label>
                                                                <input type="text"
                                                                    class="form-control @error('berat_1') is-invalid @enderror"
                                                                    id="berat_1" name="berat_1"
                                                                    value="{{ old('berat_1') ?? $pengeringankain->berat_1 }}">
                                                                @error('berat_1')
                                                                    <span id="berat_1-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="lebar_1">Lebar</label>
                                                                <input type="text"
                                                                    class="form-control @error('lebar_1') is-invalid @enderror"
                                                                    id="lebar_1" name="lebar_1"
                                                                    value="{{ old('lebar_1') ?? $pengeringankain->lebar_1 }}">
                                                                @error('lebar_1')
                                                                    <span id="berat_1-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="panjang_1">Panjang</label>
                                                                <input type="text"
                                                                    class="form-control @error('panjang_1') is-invalid @enderror"
                                                                    id="panjang_1" name="panjang_1"
                                                                    value="{{ old('panjang_1') ?? $pengeringankain->panjang_1 }}">
                                                                @error('panjang_1')
                                                                    <span id="panjang_1-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="suhu_1">Suhu</label>
                                                                <input type="text"
                                                                    class="form-control @error('suhu_1') is-invalid @enderror"
                                                                    id="suhu_1" name="suhu_1"
                                                                    value="{{ old('suhu_1') ?? $pengeringankain->suhu_1 }}">
                                                                @error('suhu_1')
                                                                    <span id="suhu_1-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kecepatan_screw_2">Kecepatan Screw</label>
                                                                <input type="text"
                                                                    class="form-control @error('kecepatan_screw_1') is-invalid @enderror"
                                                                    id="kecepatan_screw_1" name="kecepatan_screw_1"
                                                                    value="{{ old('kecepatan_screw_1') ?? $pengeringankain->kecepatan_screw_1 }}">
                                                                @error('kecepatan_screw_1')
                                                                    <span id="kecepatan_screw_1-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kecapatan_winder_1">Kecepatan Winder</label>
                                                                <input type="text"
                                                                    class="form-control @error('kecapatan_winder_1') is-invalid @enderror"
                                                                    id="kecapatan_winder_1" name="kecapatan_winder_1"
                                                                    value="{{ old('kecapatan_winder_1') ?? $pengeringankain->kecepatan_winder_1 }}">
                                                                @error('kecapatan_winder_1')
                                                                    <span id="kecapatan_winder_1-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kondisi_kain2_1">Kondisi Kain</label>
                                                                <select
                                                                    class="form-control select2 w-100 select-kondisi-2 @error('kondisi_kain2_1') is-invalid @enderror"
                                                                    id="kondisi_kain2_1" name="kondisi_kain2_1">
                                                                    <option value=""></option>
                                                                    <option value="Bagus"
                                                                        {{ $pengeringankain->kondisi_kain2_1 == 'Bagus' ? 'selected' : '' }}>
                                                                        Bagus</option>
                                                                    <option value="Ngelewer"
                                                                        {{ $pengeringankain->kondisi_kain2_1 == 'Ngelewer' ? 'selected' : '' }}>
                                                                        Ngelewer</option>
                                                                    <option value="Nglipat"
                                                                        {{ $pengeringankain->kondisi_kain2_1 == 'Nglipat' ? 'selected' : '' }}>
                                                                        Nglipat</option>
                                                                </select>
                                                                @error('kondisi_kain2_1')
                                                                    <span id="kondisi_kain2_1-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="custom-tabs-one-profile"
                                                            role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                                            <div class="form-group">
                                                                <label for="operator_2">Operator</label>
                                                                <input type="text"
                                                                    class="form-control @error('operator_2') is-invalid @enderror"
                                                                    id="operator_2" name="operator_2"
                                                                    value="{{ old('operator_2') ?? $pengeringankain->operator_2 }}">
                                                                @error('operator_2')
                                                                    <span id="operator_1-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tanggal_1">Tanggal</label>
                                                                <div class="input-group date" id="div_tanggal_2"
                                                                    data-target-input="nearest">
                                                                    <input type="text"
                                                                        class="form-control datetimepicker-input"
                                                                        data-target="#div_tanggal_2" id="tanggal_2"
                                                                        name="tanggal_2"
                                                                        value="{{ old('tanggal_2') ?? $pengeringankain->tanggal_2 }}" />
                                                                    <div class="input-group-append"
                                                                        data-target="#div_tanggal_2"
                                                                        data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i
                                                                                class="fa fa-calendar"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @error('tanggal')
                                                                    <span id="nama-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="jam_2">Jam</label>
                                                                <div class="input-group date" id="div_jam_2"
                                                                    data-target-input="nearest">
                                                                    <input type="text"
                                                                        class="form-control datetimepicker-input"
                                                                        data-target="#div_jam_2" id="jam_2"
                                                                        name="jam_2"
                                                                        value="{{ old('jam_2') ?? $pengeringankain->jam_2 }}" />
                                                                    <div class="input-group-append"
                                                                        data-target="#div_jam_2"
                                                                        data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i
                                                                                class="fa fa-clock"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @error('tanggal')
                                                                    <span id="nama-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kondisi_kain_2">Kondisi Kain</label>
                                                                <select
                                                                    class="form-control select2 w-100 select-kondisi @error('kondisi_kain_2') is-invalid @enderror"
                                                                    id="kondisi_kain_2" name="kondisi_kain_2">
                                                                    <option value=""></option>
                                                                    <option value="Kering"
                                                                        {{ $pengeringankain->kondisi_kain_2 == 'Kering' ? 'selected' : '' }}>
                                                                        Kering</option>
                                                                    <option value="Basah"
                                                                        {{ $pengeringankain->kondisi_kain_2 == 'Basah' ? 'selected' : '' }}>
                                                                        Basah</option>
                                                                </select>
                                                                @error('kondisi_kain_2')
                                                                    <span id="kondisi_kain_2-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="berat_2">Berat</label>
                                                                <input type="text"
                                                                    class="form-control @error('berat_2') is-invalid @enderror"
                                                                    id="berat_2" name="berat_2"
                                                                    value="{{ old('berat_2') ?? $pengeringankain->berat_2 }}">
                                                                @error('berat_2')
                                                                    <span id="berat_2-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="lebar_2">Lebar</label>
                                                                <input type="text"
                                                                    class="form-control @error('lebar_2') is-invalid @enderror"
                                                                    id="lebar_2" name="lebar_2"
                                                                    value="{{ old('lebar_2') ?? $pengeringankain->lebar_2 }}">
                                                                @error('lebar_2')
                                                                    <span id="berat_1-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="panjang_2">Panjang</label>
                                                                <input type="text"
                                                                    class="form-control @error('panjang_2') is-invalid @enderror"
                                                                    id="panjang_2" name="panjang_2"
                                                                    value="{{ old('panjang_2') ?? $pengeringankain->panjang_2 }}">
                                                                @error('panjang_2')
                                                                    <span id="panjang_2-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="suhu_2">Suhu</label>
                                                                <input type="text"
                                                                    class="form-control @error('suhu_2') is-invalid @enderror"
                                                                    id="suhu_2" name="suhu_2"
                                                                    value="{{ old('suhu_2') ?? $pengeringankain->suhu_2 }}">
                                                                @error('suhu_2')
                                                                    <span id="suhu_2-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kecepatan_screw_2">Kecepatan Screw</label>
                                                                <input type="text"
                                                                    class="form-control @error('kecepatan_screw_2') is-invalid @enderror"
                                                                    id="kecepatan_screw_2" name="kecepatan_screw_2"
                                                                    value="{{ old('kecepatan_screw_2') ?? $pengeringankain->kecepetana_screw_2 }}">
                                                                @error('kecepatan_screw_2')
                                                                    <span id="kecepatan_screw_2-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kecepatan_winder_2">Kecepatan Winder</label>
                                                                <input type="text"
                                                                    class="form-control @error('kecepatan_winder_2') is-invalid @enderror"
                                                                    id="kecepatan_winder_2" name="kecepatan_winder_2"
                                                                    value="{{ old('kecepatan_winder_2') ?? $pengeringankain->kecepatana_winder_2 }}">
                                                                @error('kecepatan_winder_2')
                                                                    <span id="kecepatan_winder_2-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kondisi_kain2_2">Kondisi Kain</label>
                                                                <select
                                                                    class="form-control select2 w-100 select-kondisi-2 @error('kondisi_kain2_2') is-invalid @enderror"
                                                                    id="kondisi_kain2_2" name="kondisi_kain2_2">
                                                                    <option value=""></option>
                                                                    <option value="Bagus"
                                                                        {{ $pengeringankain->kondisi_kain2_2 == 'Bagus' ? 'selected' : '' }}>
                                                                        Bagus</option>
                                                                    <option value="Ngelewer"
                                                                        {{ $pengeringankain->kondisi_kain2_2 == 'Ngelewer' ? 'selected' : '' }}>
                                                                        Ngelewer</option>
                                                                    <option value="Nglipat"
                                                                        {{ $pengeringankain->kondisi_kain2_2 == 'Ngelipat' ? 'selected' : '' }}>
                                                                        Nglipat</option>
                                                                </select>
                                                                @error('kondisi_kain2_2')
                                                                    <span id="kondisi_kain2_2-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="custom-tabs-one-messages"
                                                            role="tabpanel"
                                                            aria-labelledby="custom-tabs-one-messages-tab">
                                                            <div class="form-group">
                                                                <label for="operator_3">Operator</label>
                                                                <input type="text"
                                                                    class="form-control @error('operator_3') is-invalid @enderror"
                                                                    id="operator_3" name="operator_3"
                                                                    value="{{ old('operator_3') ?? $pengeringankain->operator_3 }}">
                                                                @error('operator_3')
                                                                    <span id="operator_3-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tanggal_3">Tanggal</label>
                                                                <div class="input-group date" id="div_tanggal_3"
                                                                    data-target-input="nearest">
                                                                    <input type="text"
                                                                        class="form-control datetimepicker-input"
                                                                        data-target="#div_tanggal_3" id="tanggal_3"
                                                                        name="tanggal_3"
                                                                        value="{{ old('tanggal_3') ?? $pengeringankain->tanggal_3 }}" />
                                                                    <div class="input-group-append"
                                                                        data-target="#div_tanggal_3"
                                                                        data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i
                                                                                class="fa fa-calendar"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @error('tanggal')
                                                                    <span id="nama-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="jam_3">Jam</label>
                                                                <div class="input-group date" id="div_jam_3"
                                                                    data-target-input="nearest">
                                                                    <input type="text"
                                                                        class="form-control datetimepicker-input"
                                                                        data-target="#div_jam_3" id="jam_3"
                                                                        name="jam_3"
                                                                        value="{{ old('jam_3') ?? $pengeringankain->jam_3 }}" />
                                                                    <div class="input-group-append"
                                                                        data-target="#div_jam_3"
                                                                        data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i
                                                                                class="fa fa-clock"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @error('tanggal')
                                                                    <span id="nama-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kondisi_kain_3">Kondisi Kain</label>
                                                                <select
                                                                    class="form-control select2 w-100 select-kondisi @error('kondisi_kain_3') is-invalid @enderror"
                                                                    id="kondisi_kain_3" name="kondisi_kain_3">
                                                                    <option value=""></option>
                                                                    <option value="Kering"
                                                                        {{ $pengeringankain->kondisi_kain_3 == 'Kering' ? 'selected' : '' }}>
                                                                        Kering</option>
                                                                    <option value="Basah"
                                                                        {{ $pengeringankain->kondisi_kain_3 == 'Basah' ? 'selected' : '' }}>
                                                                        Basah</option>
                                                                </select>
                                                                @error('kondisi_kain_3')
                                                                    <span id="kondisi_kain_3-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="berat_3">Berat</label>
                                                                <input type="text"
                                                                    class="form-control @error('berat_3') is-invalid @enderror"
                                                                    id="berat_3" name="berat_3"
                                                                    value="{{ old('berat_3') ?? $pengeringankain->berat_3 }}">
                                                                @error('berat_3')
                                                                    <span id="berat_3-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="lebar_3">Lebar</label>
                                                                <input type="text"
                                                                    class="form-control @error('lebar_3') is-invalid @enderror"
                                                                    id="lebar_3" name="lebar_3"
                                                                    value="{{ old('lebar_3') ?? $pengeringankain->lebar_3 }}">
                                                                @error('lebar_3')
                                                                    <span id="berat_1-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="panjang_3">Panjang</label>
                                                                <input type="text"
                                                                    class="form-control @error('panjang_3') is-invalid @enderror"
                                                                    id="panjang_3" name="panjang_3"
                                                                    value="{{ old('panjang_3') ?? $pengeringankain->panjang_3 }}">
                                                                @error('panjang_3')
                                                                    <span id="panjang_3-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="suhu_3">Suhu</label>
                                                                <input type="text"
                                                                    class="form-control @error('suhu_3') is-invalid @enderror"
                                                                    id="suhu_3" name="suhu_3"
                                                                    value="{{ old('suhu_3') ?? $pengeringankain->suhu_3 }}">
                                                                @error('suhu_3')
                                                                    <span id="suhu_3-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kecepatan_screw_3">Kecepatan Screw</label>
                                                                <input type="text"
                                                                    class="form-control @error('kecepatan_screw_3') is-invalid @enderror"
                                                                    id="kecepatan_screw_3" name="kecepatan_screw_3"
                                                                    value="{{ old('kecepatan_screw_3') ?? $pengeringankain->kecepatan_screw_3 }}">
                                                                @error('kecepatan_screw_3')
                                                                    <span id="kecepatan_screw_3-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kecepatan_winder_3">Kecepatan Winder</label>
                                                                <input type="text"
                                                                    class="form-control @error('kecepatan_winder_3') is-invalid @enderror"
                                                                    id="kecepatan_winder_3" name="kecepatan_winder_3"
                                                                    value="{{ old('kecepatan_winder_3') ?? $pengeringankain->kecepatan_winder_3 }}">
                                                                @error('kecepatan_winder_3')
                                                                    <span id="kecepatan_winder_3-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="kondisi_kain2_3">Kondisi Kain</label>
                                                                <select
                                                                    class="form-control select2 w-100 select-kondisi-2 @error('kondisi_kain2_3') is-invalid @enderror"
                                                                    id="kondisi_kain2_3" name="kondisi_kain2_3">
                                                                    <option value=""></option>
                                                                    <option value="Bagus"
                                                                        {{ $pengeringankain->kondisi_kain2_3 == 'Bagus' ? 'selected' : '' }}>
                                                                        Bagus</option>
                                                                    <option value="Ngelewer"
                                                                        {{ $pengeringankain->kondisi_kain2_3 == 'Ngelewer' ? 'selected' : '' }}>
                                                                        Ngelewer</option>
                                                                    <option value="Nglipat"
                                                                        {{ $pengeringankain->kondisi_kain2_3 == 'Nglipat' ? 'selected' : '' }}>
                                                                        Nglipat</option>
                                                                </select>
                                                                @error('kondisi_kain2_3')
                                                                    <span id="kondisi_kain2_3-error"
                                                                        class="error invalid-feedback">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- /.card -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <a type="button" class="btn btn-default"
                                        href="{{ route('produksilaminating.pengeringankain.index') }}"><i
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
            $('#div_tanggal_1').datetimepicker({
                format: 'YYYY-MM-DD'
            });
            $('#div_jam_1').datetimepicker({
                format: 'h:m:s'
            });

            $('#div_tanggal_2').datetimepicker({
                format: 'YYYY-MM-DD'
            });
            $('#div_jam_2').datetimepicker({
                format: 'h:m:s'
            });

            $('#div_tanggal_3').datetimepicker({
                format: 'YYYY-MM-DD'
            });
            $('#div_jam_3').datetimepicker({
                format: 'h:m:s'
            });

            format_select2();
        });

        function format_select2() {
            $('.select-shift').select2({
                width: '100%',
                minimumResultsForSearch: -1,
            });

            $('.select-kondisi').select2({
                width: '100%',
                placeholder: "- Pilih Kondisi -",
                allowClear: true,
            });

            $('.select-kondisi-2').select2({
                width: '100%',
                placeholder: "- Pilih Kondisi -",
                allowClear: true,
            });

            $('.select-mesin').select2({
                placeholder: "- Pilih Mesin -",
                allowClear: true,
                ajax: {
                    url: '{{ route('produksilaminating.pengeringankain.get_mesin') }}',
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
            $("#" + field).val(mynumeral);
        }

        function tambah() {
            var tbody_row = $('#table1').find('tr').length;
            var row_id = Date.now().toString(36) + Math.random().toString(36).substr(2);
            $("#table1 > tbody > tr:last").before(`
                <tr>
                    <td>
                        <input type="text" class="form-control" id="meter${row_id}"
                            name="meter[]" onblur="ubah_format('meter${row_id}', this.value)">
                    </td>
                    <td>
                        <input type="text" class="form-control w-100"
                            id="kerusakan${row_id}" name="kerusakan[]">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger" id="hapus"><i
                                class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);

        }

        $("#table1").on("click", "#hapus", function() {
            $(this).closest("tr").remove();
        });


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
