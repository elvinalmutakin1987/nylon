<?php

namespace App\Exports;

use App\Models\Kartustok;
use App\Models\Material;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KartustokExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    public function __construct(string $gudang)
    {
        $this->gudang = $gudang;
    }

    public function collection()
    {
        $jenis = '';
        $gudang = '';
        if ($this->gudang == 'bahan-baku') {
            $jenis = "Bahan Baku";
            $gudang = "Gudang Bahan Baku";
        } elseif ($this->gudang == 'bahan-penolong') {
            $jenis = "Benang";
            $gudang = "Gudang Benang";
        } elseif ($this->gudang == 'benang') {
            $jenis = "Benang";
            $gudang = "Gudang Benang";
        } elseif ($this->gudang == 'barang-jadi') {
            $jenis = "Barang Jadi";
            $gudang = "Gudang Barang Jadi";
        } elseif ($this->gudang == 'wjl') {
            $jenis = "WJL";
            $gudang = "Gudang WJL";
        } elseif ($this->gudang == 'sulzer') {
            $jenis = "Sulzer";
            $gudang = "Gudang Sulzer";
        } elseif ($this->gudang == 'rashel') {
            $jenis = "Rashel";
            $gudang = "Gudang Rashel";
        } elseif ($this->gudang == 'extruder') {
            $jenis = "Extruder";
            $gudang = "Gudang Extruder";
        } elseif ($this->gudang == 'beaming') {
            $jenis = "Beaming";
            $gudang = "Gudang Beaming";
        } elseif ($this->gudang == 'packing') {
            $jenis = "Packing";
            $gudang = "Gudang Packing";
        }
        return Kartustok::select(
            DB::raw('(select nama from materials where id=kartustoks.material_id) as material'),
            'satuan',
            DB::raw('(select k2.stok_akhir from kartustoks k2 where k2.gudang=kartustoks.gudang and k2.material_id=kartustoks.material_id and k2.satuan=kartustoks.satuan order by k2.id desc limit 1) as stok')
        )
            ->where('gudang', '=', $gudang)
            ->groupBy('satuan', 'material', 'stok')
            ->get(
                'material',
                'satuan',
                'stok'
            );
    }

    public function headings(): array
    {
        return [
            'material',
            'satuan',
            'stok'
        ];
    }
}
