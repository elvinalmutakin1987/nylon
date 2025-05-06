@php
    use Illuminate\Support\Number;
    use App\Models\Produksiwjl;
    use App\Models\Mesin;

    $produksiwjl = Produksiwjl::where('tanggal', '>=', $tanggal_dari)
        ->where('tanggal', '<=', $tanggal_sampai)
        ->where('operator', $operator)
        ->orderBy('mesin_id')
        ->orderBy('tanggal')
        ->get();
    $total_persen = 0;
@endphp

<div>
    <center>
        <p>
        <h3>
            Laporan Efisiensi Operator <br>
            PT. Abadi Nylon Gedangan <br>
            {{ \Carbon\Carbon::parse($tanggal_dari)->format('d/M/Y') . ' s.d. ' . \Carbon\Carbon::parse($tanggal_sampai)->format('d/M/Y') }}
            <br>
            Operator : {{ $operator }}
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
                    <th>Tanggal</th>
                    <th>Shift</th>
                    <th>Mesin</th>
                    <th>Jenis Kain</th>
                    <th>Hasil</th>
                    <th>Persentase</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produksiwjl as $d)
                    @php
                        $mesin = Mesin::find($d->mesin_id);
                        $hasil = $d->meter_akhir - $d->meter_awal;
                        $persen = $mesin->target_produksi != 0 ? ($hasil / $mesin->target_produksi) * 100 : 0;
                        $style = '';
                        if ($persen < '75') {
                            $style = "style=\"background-color: red; color:white\"";
                        }
                        $total_persen += $persen;
                    @endphp
                    <tr {!! $style !!}>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->tanggal }}</td>
                        <td>{{ $d->shift }}</td>
                        <td>{{ $mesin->nama }}</td>
                        <td>{{ $d->jenis_kain }}</td>
                        <td>{{ $hasil }}</td>
                        <td>{{ Number::format((float) $persen, precision: 1) }} %</td>
                        <td>{{ $d->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if ($produksiwjl->count() > 1)
        <div class="col-md-12">
            @if ($total_persen / $produksiwjl->count() < 75)
                <h1>
                    <small class="badge badge-danger">Rata-rata :
                        {{ Number::format((float) $total_persen / $produksiwjl->count(), precision: 1) }} %</small>
                </h1>
            @else
                <h1>
                    Rata-rata : {{ Number::format((float) $total_persen / $produksiwjl->count(), precision: 1) }} %
                </h1>
            @endif
        </div>
    @endif
</div>
