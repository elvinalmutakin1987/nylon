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
        <td>
            @php
                $grandtotal = 0;
            @endphp
            @foreach ($produksiwelding_tanggal as $tanggal)
                @php
                    $grandtotal_tanggal = 0;
                @endphp
                <br>
                {{ $tanggal->tanggal }}
                @foreach ($produksiwelding as $d)
                @endforeach
            @endforeach
        </td>
    </tr>
</table>
