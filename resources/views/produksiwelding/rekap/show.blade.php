@php
    use Illuminate\Support\Number;
    use App\Models\Mesin;
@endphp
<center>
    <p>Rekap Produksi Welding <br>
        Tanggal : {{ \Carbon\Carbon::parse($tanggal_dari)->format('d/m/Y') }} -
        {{ \Carbon\Carbon::parse($tanggal_sampai)->format('d/m/Y') }}
    </p>
</center>
<div class="div" style="overflow-x: auto">
    @php
        $grandtotal = 0;
    @endphp
    @foreach ($produksiwelding_tanggal as $tanggal)
        @php
            $grandtotal_tanggal = 0;
        @endphp
        <br>
        <p style="font-weight: bold; font-size: 18px">{{ $tanggal->tanggal }}
        </p>
        @foreach ($produksiwelding as $d)
            @if ($d->tanggal == $tanggal->tanggal && $d->deleted_at == null)
                <p>{{ $d->operator }} -
                    {{ $d->shift }}
                </p>
                @if (auth()->user()->can('produksi.welding.edit'))
                    <a class="btn btn-default btn-sm mb-2" href="{{ route('produksiwelding.rekap.edit', $d->slug) }}">
                        <i class="fas fa-pencil-alt"></i> Edit</a>
                @endif
                <table id="table1" class="table table-sm projects table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Jenis</th>
                            <th class="text-center">Ukuran</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $grand_total = 0;
                        @endphp
                        @foreach ($d->produksiweldingdetail as $detail)
                            <tr>
                                <td class="text-center">{{ $detail->produksiwelding->tanggal }}</td>
                                <td class="text-center">{{ $detail->jenis }}</td>
                                <td class="text-center">
                                    {{ Number::format((float) $detail->ukuran1) }} X
                                    {{ Number::format((float) $detail->ukuran2) }}
                                </td>
                                <td class="text-center">{{ Number::format((float) $detail->jumlah) }}</td>
                                <td class="text-center">{{ Number::format((float) $detail->total) }}</td>
                            </tr>
                            @php
                                $grand_total += (float) $detail->total;
                                $grandtotal_tanggal += (float) $detail->total;
                                $grandtotal += (float) $detail->total;
                            @endphp
                        @endforeach
                        <tr>
                            <td class="text-right" colspan="4">Total</td>
                            <td class="text-center">{{ Number::format((float) $grand_total) }}</td>
                        </tr>
                    </tbody>
                </table>
            @endif
        @endforeach
        <p style="font-weight: bold; font-size: 20px">Total : {{ Number::format((float) $grandtotal_tanggal) }}
        </p>

        <hr>
    @endforeach
    <br>
    <p style="font-weight: bold; font-size: 25px">Grant Total : {{ Number::format((float) $grandtotal) }}
    </p>
</div>
