@php
    use Illuminate\Support\Number;
    use App\Models\Kartustok;
    use App\Models\Material;
    use App\Models\Materialstok;

    $material = Material::where('jenis', 'Barang Jadi')->where('bentuk', 'Roll')->orderBy('nama')->get();

    $date = $tanggal;

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
                        Laporan Barang
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
                    <td style="width: 30px">No.</td>
                    <td style="width: 400px">Barang</td>
                    <td style="width: 100px">Ukuran</td>
                    <td style="width: 75px">Stok</td>
                    <td style="width: 75px">Satuan</td>
                    <td style="width: 200px">Keterangan</td>
                </tr>
                @foreach ($material as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->nama }}</td>
                        <td>{{ $d->ukuran }}</td>
                        <td>
                            @php
                                $kartustok = Kartustok::where('material_id', $d->id)
                                    ->where('gudang', 'Gudang Barang Jadi')
                                    ->whereDate('created_at', '<=', $date)
                                    ->orderBy('id', 'desc')
                                    ->first();
                            @endphp
                            {{ $kartustok ? Number::format((float) $kartustok->stok_akhir, precision: 1) : '-' }}
                        </td>
                        <td>
                            {{ $kartustok ? $kartustok->satuan : '' }}
                        </td>
                        <td>
                            @php
                                $materialstok = Materialstok::where('material_id', $d->id)->first();
                            @endphp
                            {{ $materialstok->keterangan ?? '' }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </td>
    </tr>
</table>
