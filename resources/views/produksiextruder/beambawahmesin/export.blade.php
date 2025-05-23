@php
    use Illuminate\Support\Number;
    use App\Models\Kartustok;
    use App\Models\Material;
    use App\Models\Materialstok;

    $bulan = Date('m');
    $tahun = Date('Y');
    $tanggal = Date('d');

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
                        Laporan Beam Bawah Mesin
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
                    <td width="50px">No.</td>
                    <td>Tanggal</td>
                    <td>Beam Number</td>
                    <td>Jenis Produksi</td>
                    <td>Rajutan Lusi</td>
                    <td>Lebar Kain</td>
                    <td>Jumlah Benang</td>
                    <td>Lebar Benang</td>
                    <td>Denier</td>
                    <td>Beam Isi</td>
                    <td>Beam Sisa</td>
                    <td>Berat</td>
                </tr>
                @foreach ($beambawahmesin as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->tanggal }}</td>
                        <td>{{ $d->beam_number }}</td>
                        <td>{{ $d->jenis_produksi }}</td>
                        <td>{{ $d->rajutan_lusi }}</td>
                        <td>{{ $d->lebar_kain }}</td>
                        <td>{{ Illuminate\Support\Number::format($d->jumlah_benang) }}</td>
                        <td>{{ $d->lebar_benang }}</td>
                        <td>{{ $d->denier }}</td>
                        <td>{{ $d->beam_isi }}</td>
                        <td>{{ Illuminate\Support\Number::format($d->beam_sisa) }}</td>
                        <td>{{ $d->berat }}</td>
                    </tr>
                @endforeach
            </table>
        </td>
    </tr>
</table>
