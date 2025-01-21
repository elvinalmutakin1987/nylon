<?php

namespace App\Exports;

use App\Models\Lokasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LokasiExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Lokasi::select(
            'nama',
            'keterangan'
        )->get(
            'nama',
            'keterangan'
        );
    }

    public function headings(): array
    {
        return [
            'nama',
            'keterangan',
        ];
    }
}
