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
                <th class="text-center" colspan="7">WJL</th>
                <th class="text-center" colspan="2">Kerusakan</th>
            </tr>
            <tr>
                <th width="25"></th>
                <th width="25">#</th>
                <th>Tanggal</th>
                <th>Shift</th>
                <th>Mesin</th>
                <th>Jenis Kain</th>
                <th>Operator</th>
                <th>Meter</th>
                <th>Keterangan</th>
                @if (auth()->user()->can('produksi.laminanting.edit'))
                    <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php
                $tanggal_old = '';
                $tanggal_new = '';
                $style = '';
            @endphp
            @foreach ($pengeringankain as $d)
                @php
                    $mesin_ = Mesin::find($d->mesin_id);
                    $tanggal_new = $d->wjl_tanggal;
                    if ($tanggal_new != $tanggal_old) {
                        if ($style == '') {
                            $style = "style=\"background-color: rgba(0,0,0,0.05)\"";
                        } else {
                            $style = '';
                        }
                    }
                    $count_pdetail = count(Pengeringankaindetail::where('pengeringankain_id', $d->id)->get());
                    $pengerindankaindetail = Pengeringankaindetail::where('pengeringankain_id', $d->id)->get();
                @endphp
                <tr {!! $style !!}>
                    <td class="align-top" rowspan="{{ $count_pdetail }}">
                        @if ($d->status == 'Confirmed')
                            <small class="badge badge-success"><i class="fa fa-check"></i></small>
                        @endif
                    </td>
                    <td class="align-top" rowspan="{{ $count_pdetail }}">
                        {{ $loop->iteration }}
                    </td>
                    <td class="align-top" rowspan="{{ $count_pdetail }}">
                        {{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}</td>
                    <td class="align-top" rowspan="{{ $count_pdetail }}">{{ $d->wjl_shift }}</td>
                    <td class="align-top" rowspan="{{ $count_pdetail }}">{{ $mesin_->nama }}</td>
                    <td class="align-top" rowspan="{{ $count_pdetail }}">{{ $d->wjl_jenis_kain }}</td>
                    <td class="align-top" rowspan="{{ $count_pdetail }}">{{ $d->wjl_operator }}</td>
                    @foreach ($pengerindankaindetail as $pd)
                        @if ($loop->first)
                            <td class="align-top">{{ $pd->meter }}</td>
                            <td class="align-top">{{ $pd->kerusakan }}</td>
                        @endif
                    @endforeach
                </tr>
                @foreach ($pengerindankaindetail as $pd)
                    @if (!$loop->first)
                        <tr {!! $style !!}>
                            <td class="align-top">{{ $pd->meter }}</td>
                            <td class="align-top">{{ $pd->kerusakan }}</td>
                        </tr>
                    @endif
                @endforeach
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
