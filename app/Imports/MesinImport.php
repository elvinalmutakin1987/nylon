<?php

namespace App\Imports;

use App\Models\Lokasi;
use App\Models\Mesin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MesinImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $lokasi = Lokasi::where('nama', $row['lokasi'])->first();
        if (!$lokasi) {
            $lokasi = new Lokasi();
            $lokasi->slug = Str::random(32);
            $lokasi->nama = $row['lokasi'];
            $lokasi->save();
        }
        return new Mesin([
            'slug' => Str::random(32),
            'nama' => $row['nama'],
            'lokasi_id' => $lokasi->id,
            'keterangan' => $row['keterangan'],
            'created_by' => Auth::user()->id
        ]);
    }
}
