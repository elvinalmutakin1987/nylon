@php
    use Illuminate\Support\Number;
    use App\Models\Mesin;
    use App\Models\Produksiwjl;

    $produksiwjl = Produksiwjl::where('tanggal', '>=', $tanggal_dari)
        ->where('tanggal', '<=', $tanggal_sampai)
        ->where('operator', $operator)
        ->orderBy('mesin_id')
        ->orderBy('tanggal')
        ->get();
    $total_persen = 0;
@endphp
<style>
    .table-main {
        font-family: Arial, Helvetica, sans-serif;
        width: 100%;
        border-collapse: collapse;
    }

    .table-detail {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid;
    }

    .w-10 {
        width: 10%;
        vertical-align: top;
    }

    .w-20 {
        width: 20%;
        vertical-align: top;
    }

    .w-30 {
        width: 30%;
        vertical-align: top;
    }

    .w-40 {
        width: 40%;
        vertical-align: top;
    }

    .w-50 {
        width: 50%;
        vertical-align: top;
    }

    .w-60 {
        width: 60%;
        vertical-align: top;
    }

    .w-70 {
        width: 70%;
        vertical-align: top;
    }

    .w-80 {
        width: 80%;
        vertical-align: top;
    }

    .w-90 {
        width: 90%;
        vertical-align: top;
    }

    .w-100 {
        width: 100%;
        vertical-align: top;
    }

    .underline {
        text-decoration: underline;
    }

    .font-10 {
        font-size: 10pt !important;
    }

    .float-right {
        text-align: right;
    }

    .header-table {
        font-weight: bold;
        border-top: 1px solid;
        border-bottom: 1px solid;
    }

    .garis-bawah {
        border-bottom: 1px solid;
    }

    .garis {
        border: 1px solid;
        border-spacing: 5px;
    }

    .row-detail {
        border-bottom: 1px solid;
    }

    .tinggi-tr {
        height: 70px
    }

    .text-center {
        text-align: center
    }

    .v-align-top {
        vertical-align: top
    }

    .m-1 {
        margin: 5px
    }

    @media print {
        @page {
            size: A4 !important;
            margin: 15px !important;
        }

        .page {
            font-size: 12pt !important;
        }

        thead {
            display: table-header-group !important;
        }

        tfoot {
            display: table-footer-group !important;
        }

        button {
            display: none !important;
        }

        body {
            margin: 0 !important;
        }
    }
</style>
<table class="table-main">
    <tr style="margin-bottom: 100px">
        <td class="w-70 font-10">
            PT. Abadi Nylon Rope & Fishing Net MFG<br>
            Jl. Sukodono, Gedangan, Sidoarjo, Jawa Timur
        </td>
        <td class="w-30 float-right">
            <b class="underline">Laporan Efisisensi </b>
        </td>
    </tr>
    <tr>
        <td class="w-100" colspan="2">
            <table class="w-100 font-10">
                <tr>
                    <td width="150">Tanggal</td>
                    <td width="10">:</td>
                    <td>{{ \Carbon\Carbon::parse($tanggal_dari)->format('d/m/Y') }} -
                        {{ \Carbon\Carbon::parse($tanggal_sampai)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td width="150">Operator</td>
                    <td width="10">:</td>
                    <td>{{ $operator }}</td>
                </tr>
                <tr>
                    <td width="150">Rata-rata</td>
                    <td width="10">:</td>
                    <td>{{ Number::format($total_persen / $produksiwjl->count(), precision: 1) }} %</td>
                </tr>
            </table>
        </td>
    </tr>
    @if ($produksiwjl->count() > 1)
        <tr>
            <td colspan="2">
                @foreach ($produksiwjl->chunk(20) as $chunk)
                    <table class="table-main font-10 garis-bawah page">
                        <thead>
                            <tr class="header-table">
                                <td width="20px" class="garis">No.</td>
                                <td class="garis">Tanggal</td>
                                <td class="garis">Mesin</td>
                                <td class="garis">Shift</td>
                                <td class="garis">Jenis Kain</td>
                                <td class="garis">Hasil</td>
                                <td class="garis">Keterangan</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($chunk as $d)
                                @php
                                    $mesin_ = Mesin::find($d->mesin_id);
                                    $hasil = $d->meter_akhir - $d->meter_awal;
                                    $persen = ($hasil / $mesin_->target_produksi) * 100;
                                    $total_persen += $persen;
                                @endphp
                                <tr>
                                    <td class="v-align-top garis m-1">
                                        {{ $loop->parent->iteration * 20 - 20 + $loop->iteration }}</td>
                                    <td class="v-align-top garis m-1">
                                        {{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}</td>
                                    <td class="v-align-top garis m-1">{{ $mesin_->nama }}</td>
                                    <td class="v-align-top garis m-1">{{ $d->shift }}</td>
                                    <td class="v-align-top garis m-1">{{ $d->jenis_kain }}</td>
                                    <td class="v-align-top garis m-1">
                                        {{ Number::format((float) $persen, precision: 1) }} %
                                    </td>
                                    <td class="v-align-top garis m-1">{!! nl2br($d->keterangan) !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div style="page-break-after: always;"></div>
                @endforeach
            </td>
        </tr>
    @endif
</table>
