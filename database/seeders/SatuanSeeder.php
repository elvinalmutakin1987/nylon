<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "slug" => Str::random(32),
                "nama" => "KG",
            ],
            [
                "slug" => Str::random(32),
                "nama" => "BOBIN",
            ],
            [
                "slug" => Str::random(32),
                "nama" => "PCS",
            ],
            [
                "slug" => Str::random(32),
                "nama" => "LBR",
            ],
            [
                "slug" => Str::random(32),
                "nama" => "ROL",
            ],
        ];
        DB::table('satuans')->insert($data);
    }
}
