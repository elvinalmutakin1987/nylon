@php
    use Illuminate\Support\Number;
    use App\Models\Mesin;
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
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Serah Terima Laporan Beaming</h3>
                            </div>
                            <div class="card-body">
                                @if ($laporanbeaming_sebelumnya)
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <label for="tanggal">Tanggal</label>
                                                    <input type="text"
                                                        class="form-control @error('tanggal') is-invalid @enderror"
                                                        id="tanggal" name="tanggal"
                                                        value="{{ old('tanggal') ?? $laporanbeaming_sebelumnya->tanggal }}"
                                                        readonly>
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
                                                    value="{{ old('beam_number') ?? $laporanbeaming_sebelumnya->beam_number }}"
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
                                                    value="{{ old('jenis_produksi') ?? $laporanbeaming_sebelumnya->jenis_produksi }}"
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
                                                        id="nomor" name="nomor"
                                                        value="{{ $laporanbeaming_sebelumnya->nomor }}" readonly>
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
                                                <input type="text"
                                                    class="form-control @error('jenis_bahan') is-invalid @enderror"
                                                    id="jenis_bahan" name="jenis_bahan"
                                                    value="{{ $laporanbeaming_sebelumnya->jenis_bahan }}" readonly>
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
                                                    id="denier" name="denier"
                                                    value="{{ $laporanbeaming_sebelumnya->denier }}" readonly>
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
                                                    value="{{ $laporanbeaming_sebelumnya->lebar_benang }}" readonly>
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
                                                    value="{{ $laporanbeaming_sebelumnya->warna_benang }}" readonly>
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
                                                    value="{{ $laporanbeaming_sebelumnya->jumlah_lungsi }}" readonly>
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
                                                    value="{{ $laporanbeaming_sebelumnya->lebar_beam }}" readonly>
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
                                                    value="{{ $laporanbeaming_sebelumnya->front_reed }}" readonly>
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
                                                    value="{{ $laporanbeaming_sebelumnya->rear_read }}" readonly>
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
                                                    value="{{ $laporanbeaming_sebelumnya->traverse_reed }}" readonly>
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
                                                    value="{{ $laporanbeaming_sebelumnya->benang_pinggiran_kiri }}"
                                                    readonly>
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
                                                    value="{{ $laporanbeaming_sebelumnya->benang_pinggiran_kanan }}"
                                                    readonly>
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
                                                    value="{{ $laporanbeaming_sebelumnya->benang_pinggiran_benang }}"
                                                    readonly>
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
                                                    value="{{ $laporanbeaming_sebelumnya->lebar_traverse }}" readonly>
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
                                                    value="{{ $laporanbeaming_sebelumnya->kecepatan_traverse }}" readonly>
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
                                                    value="{{ $laporanbeaming_sebelumnya->kecepatan_beaming }}" readonly>
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
                                                    value="{{ $laporanbeaming_sebelumnya->cut_mark }}" readonly>
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
                                                    value="{{ $laporanbeaming_sebelumnya->panjang_press_roller }}"
                                                    readonly>
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
                                                    value="{{ $laporanbeaming_sebelumnya->tekanan_press_roller }}"
                                                    readonly>
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
                                                    value="{{ $laporanbeaming_sebelumnya->tension_roller_no_1 }}"
                                                    readonly>
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
                                                    value="{{ $laporanbeaming_sebelumnya->tension_roller_no_2 }}"
                                                    readonly>
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
                                                    value="{{ $laporanbeaming_sebelumnya->traverse_reed_design }}"
                                                    readonly>
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
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $total_meter = 0;
                                                        @endphp
                                                        @foreach ($laporanbeaming_sebelumnya->laporanbeamingdetail as $d)
                                                            <tr>
                                                                <td>
                                                                    {{ $d->tanggal }}
                                                                </td>
                                                                <td>
                                                                    {{ $d->shift }}
                                                                </td>
                                                                <td>
                                                                    {{ Illuminate\Support\Number::format((float) $d->meter_awal) }}
                                                                </td>
                                                                <td>
                                                                    {{ Illuminate\Support\Number::format((float) $d->meter_akhir) }}
                                                                </td>
                                                                <td>
                                                                    {{ Illuminate\Support\Number::format((float) $d->meter_hasil) }}
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $total_meter += (float) $d->meter_hasil;
                                                            @endphp
                                                        @endforeach

                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th colspan="4" class="text-right">Total</th>
                                                            <th>{{ Illuminate\Support\Number::format($total_meter) }}
                                                            </th>
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
                                                    value="{{ $laporanbeaming_sebelumnya->nomor_sulzer }}" readonly>
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
                                                        value="{{ $laporanbeaming_sebelumnya->tanggal_sulzer }}"
                                                        readonly />
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
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $total_panen = 0;
                                                        @endphp
                                                        @foreach ($laporanbeaming_sebelumnya->laporanbeamingpanen as $d)
                                                            <tr>
                                                                <td>
                                                                    {{ $d->panen_ke }}
                                                                </td>
                                                                <td>
                                                                    {{ Illuminate\Support\Number::format($d->meter) }}
                                                                </td>
                                                            </tr>
                                                            @php
                                                                $total_panen += (float) $d->meter;
                                                            @endphp
                                                        @endforeach
                                                    </tbody>
                                                    <thead>
                                                        <tr>
                                                            <th class="text-right">Total</th>
                                                            <th>
                                                                {{ Illuminate\Support\Number::format($total_panen) }}
                                                            </th>
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
                                                    name="keterangan" readonly>{!! $laporanbeaming_sebelumnya->keterangan !!}</textarea>
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
                                                    href="{{ route('produksiextruder.laporanbeaming.create_laporan', ['tanggal' => $tanggal, 'beam_number' => $beam_number, 'jenis_produksi' => $jenis_produksi]) }}"><i
                                                        class="fa fa-forward"></i>
                                                    Lanjutkan Buat Laporan</a>
                                            @else
                                                <a type="button" class="btn btn-success"
                                                    href="{{ route('produksiextruder.laporanbeaming.edit', $laporanbeaming->slug) }}"><i
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
                                                    href="{{ route('produksiextruder.laporanbeaming.create_laporan', ['tanggal' => $tanggal, 'beam_number' => $beam_number, 'jenis_produksi' => $jenis_produksi]) }}"><i
                                                        class="fa fa-forward"></i>
                                                    Lanjutkan Buat Laporan</a>
                                            @else
                                                <a type="button" class="btn btn-success"
                                                    href="{{ route('produksiextruder.laporanbeaming.edit', $laporanbeaming->slug) }}"><i
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
                                    href="{{ route('produksiextruder.laporanbeaming.index') }}"><i
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
            var mynumeral = numeral(nilai).format('0,0.0');
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

        function hitung_hasil() {
            var meter_awal = numeral($("#meter_awal").val()).format('0,0.0');
            var meter_akhir = numeral($("#meter_akhir").val()).format('0,0.0');
            var hasil = parseFloat(meter_akhir) - parseFloat(meter_awal);
            $("#hasil").val(numeral(hasil).format('0,0.0'));
        }
    </script>
@endsection
