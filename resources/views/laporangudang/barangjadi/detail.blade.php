@php
    use Illuminate\Support\Number;
    use App\Models\Kartustok;
    use App\Models\Material;

    $material = Material::where('jenis', 'Barang Jadi')->where('bentuk', $bentuk)->orderBy('nama')->get();
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

<div>
    <center>
        <p>
        <h3>
            Laporan Stok Barang Jadi <br>
            PT. Abadi Nylon Gedangan <br>
            Per Tanggal : {{ $tanggal . ' ' . $bulan . ' ' . $tahun }}
        </h3>
        </p>
    </center>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th width="30">No.</th>
                    <th>Nama Barang</th>
                    <th>Ukuran</th>
                    <th>Stok</th>
                    <th>Satuan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
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
                            <input type="hidden" id="material_id" name="material_id[]" value="{{ $d->id }}">
                            <input type="hidden" id="satuan" name="satuan[]" value="{{ $d->satuan }}">
                            <input type="text" class="form-control" id="keterangan" name="keterangan[]">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
