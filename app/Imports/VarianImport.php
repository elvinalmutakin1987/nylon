<?php

namespace App\Imports;

use App\Models\Varian;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VarianImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Lokasi([
            'slug' => Str::random(32),
            'nama' => $row['nama'],
            'keterangan' => $row['keterangan'],
            'created_by' => Auth::user()->id
        ]);
    }
}
