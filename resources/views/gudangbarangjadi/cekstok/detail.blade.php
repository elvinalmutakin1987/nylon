@php
    use Illuminate\Support\Number;
    use App\Models\Suratjalan;
    use App\Models\Barangmasuk;
    use App\Models\Barangkeluar;
@endphp

<table id="table1" class="table border table-sm table-striped projects">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Dokumen</th>
            <th>No. Dokumen</th>
            <th>Stok Awal</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Stok Akhir</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kartustok as $d)
            <tr>
                <td>{{ \Carbon\Carbon::parse($d->created_at)->format('Y-m-d') }}</td>
                <td>{{ $d->dokumen }}</td>
                <td>
                    @if ($d->dokumen == 'Surat Jalan')
                        @php
                            $suratjalan = Suratjalan::find($d->dokumen_id);
                        @endphp
                        {{ $suratjalan->no_dokumen }}
                    @elseif($d->dokumen == 'Barang Masuk')
                        @php
                            $barangmasuk = Barangmasuk::find($d->dokumen_id);
                        @endphp
                        {{ $barangmasuk->no_dokumen }}
                    @elseif($d->dokumen == 'Barang Keluar')
                        @php
                            $barangkeluar = Barangkeluar::find($d->dokumen_id);
                        @endphp
                        {{ $barangkeluar->no_dokumen }}
                    @endif
                </td>
                <td>{{ Number::format($d->stok_awal, precision: 1) }}</td>
                <td>{{ Number::format($d->masuk, precision: 1) }}</td>
                <td>{{ Number::format($d->keluar, precision: 1) }}</td>
                <td>{{ Number::format($d->stok_akhir, precision: 1) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
