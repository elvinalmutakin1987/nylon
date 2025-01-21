<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsergroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'superuser']);

        //===========================================
        Permission::create(['name' => 'datamaster']);
        //-------------------------------------------
        Permission::create(['name' => 'mesin']);
        Permission::create(['name' => 'usergroup']);
        Permission::create(['name' => 'user']);
        Permission::create(['name' => 'lokasi']);
        Permission::create(['name' => 'material']);
        Permission::create(['name' => 'produk']);
        Permission::create(['name' => 'varian']);
        //===========================================

        //===========================================
        Permission::create(['name' => 'produksi']);
        //-------------------------------------------

        //===========================================

        //===========================================
        Permission::create(['name' => 'pengaturan']);
        //-------------------------------------------
        Permission::create(['name' => 'pengaturanumum']);
        Permission::create(['name' => 'pengaturanlaporan']);
        Permission::create(['name' => 'approval']);
        //===========================================

    }
}
