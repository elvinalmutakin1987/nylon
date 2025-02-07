@php
    use Illuminate\Support\Number;
    use App\Models\Mesin;

    $mesin = Mesin::find($mesin_id);
@endphp
<center>
    <p>Rekap Laporan Produksi WJL <br>
        Tanggal : {{ \Carbon\Carbon::parse($tanggal_dari)->format('d/m/Y') }} -
        {{ \Carbon\Carbon::parse($tanggal_sampai)->format('d/m/Y') }}
        <br>
        Mesin : {{ $mesin->nama }}
    </p>
</center>
<div class="div" style="overflow-x: auto">
    <table id="table1" class="table projects">
        <thead>
            <tr>
                <th class="30">#</th>
                <th>Tanggal</th>
                <th>Shift</th>
                <th>Jenis Kain</th>
                <th>Operator</th>
                <th>Meter Awal</th>
                <th>Meter Akhir</th>
                <th>Hasil</th>
                <th>Keterangan</th>
                <th>Lungsi</th>
                <th>Pakan</th>
                <th>Lubang</th>
                <th>PGR</th>
                <th>Lebar</th>
                <th>Mesin</th>
                <th>Teknisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produksiwjl as $d)
                <tr>
                    <td class="align-top">{{ $loop->iteration }}</td>
                    <td class="align-top">{{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}</td>
                    <td class="align-top">{{ $d->shift }}</td>
                    <td class="align-top">{{ $d->jenis_kain }}</td>
                    <td class="align-top">{{ $d->operator }}</td>
                    <td class="align-top">{{ Number::format((float) $d->meter_awal, precision: 1) }}</td>
                    <td class="align-top">{{ Number::format((float) $d->meter_akhir, precision: 1) }}</td>
                    <td class="align-top">{{ Number::format((float) $d->hasil, precision: 1) }}</td>
                    <td class="align-top">{!! nl2br($d->keterangan) !!}</td>
                    <td class="align-top">{{ Number::format((float) $d->lungsi, precision: 1) }}</td>
                    <td class="align-top">{{ Number::format((float) $d->pakan, precision: 1) }}</td>
                    <td class="align-top">{{ $d->lubang }}</td>
                    <td class="align-top">{{ $d->pgr }}</td>
                    <td class="align-top">{{ Number::format((float) $d->lebar, precision: 1) }}</td>
                    <td class="align-top">{{ $d->mesin }}</td>
                    <td class="align-top">{{ $d->teknisi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
