@php
    use Illuminate\Support\Number;
@endphp

<table>
    <tr>
        <td>
            <table>
                <tr>
                    <td>
                        PT. Abadi Nylon Rope & Fishing Net MFG<br>
                        Jl. Sukodono, Gedangan, Sidoarjo, Jawa Timur
                    </td>
                    <td>
                        <b>Laporan Produksi WJL </b>
                    </td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <td>
                        <table>
                            <tr>
                                <td>Tanggal</td>
                                <td>:</td>
                                <td>{{ \Carbon\Carbon::parse($tanggal_dari)->format('d/m/Y') }} -
                                    {{ \Carbon\Carbon::parse($tanggal_sampai)->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <td>Mesin</td>
                                <td>:</td>
                                <td>{{ $mesin->nama }}</td>
                            </tr>
                        </table>
                    </td>
                    <td>
                    </td>
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
                    <td>Operator</td>
                    <td>Meter Awal</td>
                    <td>Meter Akhir</td>
                    <td>Hasil</td>
                    <td>Keterangan</td>
                    <td>Lungsi</td>
                    <td>Pakan</td>
                    <td>Lubang</td>
                    <td>PGR</td>
                    <td>Lebar</td>
                    <td>Mesin</td>
                    <td>Teknisi</td>
                </tr>
                @foreach ($produksiwjl as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $d->shift }}</td>
                        <td>{{ $d->jenis_kain }}</td>
                        <td>{{ $d->operator }}</td>
                        <td>{{ Number::format((float) $d->meter_awal, precision: 1) }}
                        </td>
                        <td>{{ Number::format((float) $d->meter_akhir, precision: 1) }}
                        </td>
                        <td>{{ Number::format((float) $d->hasil, precision: 1) }}</td>
                        <td>{!! nl2br($d->keterangan) !!}</td>
                        <td>{{ Number::format((float) $d->lungsi, precision: 1) }}</td>
                        <td>{{ Number::format((float) $d->pakan, precision: 1) }}</td>
                        <td>{{ $d->lubang }}</td>
                        <td>{{ $d->pgr }}</td>
                        <td>{{ Number::format((float) $d->lebar, precision: 1) }}</td>
                        <td>{{ $d->mesin }}</td>
                        <td>{{ $d->teknisi }}</td>
                    </tr>
                @endforeach
            </table>
        </td>
    </tr>
</table>
