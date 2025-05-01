@php
    use Illuminate\Support\Number;
    use App\Models\Mesin;
    use App\Models\Pengeringankaindetail;
    $cek_status = 0;
    foreach ($pengeringankain as $d) {
        if ($d->status == 'Submit') {
            $cek_status = 1;
        }
    }
@endphp
<center>
    <p>Rekap Laporan Pengeringan Kain <br>
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
    <table id="table1" class="table projects table-bordered">
        <thead>
            <tr>
                <th width="25"></th>
                <th width="25">#</th>
                <th>Tanggal</th>
                <th>Shift</th>
                <th>Mesin</th>
                <th>Operator</th>
                <th>Meter</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengeringankaindetail as $d)
                @php
                    $mesin_id = $d->pengeringankain->produksiwjl->mesin_id;
                    $mesin = App\Models\Mesin::find($d->pengeringankain->produksiwjl->mesin_id);
                    $produksiwjl_id = $d->pengeringankain->produksiwjl_id;
                    $nama_mesin = $mesin->nama ?? '';
                    $jenis_kain = $d->pengeringankain->wjl_jenis_kain;
                    $pengeringankain_id = $d->pengeringankain_id;
                    $pengeringankain = App\Models\Pengeringankain::find($pengeringankain_id);
                    $produksiwjl_check = App\Models\Produksiwjl::where('mesin_id', $mesin_id)
                        ->where('id', '<=', $produksiwjl_id)
                        ->where('meter_awal', '0.0')
                        ->orderBy('id', 'desc')
                        ->first();
                @endphp
                @if ($produksiwjl_check)
                    @php
                        $tanggal = $produksiwjl_check->tanggal;
                        $produksiwjl = App\Models\Produksiwjl::where('mesin_id', $mesin_id)
                            ->where('id', '>=', $produksiwjl_check->id)
                            ->whereRaw('cast(meter_awal as decimal(16,2)) <= ' . (float) $d->meter)
                            ->whereRaw('cast(meter_akhir as decimal(16,2)) >= ' . (float) $d->meter)
                            ->first();
                        $shift = $produksiwjl->shift ?? '';
                        $operator = $produksiwjl->operator ?? '';
                        $tanggal = $produksiwjl->tanggal ?? '';
                    @endphp
                    <tr>
                        <td class="align-top">
                            {{ $d->id }}
                            @if ($d->pengeringankain->status == 'Confirmed')
                                <small class="badge badge-success"><i class="fa fa-check"></i></small>
                            @endif
                        </td>
                        <td class="align-top">
                            {{ $loop->iteration }}
                        </td>
                        <td class="align-top">{{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</td>
                        <td class="align-top">{{ $shift }}</td>
                        <td class="align-top">{{ $nama_mesin }}</td>
                        <td class="align-top">{{ $operator }}</td>
                        <td class="align-top">{{ $d->meter }}</td>
                        <td class="align-top">{{ $d->kerusakan }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
@if ($cek_status == 1)
    <div class="mt-2">
        <a type="button" class="btn btn-success m-1" id="button-export"
            href="{{ route('produksilaminating.rekap.konfirmasi', ['tanggal_dari' => $tanggal_dari, 'tanggal_sampai' => $tanggal_sampai, 'mesin_id' => $mesin_id]) }}"><i
                class="fa fa-check"></i>
            Konfirmasi Laporan Telah Diperiksa</a>
    </div>
@endif
