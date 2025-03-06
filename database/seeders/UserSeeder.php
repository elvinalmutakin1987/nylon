<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'superadmin']);

        /**
         * Data master
         */
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

        /**
         * Order
         */
        Permission::create(['name' => 'order']);
        //===========================================

        /**
         * Gudang
         */
        Permission::create(['name' => 'gudang']);
        Permission::create(['name' => 'gudang.bahanbaku.barangkeluar']);
        Permission::create(['name' => 'gudang.bahanbaku.barangmasuk']);
        Permission::create(['name' => 'gudang.bahanbaku.retur']);
        Permission::create(['name' => 'gudang.bahanbaku.cekstok']);
        Permission::create(['name' => 'gudang.bahanbaku.penerimaanbarang']);
        Permission::create(['name' => 'gudang.barangjadi.order']);
        Permission::create(['name' => 'gudang.barangjadi.cekstok']);
        Permission::create(['name' => 'gudang.barangjadi.suratjalan']);
        Permission::create(['name' => 'gudang.barangjadi.barangkeluar']);
        Permission::create(['name' => 'gudang.barangjadi.barangmasuk']);
        Permission::create(['name' => 'gudang.barangjadi.retur']);
        //===========================================

        /**
         * Produksi
         */
        Permission::create(['name' => 'produksi']);
        Permission::create(['name' => 'gudang.benang.barangkeluar']);
        Permission::create(['name' => 'gudang.benang.barangmasuk']);
        Permission::create(['name' => 'gudang.benang.retur']);
        Permission::create(['name' => 'gudang.benang.cekstok']);
        Permission::create(['name' => 'produksi.wjl.operator']);
        Permission::create(['name' => 'produksi.wjl.kepalaregu']);
        Permission::create(['name' => 'produksi.wjl.edit']);
        Permission::create(['name' => 'produksi.wjl.rekap']);
        Permission::create(['name' => 'produksi.wjl.konfirmasi']);
        Permission::create(['name' => 'produksi.wjl.permintaanmaterial']);
        Permission::create(['name' => 'produksi.wjl.pengeringankain']);
        Permission::create(['name' => 'produksi.extruder.kontrol-denier']);
        Permission::create(['name' => 'produksi.extruder.rekap-denier']);
        Permission::create(['name' => 'produksi.extruder.kontrol-barmag']);
        Permission::create(['name' => 'produksi.extruder.rekap-barmag']);
        Permission::create(['name' => 'produksi.extruder.cek-wender']);
        Permission::create(['name' => 'produksi.extruder.kontrol-reifenhouzer']);
        Permission::create(['name' => 'produksi.extruder.rekap-reifenhouzer']);
        Permission::create(['name' => 'approval']);
        //===========================================

        /**
         * Laporan
         */
        Permission::create(['name' => 'laporan']);
        Permission::create(['name' => 'laporan.gudang']);
        //===========================================

        /**
         * Pengaturan
         */
        Permission::create(['name' => 'pengaturan']);
        Permission::create(['name' => 'peranpengguna']);
        Permission::create(['name' => 'pengguna']);
        Permission::create(['name' => 'approvallaporan']);
        //===========================================

        $data = [
            "slug" => Str::random(32),
            "username" => "elvin",
            "name" => "Elvin Almutakin",
            "email" => "elvinalmutakin@gmail.id",
            "password" => bcrypt("123"),
            "email_verified_at" => now(),
            "remember_token" =>  Str::random(10)
        ];

        DB::table('users')->insert($data);

        $user = User::find(1);

        $permission = Permission::all();

        $role = Role::find(1);

        $user->givePermissionTo($permission);

        $user->assignRole($role);

        $role->givePermissionTo($permission);
    }
}
