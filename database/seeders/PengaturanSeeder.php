<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PengaturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "slug" => Str::random(32),
                "keterangan" => "permintaanmaterial.approver",
                "nilai" => null
            ],
            [
                "slug" => Str::random(32),
                "keterangan" => "permintaanmaterial.butuh.approval",
                "nilai" => "Tidak"
            ],
            [
                "slug" => Str::random(32),
                "keterangan" => "gudang.bahan-baku.butuh.approval",
                "nilai" => "Tidak"
            ],
            [
                "slug" => Str::random(32),
                "keterangan" => "gudang.barang-jadi.suratjalan.butuh.approval",
                "nilai" => "Tidak"
            ],
            [
                "slug" => Str::random(32),
                "keterangan" => "gudang.barang-jadi.barangkeluar.butuh.approval",
                "nilai" => "Tidak"
            ],
            [
                "slug" => Str::random(32),
                "keterangan" => "gudang.barang-jadi.barangmasuk.butuh.approval",
                "nilai" => "Tidak"
            ],
            [
                "slug" => Str::random(32),
                "keterangan" => "gudang.barang-jadi.retur.butuh.approval",
                "nilai" => "Tidak"
            ],
            [
                "slug" => Str::random(32),
                "keterangan" => "produksiwjl.operator.butuh.approval",
                "nilai" => "Ya"
            ],
            [
                "slug" => Str::random(32),
                "keterangan" => "gudang.bahan-baku.barangkeluar.butuh.approval",
                "nilai" => "Tidak"
            ],
            [
                "slug" => Str::random(32),
                "keterangan" => "gudang.bahan-baku.barangmasuk.butuh.approval",
                "nilai" => "Tidak"
            ],
            [
                "slug" => Str::random(32),
                "keterangan" => "gudang.bahan-baku.retur.butuh.approval",
                "nilai" => "Tidak"
            ],
        ];

        DB::table('pengaturans')->insert($data);
    }
}
