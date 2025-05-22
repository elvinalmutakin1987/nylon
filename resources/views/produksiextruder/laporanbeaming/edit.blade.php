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
                            <li class="breadcrumb-item">Laporan Beaming</li>
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
                        <form action="{{ route('produksiextruder.laporanbeaming.store') }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            @method('POST')
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Laporan Beaming</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="tanggal">Tanggal</label>
                                                    <input type="text"
                                                        class="form-control @error('tanggal') is-invalid @enderror"
                                                        id="tanggal" name="tanggal"
                                                        value="{{ old('tanggal') ?? $laporanbeaming->tanggal }}" readonly>
                                                    @error('tanggal')
                                                        <span id="tanggal-error"
                                                            class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="beam_number">Beam Number</label>
                                                <input type="text"
                                                    class="form-control @error('beam_number') is-invalid @enderror"
                                                    id="beam_number" name="beam_number"
                                                    value="{{ old('beam_number') ?? $laporanbeaming->beam_number }}"
                                                    readonly>
                                                @error('beam_number')
                                                    <span id="beam_number-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="jenis_produksi">Jenis Produksi</label>
                                                <input type="text"
                                                    class="form-control @error('jenis_produksi') is-invalid @enderror"
                                                    id="jenis_produksi" name="jenis_produksi"
                                                    value="{{ old('jenis_produksi') ?? $laporanbeaming->jenis_produksi }}"
                                                    readonly>
                                                @error('jenis_produksi')
                                                    <span id="jenis_produksi-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="nomor">Nomor</label>
                                                    <input type="text"
                                                        class="form-control @error('nomor') is-invalid @enderror"
                                                        id="nomor" name="nomor" value="{{ $laporanbeaming->nomor }}">
                                                    @error('nomor')
                                                        <span id="nomor-error"
                                                            class="error invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="jenis_bahan">Jenis Bahan</label>
                                                <select
                                                    class="form-control select2 w-100 select-shift @error('jenis_bahan') is-invalid @enderror"
                                                    id="jenis_bahan" name="jenis_bahan">
                                                    <option value="PP"
                                                        {{ $laporanbeaming->jenis_bahan == 'PP' ? 'selected' : '' }}>
                                                        PP</option>
                                                    <option value="PE"
                                                        {{ $laporanbeaming->jenis_bahan == 'PE' ? 'selected' : '' }}>
                                                        PE</option>
                                                </select>
                                                @error('jenis_bahan')
                                                    <span id="jenis_bahan-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="denier">Denier</label>
                                                <input
                                                    type="text"class="form-control @error('denier') is-invalid @enderror"
                                                    id="denier" name="denier" value="{{ $laporanbeaming->denier }}">
                                                @error('denier')
                                                    <span id="denier-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lebar_benang">Lebar Benang</label>
                                                <input
                                                    type="text"class="form-control @error('lebar_benang') is-invalid @enderror"
                                                    id="lebar_benang" name="lebar_benang"
                                                    value="{{ $laporanbeaming->lebar_benang }}">
                                                @error('lebar_benang')
                                                    <span id="lebar_benang-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="warna_benang">Warna Benang</label>
                                                <input
                                                    type="text"class="form-control @error('warna_benang') is-invalid @enderror"
                                                    id="warna_benang" name="warna_benang"
                                                    value="{{ $laporanbeaming->warna_benang }}">
                                                @error('warna_benang')
                                                    <span id="warna_benang-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="jumlah_lungsi">Jumlah Lungsi</label>
                                                <input
                                                    type="text"class="form-control @error('jumlah_lungsi') is-invalid @enderror"
                                                    id="jumlah_lungsi" name="jumlah_lungsi"
                                                    value="{{ $laporanbeaming->jumlah_lungsi }}">
                                                @error('jumlah_lungsi')
                                                    <span id="jumlah_lungsi-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lebar_beam">Lebar Beam</label>
                                                <input
                                                    type="text"class="form-control @error('lebar_beam') is-invalid @enderror"
                                                    id="lebar_beam" name="lebar_beam"
                                                    value="{{ $laporanbeaming->lebar_beam }}">
                                                @error('lebar_beam')
                                                    <span id="lebar_beam-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="front_reed">Front Reed</label>
                                                <input
                                                    type="text"class="form-control @error('front_reed') is-invalid @enderror"
                                                    id="front_reed" name="front_reed"
                                                    value="{{ $laporanbeaming->front_reed }}">
                                                @error('front_reed')
                                                    <span id="front_reed-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="rear_read">Rear Reed</label>
                                                <input
                                                    type="text"class="form-control @error('rear_read') is-invalid @enderror"
                                                    id="rear_read" name="rear_read"
                                                    value="{{ $laporanbeaming->rear_read }}">
                                                @error('rear_read')
                                                    <span id="rear_read-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="traverse_reed">Traverse Reed</label>
                                                <input
                                                    type="text"class="form-control @error('traverse_reed') is-invalid @enderror"
                                                    id="traverse_reed" name="traverse_reed"
                                                    value="{{ $laporanbeaming->traverse_reed }}">
                                                @error('traverse_reed')
                                                    <span id="traverse_reed-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="benang_pinggiran_kiri">Benang Pinggiran (Kiri)</label>
                                                <input
                                                    type="text"class="form-control @error('benang_pinggiran_kiri') is-invalid @enderror"
                                                    id="benang_pinggiran_kiri" name="benang_pinggiran_kiri"
                                                    value="{{ $laporanbeaming->benang_pinggiran_kiri }}">
                                                @error('benang_pinggiran_kiri')
                                                    <span id="benang_pinggiran_kiri-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="benang_pinggiran_kanan">Benang Pinggiran (Kanan)</label>
                                                <input
                                                    type="text"class="form-control @error('benang_pinggiran_kanan') is-invalid @enderror"
                                                    id="benang_pinggiran_kanan" name="benang_pinggiran_kanan"
                                                    value="{{ $laporanbeaming->benang_pinggiran_kanan }}">
                                                @error('benang_pinggiran_kanan')
                                                    <span id="benang_pinggiran_kanan-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="benang_pinggiran_benang">Benang Pinggiran (Benang)</label>
                                                <input
                                                    type="text"class="form-control @error('benang_pinggiran_benang') is-invalid @enderror"
                                                    id="benang_pinggiran_benang" name="benang_pinggiran_benang"
                                                    value="{{ $laporanbeaming->benang_pinggiran_benang }}">
                                                @error('benang_pinggiran_benang')
                                                    <span id="benang_pinggiran_benang-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lebar_traverse">Lebar Traverse</label>
                                                <input
                                                    type="text"class="form-control @error('lebar_traverse') is-invalid @enderror"
                                                    id="lebar_traverse" name="lebar_traverse"
                                                    value="{{ $laporanbeaming->lebar_traverse }}">
                                                @error('lebar_traverse')
                                                    <span id="lebar_traverse-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="kecepatan_traverse">Kecepatan Traverse</label>
                                                <input
                                                    type="text"class="form-control @error('kecepatan_traverse') is-invalid @enderror"
                                                    id="kecepatan_traverse" name="kecepatan_traverse"
                                                    value="{{ $laporanbeaming->kecepatan_traverse }}">
                                                @error('kecepatan_traverse')
                                                    <span id="kecepatan_traverse-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="kecepatan_beaming">Kecepatan Beaming</label>
                                                <input
                                                    type="text"class="form-control @error('kecepatan_beaming') is-invalid @enderror"
                                                    id="kecepatan_beaming" name="kecepatan_beaming"
                                                    value="{{ $laporanbeaming->kecepatan_beaming }}">
                                                @error('kecepatan_beaming')
                                                    <span id="kecepatan_beaming-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="cut_mark">Cut Mark</label>
                                                <input
                                                    type="text"class="form-control @error('cut_mark') is-invalid @enderror"
                                                    id="cut_mark" name="cut_mark"
                                                    value="{{ $laporanbeaming->cut_mark }}">
                                                @error('cut_mark')
                                                    <span id="cut_mark-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="panjang_press_roller">Panjang Press Roller</label>
                                                <input
                                                    type="text"class="form-control @error('panjang_press_roller') is-invalid @enderror"
                                                    id="panjang_press_roller" name="panjang_press_roller"
                                                    value="{{ $laporanbeaming->panjang_press_roller }}">
                                                @error('panjang_press_roller')
                                                    <span id="panjang_press_roller-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tekanan_press_roller">Tekanan Press Roller</label>
                                                <input
                                                    type="text"class="form-control @error('tekanan_press_roller') is-invalid @enderror"
                                                    id="tekanan_press_roller" name="tekanan_press_roller"
                                                    value="{{ $laporanbeaming->tekanan_press_roller }}">
                                                @error('tekanan_press_roller')
                                                    <span id="tekanan_press_roller-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tension_roller_no_1">Tension Roller No. 1</label>
                                                <input
                                                    type="text"class="form-control @error('tension_roller_no_1') is-invalid @enderror"
                                                    id="tension_roller_no_1" name="tension_roller_no_1"
                                                    value="{{ $laporanbeaming->tension_roller_no_1 }}">
                                                @error('tension_roller_no_1')
                                                    <span id="tension_roller_no_1-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tension_roller_no_2">Tension Roller No. 2</label>
                                                <input
                                                    type="text"class="form-control @error('tension_roller_no_2') is-invalid @enderror"
                                                    id="tension_roller_no_2" name="tension_roller_no_2"
                                                    value="{{ $laporanbeaming->tension_roller_no_2 }}">
                                                @error('tension_roller_no_2')
                                                    <span id="tension_roller_no_2-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="traverse_reed_design">Traverse Reed Design</label>
                                                <input
                                                    type="text"class="form-control @error('traverse_reed_design') is-invalid @enderror"
                                                    id="traverse_reed_design" name="traverse_reed_design"
                                                    value="{{ $laporanbeaming->traverse_reed_design }}">
                                                @error('traverse_reed_design')
                                                    <span id="traverse_reed_design-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive p-0">
                                                <table id="table1" class="table projects table-bordered table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="text-center" style="width: 19%">
                                                                Tanggal
                                                            </th>
                                                            <th scope="col" class="text-center" style="width: 19%">
                                                                Shift
                                                            </th>
                                                            <th scope="col" class="text-center" style="width: 19%">
                                                                Meter Awal
                                                            </th>
                                                            <th scope="col" class="text-center" style="width: 19%">
                                                                Meter Akhir
                                                            </th>
                                                            <th scope="col" class="text-center" style="width: 19%">
                                                                Meter Hasil
                                                            </th>
                                                            <th style="width: 5%">

                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $total_meter = 0;
                                                        @endphp
                                                        @if ($laporanbeaming->laporanbeamingdetail->count() == 0)
                                                            <tr>
                                                                <td>
                                                                    <input type="date" class="form-control"
                                                                        id="tanggal_detail1" name="tanggal_detail[]"
                                                                        value="{{ date('Y-m-d') }}" />
                                                                </td>
                                                                <td>
                                                                    <select
                                                                        class="form-control select2 w-100 select-shift @error('shift_detail') is-invalid @enderror"
                                                                        id="shift_detail1" name="shift_detail[]">
                                                                        <option value="Pagi">Pagi</option>
                                                                        <option value="Sore">Sore</option>
                                                                        <option value="Malam">Malam</option>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        id="meter_awal1" name="meter_awal[]"
                                                                        onblur="ubah_format('meter_awal1', this.value); hitung_hasil('1'); hitung_total_meter()"
                                                                        value="">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        id="meter_akhir1" name="meter_akhir[]"
                                                                        onblur="ubah_format('meter_akhir1', this.value); hitung_hasil('1'); hitung_total_meter()"
                                                                        value="">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        id="meter_hasil1" name="meter_hasil[]" readonly
                                                                        value="">
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-primary"
                                                                        onclick="tambah()"><i
                                                                            class="fa fa-plus"></i></button>
                                                                </td>
                                                            </tr>
                                                        @else
                                                            @foreach ($laporanbeaming->laporanbeamingdetail as $d)
                                                                <tr>
                                                                    <td>
                                                                        <input type="date" class="form-control"
                                                                            id="tanggal_detail{{ $d->id }}"
                                                                            name="tanggal_detail[]"
                                                                            value="{{ $d->tanggal }}" />
                                                                    </td>
                                                                    <td>
                                                                        <select
                                                                            class="form-control select2 w-100 select-shift @error('shift_detail') is-invalid @enderror"
                                                                            id="shift_detail{{ $d->id }}"
                                                                            name="shift_detail[]">
                                                                            <option value="Pagi"
                                                                                {{ $d->shift == 'Pagi' ? 'selected' : '' }}>
                                                                                Pagi</option>
                                                                            <option value="Sore"
                                                                                {{ $d->shift == 'Sore' ? 'selected' : '' }}>
                                                                                Sore</option>
                                                                            <option value="Malam"
                                                                                {{ $d->shift == 'Malam' ? 'selected' : '' }}>
                                                                                Malam</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                            id="meter_awal{{ $d->id }}"
                                                                            name="meter_awal[]"
                                                                            onblur="ubah_format('meter_awal{{ $d->i }}', this.value); hitung_hasil('{{ $d->id }}'); hitung_total_meter()"
                                                                            value="{{ Illuminate\Support\Number::format((float) $d->meter_awal) }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                            id="meter_akhir{{ $d->id }}"
                                                                            name="meter_akhir[]"
                                                                            onblur="ubah_format('meter_akhir{{ $d->id }}', this.value); hitung_hasil('{{ $d->id }}'); hitung_total_meter()"
                                                                            value="{{ Illuminate\Support\Number::format((float) $d->meter_akhir) }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                            id="meter_hasil{{ $d->id }}"
                                                                            name="meter_hasil[]" readonly
                                                                            value="{{ Illuminate\Support\Number::format((float) $d->meter_hasil) }}">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @if ($loop->first && $laporanbeaming->laporanbeamingdetail->count() > 1)
                                                                            <button type="button" class="btn btn-danger"
                                                                                id="hapus"><i class="fa fa-trash"></i>
                                                                            </button>
                                                                        @else
                                                                            <button type="button" class="btn btn-primary"
                                                                                onclick="tambah()"><i
                                                                                    class="fa fa-plus"></i>
                                                                            </button>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                @php
                                                                    $total_meter += (float) $d->meter_hasil;
                                                                @endphp
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th colspan="4" class="text-right">Total</th>
                                                            <th><input type="text" class="form-control"
                                                                    id="meter_total" name="meter_total" readonly
                                                                    value="{{ Illuminate\Support\Number::format($total_meter) }}">
                                                            </th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nomor_sulzer">Nomor Sulzer</label>
                                                <input
                                                    type="text"class="form-control @error('nomor_sulzer') is-invalid @enderror"
                                                    id="nomor_sulzer" name="nomor_sulzer"
                                                    value="{{ $laporanbeaming->nomor_sulzer }}">
                                                @error('nomor_sulzer')
                                                    <span id="nomor_sulzer-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nomor_sulzer">Tanggal Sulzer</label>
                                                <div class="input-group date" id="div_tanggal_sulzer"
                                                    data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-inpsut"
                                                        data-target="#div_tanggal_sulzer" id="tanggal_sulzer"
                                                        name="tanggal_sulzer"
                                                        value="{{ old('tanggal_sulzer') ?? $laporanbeaming->tanggal_sulzer }}" />
                                                    <div class="input-group-append" data-target="#div_tanggal_sulzer"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('tanggal_sulzer')
                                                    <span id="tanggal_sulzer-error"
                                                        class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive p-0">
                                                <table id="table2" class="table projects table-bordered table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="text-center" style="width: 45%">
                                                                Panen Ke
                                                            </th>
                                                            <th scope="col" class="text-center" style="width: 50%">
                                                                Meter
                                                            </th>
                                                            <th style="width: 5%">

                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $total_panen = 0;
                                                        @endphp
                                                        @if ($laporanbeaming->laporanbeamingpanen->count() == 0)
                                                            <tr>
                                                                <td>
                                                                    <input type="number" class="form-control"
                                                                        id="panen_ke1" name="panen_ke[]"
                                                                        onblur="ubah_format('panen_ke1', this.value)"
                                                                        value="">
                                                                </td>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        id="meter1" name="meter[]"
                                                                        onblur="ubah_format('meter1', this.value); hitung_total_panen()"
                                                                        value="">
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-primary"
                                                                        onclick="tambah2()"><i
                                                                            class="fa fa-plus"></i></button>
                                                                </td>
                                                            </tr>
                                                        @else
                                                            @foreach ($laporanbeaming->laporanbeamingpanen as $d)
                                                                <tr>
                                                                    <td>
                                                                        <input type="number" class="form-control"
                                                                            id="panen_ke{{ $d->id }}"
                                                                            name="panen_ke[]"
                                                                            onblur="ubah_format('panen_ke{{ $d->id }}', this.value)"
                                                                            value="{{ $d->panen_ke }}">
                                                                    </td>
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                            id="meter{{ $d->id }}" name="meter[]"
                                                                            onblur="ubah_format('meter{{ $d->id }}', this.value); hitung_total_panen()"
                                                                            value="{{ Illuminate\Support\Number::format($d->meter) }}">
                                                                    </td>
                                                                    <td class="text-center">
                                                                        @if ($loop->first && $laporanbeaming->laporanbeamingpanen->count() > 1)
                                                                            <button type="button" class="btn btn-danger"
                                                                                id="hapus"><i class="fa fa-trash"></i>
                                                                            </button>
                                                                        @else
                                                                            <button type="button" class="btn btn-primary"
                                                                                onclick="tambah2()"><i
                                                                                    class="fa fa-plus"></i>
                                                                            </button>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                @php
                                                                    $total_panen += (float) $d->meter;
                                                                @endphp
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th class="text-right">Total</th>
                                                            <th>
                                                                <input type="text" class="form-control"
                                                                    id="panen_total" name="panen_total" readonly
                                                                    value="{{ Illuminate\Support\Number::format($total_panen) }}">
                                                            </th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="keterangan">Keterangan</label>
                                                <textarea class="form-control @error('keterangan') is-invalid @enderror" rows="10" id="keterangan"
                                                    name="keterangan">{!! $laporanbeaming->keterangan !!}</textarea>
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
                                        href="{{ route('produksiextruder.laporanbeaming.index') }}"><i
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
            $('#div_tanggal_detail1').datetimepicker({
                format: 'YYYY-MM-DD'
            });

            format_select2();
        });

        function format_select2() {
            $('.select-shift').select2({
                width: '100%',
                minimumResultsForSearch: -1,
            });

            $('.select-jenis-produksi').select2({
                width: '100%',
            });

            $('.select-mesin').select2({
                placeholder: "- Pilih Mesin -",
                allowClear: true,
                ajax: {
                    url: '{{ route('produksiextruder.laporanbeaming.get_mesin') }}',
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
            var meter_awal = numeral($("#meter_awal1").val()).format('0');
            var meter_akhir = numeral($("#meter_akhir1").val()).format('0');
            var meter_hasil = parseFloat(numeral(meter_akhir).format('0')) - parseFloat(numeral(meter_awal).format('0'));
            var tanggal_detail = $("#tanggal_detail1").val();
            var shift_detail = $("#shift_detail1 option:selected").val();
            $("#table1 > tbody > tr:last").before(`
                <tr>
                    <td>
                        <input type="date" class="form-control"
                            id="tanggal_detail${row_id}" name="tanggal_detail[]"
                            value="${tanggal_detail}" />
                    </td>
                    <td>
                        <select
                            class="form-control select2 w-100 select-shift @error('shift_detail') is-invalid @enderror"
                            id="shift_detail${row_id}" name="shift_detail[]">
                            <option value="Pagi" ${shift_detail === 'Pagi' ? 'selected' : ''}>Pagi</option>
                            <option value="Sore" ${shift_detail === 'Sore' ? 'selected' : ''}>Sore</option>
                            <option value="Malam" ${shift_detail === 'Malam' ? 'selected' : ''}>Malam</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control"
                            id="meter_awal${row_id}" name="meter_awal[]"
                            onblur="ubah_format('meter_awal${row_id}', this.value); hitung_hasil('${row_id}'); hitung_total_meter();" value="${numeral(meter_awal).format('0,0')}">
                    </td>
                    <td>
                        <input type="text" class="form-control"
                            id="meter_akhir${row_id}" name="meter_akhir[]"
                            onblur="ubah_format('meter_akhir${row_id}', this.value); hitung_hasil('${row_id}'); hitung_total_meter();" value="${numeral(meter_akhir).format('0,0')}">
                    </td>
                    <td>
                        <input type="text" class="form-control"
                            id="meter_hasil${row_id}" name="meter_hasil[]" readonly value="${numeral(meter_hasil).format('0,0')}">
                    </td>
                    <td class="text-center">
                         <button type="button" class="btn btn-danger"
                            id="hapus"><i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
            $("#tanggal_detail1").val("{{ date('Y-m-d') }}");
            $("#shift_detail1").val("Pagi").trigger('change');
            $("#meter_awal1").val("");
            $("#meter_akhir1").val("");
            $("#meter_hasil1").val("");

            format_select2();

            hitung_total_meter();
        }

        function tambah2() {
            var tbody_row = $('#table2').find('tr').length;
            var row_id = Date.now().toString(36) + Math.random().toString(36).substr(2);
            var panen_ke = numeral($("#panen_ke1").val()).format('0');
            var meter = numeral($("#meter1").val()).format('0');
            $("#table2 > tbody > tr:last").before(`
                <tr>
                    <td>
                        <input type="number" class="form-control"
                            id="panen_ke${row_id}" name="panen_ke[]"
                            onblur="ubah_format('meter_awal${row_id}', this.value);" value="${numeral(panen_ke).format('0,0')}">
                    </td>
                    <td>
                        <input type="text" class="form-control"
                            id="meter${row_id}" name="meter[]"
                            onblur="ubah_format('meter${row_id}', this.value); hitung_total_panen()" value="${numeral(meter).format('0,0')}">
                    </td>
                    <td class="text-center">
                         <button type="button" class="btn btn-danger"
                            id="hapus"><i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
            $("#panen_ke1").val("");
            $("#meter1").val("");

            hitung_total_panen();
        }

        $("#table1").on("click", "#hapus", function() {
            $(this).closest("tr").remove();
            hitung_total_meter();
        });

        $("#table2").on("click", "#hapus", function() {
            $(this).closest("tr").remove();
            hitung_total_panen();
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

        function hitung_hasil(field) {
            var meter_awal = numeral($("#meter_awal" + field).val()).format('0');
            var meter_akhir = numeral($("#meter_akhir" + field).val()).format('0');
            var meter_hasil = parseFloat(numeral(meter_akhir).format('0')) - parseFloat(numeral(meter_awal).format('0'));
            $("#meter_hasil" + field).val(numeral(meter_hasil).format('0,0'));
        }

        function hitung_total_meter() {
            var total = 0;
            $('#table1 tbody tr').each(function() {
                var meter_hasil = $(this).find('input[name="meter_hasil[]"]').val();
                if (meter_hasil) {
                    total += parseFloat(meter_hasil.replace(/,/g, ''));
                }
            });
            $("#meter_total").val(numeral(total).format('0,0'));
        }

        function hitung_total_panen() {
            var total = 0;
            $('#table2 tbody tr').each(function() {
                var meter = $(this).find('input[name="meter[]"]').val();
                if (meter) {
                    total += parseFloat(meter.replace(/,/g, ''));
                }
            });
            $("#panen_total").val(numeral(total).format('0,0'));
        }
    </script>
@endsection
