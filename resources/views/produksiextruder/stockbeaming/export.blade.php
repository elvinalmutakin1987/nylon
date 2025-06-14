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
                <tr>
                    <td colspan="6"><br></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td>No.</td>
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
