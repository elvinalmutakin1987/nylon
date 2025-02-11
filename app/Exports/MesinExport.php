<?php

namespace App\Exports;

use App\Models\Mesin;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MesinExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Mesin::select(
            'nama',
            DB::raw('(select nama from lokasis where id=mesins.lokasi_id) as lokasi'),
            'target_produksi',
            'keterangan'
        )->get(
            'nama',
            'lokasi',
            'keterangan'
        );
    }

    public function headings(): array
    {
        return [
            'nama',
            'lokasi',
            'target_produksi',
            'keterangan',
        ];
    }
}
