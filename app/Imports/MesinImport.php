<?php

namespace App\Imports;

use App\Http\Controllers\Controller;
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
            'bagian' => $row['bagian'],
            'lokasi_id' => $lokasi->id,
            'target_produksi' => Controller::unformat_angka($row['target_produksi']),
            'keterangan' => $row['keterangan'],
            'b_plus_top' => $row['b_plus_top'],
            'b_plus_bottom' => $row['b_plus_bottom'],
            'b_top' => $row['b_top'],
            'b_bottom' => $row['b_bottom'],
            'n_top' => $row['n_top'],
            'n_bottom' => $row['n_bottom'],
            'k_top' => $row['k_top'],
            'k_bottom' => $row['k_bottom'],
            'k_min_top' => $row['k_min_top'],
            'k_min_bottom' => $row['k_min_bottom'],
            'created_by' => Auth::user()->id
        ]);
    }
}
