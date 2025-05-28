@php
    use Illuminate\Support\Number;
    use App\Models\Kartustok;
    use App\Models\Material;
    use App\Models\Materialstok;
    use Illuminate\Support\Facades\DB;

    $date = date('Y-m-d');

    $bulan = Date('m', strtotime($date));
    $tahun = Date('Y', strtotime($date));
    $tanggal = Date('d', strtotime($date));

    if ($bulan == '01') {
        $bulan = 'Januari';
    } elseif ($bulan == '02') {
        $bulan = 'Februari';
    } elseif ($bulan == '03') {
        $bulan = 'Maret';
    } elseif ($bulan == '04') {
        $bulan = 'April';
    } elseif ($bulan == '05') {
        $bulan = 'Mei';
    } elseif ($bulan == '06') {
        $bulan = 'Juni';
    } elseif ($bulan == '07') {
        $bulan = 'Juli';
    } elseif ($bulan == '08') {
        $bulan = 'Agustus';
    } elseif ($bulan == '09') {
        $bulan = 'September';
    } elseif ($bulan == '10') {
        $bulan = 'Oktober';
    } elseif ($bulan == '11') {
        $bulan = 'November';
    } elseif ($bulan == '12') {
        $bulan = 'Desember';
    }
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

<body>
    <table class="table-main">
        <tr>
            <td>
                <table class="table-main">
                    <tr>
                        <td class="w-100 font-10 text-center">
                            Stock Beaming <br>
                            PT. Abadi Nylon Gedangan <br>
                            Per Tanggal {{ $tanggal . ' ' . $bulan . ' ' . $tahun }}
                        </td>
                    </tr>
                    <tr>
                        <td><br></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table class="table-main font-10 garis-bawah">
                    <tr class="header-table">
                        <td width="50px">No.</td>
                        <td>Beam Number</td>
                        <td>Jenis Produksi</td>
                        <td>Tanggal</td>
                        <td>Posisi</td>
                        <td>Hasil Panen</td>
                        <td>Sisa</td>
                        <td>Status</td>
                    </tr>
                    @foreach ($stockbeaming as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $d->laporanbeaming->beam_number }}</td>
                            <td>{{ $d->laporanbeaming->jenis_produksi }}</td>
                            <td>{{ $d->laporanbeaming->tanggal }}</td>
                            <td>{{ $d->posisi }}</td>
                            <td>{{ Number::format($d->meter_hasil) }}</td>
                            <td>
                                @php
                                    $sisa = 0;

                                    $stockbeamingdetail = DB::select(
                                        '
                                        select
                                            sum(cast(meter as float)) as meter
                                        from stockbemaingdetails
                                        where stockbeaming_id = ' .
                                            $d->id .
                                            '
                                        ',
                                    );
                                    $stockbeamingdetail = collect($stockbeamingdetail)->first();
                                    $sisa = $d->meter_hasil - $stockbeamingdetail->meter;
                                @endphp
                                {{ Number::format($sisa) }}</td>
                            <td>{{ $d->status }}</td>
                        </tr>
                    @endforeach
                </table>
            </td>
        </tr>
    </table>
</body>
