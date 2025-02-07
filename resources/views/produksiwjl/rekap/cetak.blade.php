@php
    use Illuminate\Support\Number;
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
    <tr>
        <td>
            <table class="table-main">
                <tr>
                    <td class="w-70 font-10">
                        PT. Abadi Nylon Rope & Fishing Net MFG<br>
                        Jl. Sukodono, Gedangan, Sidoarjo, Jawa Timur
                    </td>
                    <td class="w-30 float-right">
                        <b class="underline">Laporan Produksi WJL </b>
                    </td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <td class="w-70">
                        <table class="w-100 font-10">
                            <tr>
                                <td width="150">Tanggal</td>
                                <td width="10">:</td>
                                <td>{{ \Carbon\Carbon::parse($tanggal_dari)->format('d/m/Y') }} -
                                    {{ \Carbon\Carbon::parse($tanggal_sampai)->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td width="150">Mesin</td>
                                <td width="10">:</td>
                                <td>{{ $mesin->nama }}</td>
                            </tr>
                        </table>
                    </td>
                    <td class="w-30">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table class="table-main font-10 garis-bawah">
                <tr class="header-table">
                    <td width="20px" class="garis">No.</td>
                    <td class="garis">Tanggal</td>
                    <td class="garis">Shift</td>
                    <td class="garis">Jenis Kain</td>
                    <td class="garis">Operator</td>
                    <td class="garis">Meter Awal</td>
                    <td class="garis">Meter Akhir</td>
                    <td class="garis">Hasil</td>
                    <td class="garis">Keterangan</td>
                    <td class="garis">Lungsi</td>
                    <td class="garis">Pakan</td>
                    <td class="garis">Lubang</td>
                    <td class="garis">PGR</td>
                    <td class="garis">Lebar</td>
                    <td class="garis">Mesin</td>
                    <td class="garis">Teknisi</td>
                </tr>
                @foreach ($produksiwjl as $d)
                    <tr>
                        <td class="v-align-top garis m-1">{{ $loop->iteration }}</td>
                        <td class="v-align-top garis m-1">{{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}</td>
                        <td class="v-align-top garis m-1">{{ $d->shift }}</td>
                        <td class="v-align-top garis m-1">{{ $d->jenis_kain }}</td>
                        <td class="v-align-top garis m-1">{{ $d->operator }}</td>
                        <td class="v-align-top garis m-1">{{ Number::format((float) $d->meter_awal, precision: 1) }}
                        </td>
                        <td class="v-align-top garis m-1">{{ Number::format((float) $d->meter_akhir, precision: 1) }}
                        </td>
                        <td class="v-align-top garis m-1">{{ Number::format((float) $d->hasil, precision: 1) }}</td>
                        <td class="v-align-top garis m-1">{!! nl2br($d->keterangan) !!}</td>
                        <td class="v-align-top garis m-1">{{ Number::format((float) $d->lungsi, precision: 1) }}</td>
                        <td class="v-align-top garis m-1">{{ Number::format((float) $d->pakan, precision: 1) }}</td>
                        <td class="v-align-top garis m-1">{{ $d->lubang }}</td>
                        <td class="v-align-top garis m-1">{{ $d->pgr }}</td>
                        <td class="v-align-top garis m-1">{{ Number::format((float) $d->lebar, precision: 1) }}</td>
                        <td class="v-align-top garis m-1">{{ $d->mesin }}</td>
                        <td class="v-align-top garis m-1">{{ $d->teknisi }}</td>
                    </tr>
                @endforeach
            </table>
        </td>
    </tr>
</table>
