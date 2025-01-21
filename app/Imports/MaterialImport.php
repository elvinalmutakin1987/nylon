<?php

namespace App\Imports;

use App\Models\Material;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MaterialImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $material = Material::where('nama', $row['nama'])
            ->orWhere('kode', $row['kode'])
            ->first();
        if (!$material) {
            return new Material([
                'slug' => Str::random(32),
                'kode' => $row['kode'],
                'nama' => $row['nama'],
                'group' => $row['group'],
                'jenis' => $row['jenis'],
                'created_by' => Auth::user()->id
            ]);
        }
    }
}
