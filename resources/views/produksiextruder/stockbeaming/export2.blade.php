@php
    use Illuminate\Support\Number;
    use App\Models\Kartustok;
    use App\Models\Material;
    use App\Models\Materialstok;

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

<table>
    <tr>
        <td>
            <table>
                <tr rowspan="3">
                    <td colspan="6">
                        Laporan Stock Beaming
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        PT. Abadi Nylon Gedangan
                    </td>
                </tr>
                <tr>
                    <td colspan="6">Per Tanggal {{ $tanggal . ' ' . $bulan . ' ' . $tahun }}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table class="table-main">
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ $stockbeaming->laporanbeaming->tanggal }}</td>
                </tr>
                <tr>
                    <td>Beam Number</td>
                    <td>: {{ $stockbeaming->laporanbeaming->beam_number }}</td>
                </tr>
                <tr>
                    <td>Jenis Produksi</td>
                    <td>:
                        {{ $stockbeaming->laporanbeaming->jenis_produksi }}
                    </td>
                </tr>
                <tr>
                    <td>Meter Hasil</td>
                    <td>:
                        {{ Number::format($stockbeaming->meter_hasil) }}
                    </td>
                </tr>
                <tr>
                    <td>Posisi</td>
                    <td>: {{ $stockbeaming->posisi }}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td>No.</td>
                    <td>Tanggal</td>
                    <td>Shift</td>
                    <td>Posisi</td>
                    <td>Operator</td>
                    <td>Meter</td>
                    <td>Keterangan</td>
                </tr>
                @php
                    $meter_hasil = 0;
                @endphp
                @foreach ($stockbeaming->stockbeamingdetail as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->tanggal }}</td>
                        <td>{{ $d->shift }}</td>
                        <td>{{ $d->posisi }}</td>
                        <td>{{ $d->operator }}</td>
                        <td>{{ Number::format($d->meter) }}</td>
                        <td>{!! $d->keterangan !!}</td>
                    </tr>
                    @php
                        $meter_hasil += (float) $d->meter;
                    @endphp
                @endforeach
                <tr>
                    <td colspan="5" style="text-align: right">Total &nbsp;&nbsp;&nbsp;</td>
                    <td>{{ Number::format($meter_hasil) }}</td>
                    <td></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
