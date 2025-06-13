@php
    use Illuminate\Support\Number;
    use App\Models\Mesin;
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
                        <b class="underline">Laporan Produksi Welding </b>
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
                        </table>
                    </td>
                    <td class="w-30">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="font-10">
            @php
                $grandtotal = 0;
            @endphp
            @foreach ($produksiwelding_tanggal as $tanggal)
                @php
                    $grandtotal_tanggal = 0;
                @endphp
                <br>
                <br>
                {{ $tanggal->tanggal }}
                <br>
                @foreach ($produksiwelding as $d)
                    @if ($d->tanggal == $tanggal->tanggal && $d->deleted_at == null)
                        {{ $d->operator }} <br>
                        <table class="table-main font-10 garis-bawah">
                            <thead>
                                <tr>
                                    <th class="garis">Tanggal</th>
                                    <th class="garis">Jenis</th>
                                    <th class="garis">Ukuran</th>
                                    <th class="garis">Jumlah</th>
                                    <th class="garis">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $grand_total = 0;
                                @endphp
                                @foreach ($d->produksiweldingdetail as $detail)
                                    <tr>
                                        <td class="v-align-top garis m-1 text-center">
                                            {{ $detail->produksiwelding->tanggal }}</td>
                                        <td class="v-align-top garis m-1 text-center">
                                            {{ $detail->jenis }}</td>
                                        <td class="v-align-top garis m-1 text-center">
                                            {{ Number::format((float) $detail->ukuran1) }} X
                                            {{ Number::format((float) $detail->ukuran2) }}
                                        </td>
                                        <td class="v-align-top garis m-1 text-center">
                                            {{ Number::format((float) $detail->jumlah) }}
                                        </td>
                                        <td class="v-align-top garis m-1 text-center">
                                            {{ Number::format((float) $detail->total) }}
                                        </td>
                                    </tr>
                                    @php
                                        $grand_total += (float) $detail->total;
                                        $grandtotal_tanggal += (float) $detail->total;
                                        $grandtotal += (float) $detail->total;
                                    @endphp
                                @endforeach
                                <tr>
                                    <td class="v-align-top garis m-1 text-right" colspan="4">Total
                                    </td>
                                    <td class="v-align-top garis m-1 text-center">
                                        {{ Number::format((float) $grand_total) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                    @endif
                @endforeach
                Total : {{ Number::format((float) $grandtotal_tanggal) }}
            @endforeach
        </td>
    </tr>
    <tr>
        <td>
            <br>
            <p>Grant Total : {{ Number::format((float) $grandtotal) }}
            </p>
        </td>
    </tr>
</table>
