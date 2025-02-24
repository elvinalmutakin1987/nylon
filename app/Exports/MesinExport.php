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
            // 'bagian',
            DB::raw('(select nama from lokasis where id=mesins.lokasi_id) as lokasi'),
            'target_produksi',
            'keterangan',
            // 'b_plus_top',
            // 'b_plus_bottom',
            // 'b_top',
            // 'b_bottom',
            // 'n_top',
            // 'n_bottom',
            // 'k_top',
            // 'k_bottom',
            // 'k_min_top',
            // 'k_min_bottom',
        )->get(
            'nama',
            // 'bagian',
            'lokasi',
            'target_produksi',
            'keterangan',
            // 'b_plus_top',
            // 'b_plus_bottom',
            // 'b_top',
            // 'b_bottom',
            // 'n_top',
            // 'n_bottom',
            // 'k_top',
            // 'k_bottom',
            // 'k_min_top',
            // 'k_min_bottom',
        );
    }

    public function headings(): array
    {
        return [
            'nama',
            // 'bagian',
            'lokasi',
            'target_produksi',
            'keterangan',
            // 'b_plus_top',
            // 'b_plus_bottom',
            // 'b_top',
            // 'b_bottom',
            // 'n_top',
            // 'n_bottom',
            // 'k_top',
            // 'k_bottom',
            // 'k_min_top',
            // 'k_min_bottom',
        ];
    }
}
