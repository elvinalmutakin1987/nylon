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

    .row-detail {
        border-bottom: 1px solid;
    }

    .tinggi-tr {
        height: 70px
    }

    .text-center {
        text-align: center
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
                        <b class="underline">Barang Keluar </b><br>
                        No: {{ $barangkeluar->no_dokumen }}
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
                                <td>{{ \Carbon\Carbon::parse($barangkeluar->tanggal)->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td width="150">No. Permintaan Material</td>
                                <td width="10">:</td>
                                <td>{{ $barangkeluar->permintaanmaterial->no_dokumen ?? '' }}</td>
                            </tr>
                            <tr>
                                <td width="150">Gudang</td>
                                <td width="10">:</td>
                                <td>Avalan</td>
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
                    <td width="50px">No.</td>
                    <td style="width: 40%">Barang</td>
                    <td style="width: 10%">Satuan</td>
                    <td style="width: 15%">Jumlah</td>
                    <td>Keterangan</td>
                </tr>
                @foreach ($barangkeluar->barangkeluardetail as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->material->nama }}</td>
                        <td>{{ $d->satuan }}</td>
                        <td>{{ Number::format((float) $d->jumlah, precision: 1) }}</td>
                        <td>{{ $d->keterangan }}</td>
                    </tr>
                @endforeach
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table class="table-main">
                <tr>
                    <td class="w-50 font-10">
                        Catatan : <br>
                        {{ $barangkeluar->catatan }}
                    </td>
                    <td class="w-50 font-10">
                        <table class="table-detail">
                            <tr class="table-detail">
                                <td width="30%" class="table-detail text-center">Diterima Oleh</td>
                                <td width="30%" class="table-detail text-center">Diserahkan Oleh</td>
                                <td width="30%" class="table-detail text-center">Diketahui Oleh</td>
                            </tr>
                            <tr class="table-detail">
                                <td class="table-detail tinggi-tr"></td>
                                <td class="table-detail tinggi-tr"></td>
                                <td class="table-detail tinggi-tr"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
