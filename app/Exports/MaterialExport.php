<?php

namespace App\Exports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MaterialExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Material::select(
            'kode',
            'nama',
            'group',
            'jenis'
        )->get(
            'kode',
            'nama',
            'group',
            'jenis'
        );
    }

    public function headings(): array
    {
        return [
            'kode',
            'nama',
            'group',
            'jenis'
        ];
    }
}
