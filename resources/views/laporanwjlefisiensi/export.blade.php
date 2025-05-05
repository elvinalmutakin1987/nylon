@php
    use Illuminate\Support\Number;
    use App\Models\Mesin;
    use App\Models\Produksiwjl;
    $total_persen = 0;
@endphp

<table>
    <tr>
        <td>
            <table>
                <tr rowspan="3">
                    <td colspan="6">
                        Laporan Efisiensi
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        PT. Abadi Nylon Gedangan
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        {{ \Carbon\Carbon::parse($tanggal_dari)->format('d/m/Y') . ' s.d. ' . \Carbon\Carbon::parse($tanggal_dari)->format('d/m/Y') }}
                    </td>
                </tr>
                <tr>
                    <td colspan="6">Operator : {{ $operator }}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td>No.</td>
                    <td>Tanggal</td>
                    <td>Shift</td>
                    <td>Jenis Kain</td>
                    <td>Hasil</td>
                    <td>Keterangan</td>
                </tr>
                @foreach ($produksiwjl as $d)
                    @php
                        $mesin_ = Mesin::find($d->mesin_id);
                        $hasil = $d->meter_akhir - $d->meter_awal;
                        $persen = ($hasil / $mesin_->target_produksi) * 100;

                        $total_persen += $persen;
                    @endphp
                    <tr>
                        <td style="vertical-align: top">{{ $loop->iteration }}</td>
                        <td style="vertical-align: top">{{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}</td>
                        <td style="vertical-align: top">{{ $d->shift }}</td>
                        <td style="vertical-align: top">{{ $d->jenis_kain }}</td>
                        <td style="vertical-align: top">{{ Number::format((float) $persen, precision: 1) }} %</td>
                        <td style="vertical-align: top">{!! nl2br($d->keterangan) !!}</td>
                    </tr>
                @endforeach
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td>Rata-rata : {{ Number::format((float) $total_persen / $produksiwjl->count(), precision: 1) }} %
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>
