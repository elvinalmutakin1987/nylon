<?php

namespace App\Exports;

use App\Models\Varian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VarianExport implements FromCollection, WithHeadings
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
