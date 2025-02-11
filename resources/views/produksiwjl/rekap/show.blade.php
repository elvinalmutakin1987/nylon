@php
    use Illuminate\Support\Number;
    use App\Models\Mesin;
    $cek_status = 0;
    foreach ($produksiwjl as $d) {
        if ($d->status == 'Submit') {
            $cek_status = 1;
        }
    }
@endphp
<center>
    <p>Rekap Laporan Produksi WJL <br>
        Tanggal : {{ \Carbon\Carbon::parse($tanggal_dari)->format('d/m/Y') }} -
        {{ \Carbon\Carbon::parse($tanggal_sampai)->format('d/m/Y') }}
        <br>
        @if ($mesin_id != '' && $mesin_id != 'null')
            @php $mesin = Mesin::find($mesin_id); @endphp
            Mesin : {{ $mesin->nama }}
        @endif
    </p>
</center>
<div class="div" style="overflow-x: auto">
    <table id="table1" class="table projects">
        <thead>
            <tr>
                <th width="25"></th>
                <th width="25">#</th>
                <th>Tanggal</th>
                <th>Mesin</th>
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
                <th>Dibuat Pada</th>
                <th>Dikonfirmasi Pada</th>
                @if (auth()->user()->can('produksi.wjl.edit'))
                    <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($produksiwjl as $d)
                @php
                    $mesin_ = Mesin::find($d->mesin_id);
                    $hasil = $d->meter_akhir - $d->meter_awal;
                    $persen = ($hasil / $mesin_->target_produksi) * 100;
                @endphp
                <tr>
                    <td class="align-top">
                        @if ($d->status == 'Confirmed')
                            <small class="badge badge-success"><i class="fa fa-check"></i></small>
                        @endif
                    </td>
                    <td class="align-top">
                        {{ $loop->iteration }}
                    </td>
                    <td class="align-top">{{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}</td>
                    <td class="align-top">{{ $mesin_->nama }}</td>
                    <td class="align-top">
                        @if ($persen < '75')
                            <small class="badge badge-danger">{{ $d->shift }}</small>
                        @else
                            {{ $d->shift }}
                        @endif
                    </td>
                    <td class="align-top">{{ $d->jenis_kain }}</td>
                    <td class="align-top">{{ $d->operator }}</td>
                    <td class="align-top">{{ Number::format((float) $d->meter_awal, precision: 1) }}</td>
                    <td class="align-top">{{ Number::format((float) $d->meter_akhir, precision: 1) }}</td>
                    <td class="align-top">
                        @if ($persen < '75')
                            <small
                                class="badge badge-danger">{{ Number::format((float) $hasil, precision: 1) }}</small>
                        @else
                            {{ Number::format((float) $hasil, precision: 1) }}
                        @endif
                        <br>
                        <br>
                        {{ Number::format((float) $persen) }}%
                    </td>
                    <td class="align-top">{!! nl2br($d->keterangan) !!}</td>
                    <td class="align-top">{{ Number::format((float) $d->lungsi, precision: 1) }}</td>
                    <td class="align-top">{{ Number::format((float) $d->pakan, precision: 1) }}</td>
                    <td class="align-top">{{ $d->lubang }}</td>
                    <td class="align-top">{{ $d->pgr }}</td>
                    <td class="align-top">{{ Number::format((float) $d->lebar, precision: 1) }}</td>
                    <td class="align-top">{{ $d->mesin }}</td>
                    <td class="align-top">{{ $d->teknisi }}</td>
                    <td class="align-top">
                        {{ $d->created_at }}
                    </td>
                    <td class="align-top">
                        {{ $d->confirmed_at }}
                    </td>
                    @if (auth()->user()->can('produksi.wjl.edit'))
                        <td class="align-top">
                            <a class="btn btn-default" href="{{ route('produksiwjl.rekap.edit', $d->slug) }}"> <i
                                    class="fas fa-pencil-alt"></i> Edit</a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@if ($cek_status == 1)
    <div class="mt-2">
        <a type="button" class="btn btn-success m-1" id="button-export"
            href="{{ route('produksiwjl.rekap.konfirmasi', ['tanggal_dari' => $tanggal_dari, 'tanggal_sampai' => $tanggal_sampai, 'mesin_id' => $mesin_id]) }}"><i
                class="fa fa-check"></i>
            Konfirmasi Laporan Telah Diperiksa</a>
    </div>
@endif
