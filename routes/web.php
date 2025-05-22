<?php

use App\Http\Controllers\BarangkeluarController;
use App\Http\Controllers\BarangmasukController;
use App\Http\Controllers\BeamatasmesinController;
use App\Http\Controllers\BeambawahmesinController;
use App\Http\Controllers\CekstokController;
use App\Http\Controllers\ChecklistbeamingController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DatamasterController;
use App\Http\Controllers\GudangbarangjadicekstokController;
use App\Http\Controllers\GudangbarangjadiorderController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\KontrolbarmagController;
use App\Http\Controllers\KontroldenierController;
use App\Http\Controllers\KontrolreifenController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporangudangController;
use App\Http\Controllers\LaporanrashelController;
use App\Http\Controllers\LaporansulzerController;
use App\Http\Controllers\LaporanbeamingController;
use App\Http\Controllers\LaporanwjlefisiensiController;
use App\Http\Controllers\LapproduksiwjlController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PenerimaanbarangController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PengeringankainController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PeranpenggunaController;
use App\Http\Controllers\PermintaanmaterialController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\ProduksiwjlkepalareguController;
use App\Http\Controllers\ProduksiwjloperatorController;
use App\Http\Controllers\RekappengeringankainController;
use App\Http\Controllers\RekapproduksiwjlController;
use App\Http\Controllers\ReturController;
use App\Http\Controllers\SuratjalanController;
use App\Http\Controllers\VarianController;
use App\Models\Kontrolbarmag;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest'])->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', [Controller::class, 'index'])->name('dashboard');


    Route::get('ubahpassword', [Controller::class, 'ubah_password'])->name('ubahpassword');
    Route::put('ubahpassword/{user}', [Controller::class, 'update_password'])->name('ubahpassword.update');

    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::group(['middleware' => ['role_or_permission:superadmin|produksi']], function () {
        Route::resource('produksi', ProduksiController::class)->names('produksi');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|datamaster']], function () {
        Route::resource('datamaster', DatamasterController::class)->names('datamaster');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|pengaturan']], function () {
        Route::resource('pengaturan', PengaturanController::class)->names('pengaturan');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|lokasi']], function () {
        Route::resource('lokasi', LokasiController::class)->names('lokasi');

        Route::get('lokasi-export', [LokasiController::class, 'export'])->name('lokasi.export');
        Route::post('lokasi-import', [LokasiController::class, 'import'])->name('lokasi.import');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|mesin']], function () {
        Route::resource('mesin', MesinController::class)->names('mesin');

        Route::get('mesin-get-lokasi', [MesinController::class, 'get_lokasi'])->name('mesin.get_lokasi');
        Route::get('mesin-export', [MesinController::class, 'export'])->name('mesin.export');
        Route::post('mesin-import', [MesinController::class, 'import'])->name('mesin.import');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|varian']], function () {
        Route::resource('varian', VarianController::class)->names('varian');

        Route::get('varian-export', [VarianController::class, 'export'])->name('varian.export');
        Route::post('varian-import', [VarianController::class, 'import'])->name('varian.import');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|material']], function () {
        Route::resource('material', MaterialController::class)->names('material');

        Route::get('material-export', [MaterialController::class, 'export'])->name('material.export');
        Route::post('material-import', [MaterialController::class, 'import'])->name('material.import');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|produksi']], function () {
        Route::resource('produksi', ProduksiController::class)->names('produksi');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|order']], function () {
        Route::resource('order', OrderController::class)->names('order');

        Route::get('order-get-material', [OrderController::class, 'get_material'])->name('order.get_material');
        Route::post('order-progress/{order}', [OrderController::class, 'store_progress'])->name('order.progress');
        Route::delete('order-progress/{order}', [OrderController::class, 'destroy_progress'])->name('order.progress.destroy');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|permintaanmaterial']], function () {
        Route::resource('permintaanmaterial', PermintaanmaterialController::class)->names('permintaanmaterial');

        Route::get('permintaanmaterial/{permintaanmaterial}/cetak', [PermintaanmaterialController::class, 'cetak'])->name('permintaanmaterial.cetak');
        Route::get('permintaanmaterial-get-material', [PermintaanmaterialController::class, 'get_material'])->name('permintaanmaterial.get_material');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|gudang']], function () {
        Route::resource('gudang', GudangController::class)->names('gudang');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|gudang.barangjadi.barangkeluar|gudang.bahanbaku.barangkeluar|gudang.benang.barangkeluar|gudang.packing.barangkeluar']], function () {
        Route::resource('barangkeluar', BarangkeluarController::class)->names('barangkeluar');

        Route::get('barangkeluar/{barangkeluar}/cetak', [BarangkeluarController::class, 'cetak'])->name('barangkeluar.cetak');
        Route::get('barangkeluar-get-material', [BarangkeluarController::class, 'get_material'])->name('barangkeluar.get_material');
        Route::get('barangkeluar-get-referensi', [BarangkeluarController::class, 'get_referensi'])->name('barangkeluar.get_referensi');
        Route::get('barangkeluar-get-permintaanmaterial', [BarangkeluarController::class, 'get_permintaanmaterial'])->name('barangkeluar.get_permintaanmaterial');
        Route::get('barangkeluar-get-permintaanmaterial-by-id', [BarangkeluarController::class, 'get_permintaanmaterial_by_id'])->name('barangkeluar.get_permintaanmaterial_by_id');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|gudang.barangjadi.order']], function () {
        Route::resource('gudangbarangjadi-order', GudangbarangjadiorderController::class)->names('gudangbarangjadiorder');
        Route::post('gudangbarangjadi-order-progress/{order}', [GudangbarangjadiorderController::class, 'store_progress'])->name('gudangbarangjadiorder.progress');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|gudang.barangjadi.cekstok|gudang.bahanbaku.cekstok|gudang.benang.cekstok|gudang.packing.cekstok']], function () {
        Route::resource('cekstok', CekstokController::class)->names('cekstok');

        Route::get('cekstok-export', [CekstokController::class, 'export'])->name('cekstok.export');
        Route::get('cekstok-cetak', [CekstokController::class, 'cetak'])->name('cekstok.cetak');
        Route::get('cekstok/{material}/detail', [CekstokController::class, 'detail'])->name('cekstok.detail');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|gudang.barangjadi.suratjalan']], function () {
        Route::resource('suratjalan', SuratjalanController::class)->names('suratjalan');

        Route::get('suratjalan/{suratjalan}/cetak', [SuratjalanController::class, 'cetak'])->name('suratjalan.cetak');
        Route::get('suratjalan-get-order', [SuratjalanController::class, 'get_order'])->name('suratjalan.get_order');
        Route::get('suratjalan-get-toko', [SuratjalanController::class, 'get_toko'])->name('suratjalan.get_toko');
        Route::get('suratjalan-get-material', [SuratjalanController::class, 'get_material'])->name('suratjalan.get_material');
        Route::get('suratjalan-get-referensi', [SuratjalanController::class, 'get_referensi'])->name('suratjalan.get_referensi');
        Route::get('suratjalan-get-order-by-id', [SuratjalanController::class, 'get_order_by_id'])->name('suratjalan.get_order_by_id');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|gudang.barangjadi.barangmasuk|gudang.bahanbaku.barangmasuk|gudang.benang.barangmasuk|gudang.packing.barangmasuk']], function () {
        Route::resource('barangmasuk', BarangmasukController::class)->names('barangmasuk');

        Route::get('barangmasuk/{barangmasuk}/cetak', [BarangmasukController::class, 'cetak'])->name('barangmasuk.cetak');
        Route::get('barangmasuk-get-material', [BarangmasukController::class, 'get_material'])->name('barangmasuk.get_material');
        Route::get('barangmasuk-get-referensi', [BarangmasukController::class, 'get_referensi'])->name('barangmasuk.get_referensi');
        Route::get('barangmasuk-get-barangkeluar', [BarangmasukController::class, 'get_barangkeluar'])->name('barangmasuk.get_barangkeluar');
        Route::get('barangmasuk-get-barangkeluar-by-id', [BarangmasukController::class, 'ge_barangkeluar_by_id'])->name('barangmasuk.get_barangkeluar_by_id');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|gudang.barangjadi.retur|gudang.bahanbaku.retur|gudang.benang.retur|gudang.packing.retur']], function () {
        Route::resource('retur', ReturController::class)->names('retur');

        Route::get('retur/{retur}/cetak', [ReturController::class, 'cetak'])->name('retur.cetak');
        Route::get('retur-get-material', [ReturController::class, 'get_material'])->name('retur.get_material');
        Route::get('retur-get-referensi', [ReturController::class, 'get_referensi'])->name('retur.get_referensi');
        Route::get('retur-get-barangkeluar', [ReturController::class, 'get_barangkeluar'])->name('retur.get_barangkeluar');
        Route::get('retur-get-dokumen', [ReturController::class, 'get_dokumen'])->name('retur.get_dokumen');
        Route::get('retur-get-barangkeluar-by-id', [ReturController::class, 'ge_barangkeluar_by_id'])->name('retur.get_barangkeluar_by_id');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|produksi.wjl.operator']], function () {
        Route::get('produksiwjl-operator', [ProduksiwjloperatorController::class, 'index'])->name('produksiwjl.operator.index');
        Route::post('produksiwjl-operator', [ProduksiwjloperatorController::class, 'store'])->name('produksiwjl.operator.store');
        Route::get('produksiwjl-operator/create', [ProduksiwjloperatorController::class, 'create'])->name('produksiwjl.operator.create');
        Route::get('produksiwjl-operator/create-laporan', [ProduksiwjloperatorController::class, 'create_laporan'])->name('produksiwjl.operator.create_laporan');
        Route::get('produksiwjl-operator/{produksiwjl}', [ProduksiwjloperatorController::class, 'show'])->name('produksiwjl.operator.show');
        Route::put('produksiwjl-operator/{produksiwjl}', [ProduksiwjloperatorController::class, 'update'])->name('produksiwjl.operator.update');
        Route::delete('produksiwjl-operator/{produksiwjl}', [ProduksiwjloperatorController::class, 'destroy'])->name('produksiwjl.operator.destroy');
        Route::get('produksiwjl-operator/{produksiwjl}/edit', [ProduksiwjloperatorController::class, 'edit'])->name('produksiwjl.operator.edit');

        Route::get('produksiwjl-operator-get-mesin', [ProduksiwjloperatorController::class, 'get_mesin'])->name('produksiwjl.operator.get_mesin');
        Route::get('produksiwjl-operator-get-detail', [ProduksiwjloperatorController::class, 'get_detail'])->name('produksiwjl.operator.get_detail');
        Route::get('produksiwjl-operator-cek-sebelumnya', [ProduksiwjloperatorController::class, 'cek_sebelumnya'])->name('produksiwjl.operator.cek_sebelumnya');
        Route::get('produksiwjl-operator-confirm/{produksiwjl}', [ProduksiwjloperatorController::class, 'confirm'])->name('produksiwjl.operator.confirm');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|pengaturan']], function () {
        Route::resource('pengaturan', PengaturanController::class)->names('pengaturan');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|peranpengguna']], function () {
        Route::resource('peranpengguna', PeranpenggunaController::class)->names('peranpengguna');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|pengguna']], function () {
        // Route::resource('pengguna', PenggunaController::class)->names('pengguna');
        Route::get('pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');
        Route::post('pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
        Route::get('pengguna/create', [PenggunaController::class, 'create'])->name('pengguna.create');
        Route::get('pengguna/{user}', [PenggunaController::class, 'show'])->name('pengguna.show');
        Route::put('pengguna/{user}', [PenggunaController::class, 'update'])->name('pengguna.update');
        Route::delete('pengguna/{user}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');
        Route::get('pengguna/{user}/edit', [PenggunaController::class, 'edit'])->name('pengguna.edit');

        Route::get('pengguna-get-peranpengguna', [PenggunaController::class, 'get_peranpengguna'])->name('pengguna.get_peranpengguna');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|produksiwjl.kepalaregu']], function () {
        Route::resource('produksiwjl-kepalaregu', ProduksiwjlkepalareguController::class)->names('produksiwjl.kepalaregu');

        Route::get('produksiwjl-kepalaregu-get-mesin', [ProduksiwjlkepalareguController::class, 'get_mesin'])->name('produksiwjl.kepalaregu.get_mesin');
        Route::get('produksiwjl-kepalaregu-get-detail', [ProduksiwjlkepalareguController::class, 'get_detail'])->name('produksiwjl.kepalaregu.get_detail');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|produksi.wjl.rekap']], function () {
        Route::get('produksiwjl-rekap', [RekapproduksiwjlController::class, 'index'])->name('produksiwjl.rekap.index');
        Route::get('produksiwjl-get-rekap', [RekapproduksiwjlController::class, 'get_rekap'])->name('produksiwjl.rekap.get_rekap');
        Route::post('produksiwjl-rekap', [RekapproduksiwjlController::class, 'store'])->name('produksiwjl.rekap.store');
        Route::get('produksiwjl-rekap/create', [RekapproduksiwjlController::class, 'create'])->name('produksiwjl.rekap.create');
        Route::get('produksiwjl-rekap/create-laporan', [RekapproduksiwjlController::class, 'create_laporan'])->name('produksiwjl.rekap.create_laporan');
        Route::get('produksiwjl-rekap/{produksiwjl}', [RekapproduksiwjlController::class, 'show'])->name('produksiwjl.rekap.show');
        Route::put('produksiwjl-rekap/{produksiwjl}', [RekapproduksiwjlController::class, 'update'])->name('produksiwjl.rekap.update');
        Route::delete('produksiwjl-rekap/{produksiwjl}', [RekapproduksiwjlController::class, 'destroy'])->name('produksiwjl.rekap.destroy');

        Route::group(['middleware' => ['role_or_permission:superadmin|produksi.wjl.edit']], function () {
            Route::get('produksiwjl-rekap/{produksiwjl}/edit', [RekapproduksiwjlController::class, 'edit'])->name('produksiwjl.rekap.edit');
        });

        Route::group(['middleware' => ['role_or_permission:superadmin|produksi.wjl.konfirmasi']], function () {
            Route::get('produksiwjl-rekap-konfirmasi', [RekapproduksiwjlController::class, 'konfirmasi'])->name('produksiwjl.rekap.konfirmasi');
        });

        Route::get('produksiwjl-rekap-cetak', [RekapproduksiwjlController::class, 'cetak'])->name('produksiwjl.rekap.cetak');
        Route::get('produksiwjl-rekap-get-mesin', [RekapproduksiwjlController::class, 'get_mesin'])->name('produksiwjl.rekap.get_mesin');
        Route::get('produksiwjl-rekap-get-detail', [RekapproduksiwjlController::class, 'get_detail'])->name('produksiwjl.rekap.get_detail');
        Route::get('produksiwjl-rekap-cek-sebelumnya', [RekapproduksiwjlController::class, 'cek_sebelumnya'])->name('produksiwjl.rekap.cek_sebelumnya');
        Route::get('produksiwjl-rekap-confirm/{produksiwjl}', [RekapproduksiwjlController::class, 'confirm'])->name('produksiwjl.rekap.confirm');

        Route::get('produksiwjl-rekap-export', [RekapproduksiwjlController::class, 'export'])->name('produksiwjl.rekap.export');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|gudang.bahanbaku.penerimaanbarang']], function () {
        Route::resource('penerimaanbarang', PenerimaanbarangController::class)->names('penerimaanbarang');

        Route::get('penerimaanbarang/{penerimaanbarang}/cetak', [PenerimaanbarangController::class, 'cetak'])->name('penerimaanbarang.cetak');
        Route::get('penerimaanbarang-get-supplier', [PenerimaanbarangController::class, 'get_supplier'])->name('penerimaanbarang.get_supplier');
        Route::get('penerimaanbarang-get-material', [PenerimaanbarangController::class, 'get_material'])->name('penerimaanbarang.get_material');
        Route::get('penerimaanbarang-get-referensi', [PenerimaanbarangController::class, 'get_referensi'])->name('penerimaanbarang.get_referensi');
        Route::get('penerimaanbarang-get-barangkeluar', [PenerimaanbarangController::class, 'get_barangkeluar'])->name('penerimaanbarang.get_barangkeluar');
        Route::get('penerimaanbarang-get-barangkeluar-by-id', [PenerimaanbarangController::class, 'ge_barangkeluar_by_id'])->name('penerimaanbarang.get_barangkeluar_by_id');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|produksi.extruder.kontrol-denier']], function () {
        Route::get('produksiextruder-kontrol-denier', [KontroldenierController::class, 'index'])->name('produksiextruder-kontrol-denier.index');
        Route::post('produksiextruder-kontrol-denier', [KontroldenierController::class, 'store'])->name('produksiextruder-kontrol-denier.store');
        Route::post('produksiextruder-kontrol-denier/store-laporan', [KontroldenierController::class, 'store_laporan'])->name('produksiextruder-kontrol-denier.store_laporan');
        Route::get('produksiextruder-kontrol-denier/create', [KontroldenierController::class, 'create'])->name('produksiextruder-kontrol-denier.create');
        Route::get('produksiextruder-kontrol-denier/create-laporan', [KontroldenierController::class, 'create_laporan'])->name('produksiextruder-kontrol-denier.create_laporan');
        Route::get('produksiextruder-kontrol-denier/{kontroldenier}', [KontroldenierController::class, 'show'])->name('produksiextruder-kontrol-denier.show');
        Route::put('produksiextruder-kontrol-denier/{kontroldenier}', [KontroldenierController::class, 'update'])->name('produksiextruder-kontrol-denier.update');
        Route::delete('produksiextruder-kontrol-denier/{kontroldenier}', [KontroldenierController::class, 'destroy'])->name('produksiextruder-kontrol-denier.destroy');
        Route::get('produksiextruder-kontrol-denier/{kontroldenier}/edit', [KontroldenierController::class, 'edit'])->name('produksiextruder-kontrol-denier.edit');

        Route::get('produksiextruder-kontrol-denier-create-laporan', [KontroldenierController::class, 'create_laporan'])->name('produksiextruder-kontrol-denier.create_laporan');
        Route::get('produksiextruder-kontrol-denier-get-material', [KontroldenierController::class, 'get_material'])->name('produksiextruder-kontrol-denier.get_material');
        Route::get('produksiextruder-kontrol-denier-get-detail', [KontroldenierController::class, 'get_detail'])->name('produksiextruder-kontrol-denier.get_detail');
        Route::get('produksiextruder-kontrol-denier-cek-sebelumnya', [KontroldenierController::class, 'cek_sebelumnya'])->name('produksiextruder-kontrol-denier.cek_sebelumnya');
        Route::get('produksiextruder-kontrol-denier-confirm/{produksiwjl}', [KontroldenierController::class, 'confirm'])->name('produksiextruder-kontrol-denier.confirm');
        Route::post('produksiextruder-kontrol-denier/{kontroldenier}', [KontroldenierController::class, 'simpan_denier'])->name('produksiextruder-kontrol-denier.simpan_denier');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|produksi.extruder.kontrol-barmag']], function () {
        Route::get('produksiextruder-kontrol-barmag', [KontrolbarmagController::class, 'index'])->name('produksiextruder-kontrol-barmag.index');
        Route::post('produksiextruder-kontrol-barmag', [KontrolbarmagController::class, 'store'])->name('produksiextruder-kontrol-barmag.store');
        Route::post('produksiextruder-kontrol-barmag/store-laporan', [KontrolbarmagController::class, 'store_laporan'])->name('produksiextruder-kontrol-barmag.store_laporan');
        Route::get('produksiextruder-kontrol-barmag/create', [KontrolbarmagController::class, 'create'])->name('produksiextruder-kontrol-barmag.create');
        Route::get('produksiextruder-kontrol-barmag/create-laporan', [KontrolbarmagController::class, 'create_laporan'])->name('produksiextruder-kontrol-barmag.create_laporan');
        Route::get('produksiextruder-kontrol-barmag/{kontrolbarmag}', [KontrolbarmagController::class, 'show'])->name('produksiextruder-kontrol-barmag.show');
        Route::put('produksiextruder-kontrol-barmag/{kontrolbarmag}', [KontrolbarmagController::class, 'update'])->name('produksiextruder-kontrol-barmag.update');
        Route::delete('produksiextruder-kontrol-barmag/{kontrolbarmag}', [KontrolbarmagController::class, 'destroy'])->name('produksiextruder-kontrol-barmag.destroy');
        Route::get('produksiextruder-kontrol-barmag/{kontrolbarmag}/edit', [KontrolbarmagController::class, 'edit'])->name('produksiextruder-kontrol-barmag.edit');

        Route::get('produksiextruder-kontrol-barmag-create-laporan', [KontrolbarmagController::class, 'create_laporan'])->name('produksiextruder-kontrol-barmag.create_laporan');
        Route::get('produksiextruder-kontrol-barmag-get-material', [KontrolbarmagController::class, 'get_material'])->name('produksiextruder-kontrol-barmag.get_material');
        Route::get('produksiextruder-kontrol-barmag-get-detail', [KontrolbarmagController::class, 'get_detail'])->name('produksiextruder-kontrol-barmag.get_detail');
        Route::get('produksiextruder-kontrol-barmag-cek-sebelumnya', [KontrolbarmagController::class, 'cek_sebelumnya'])->name('produksiextruder-kontrol-barmag.cek_sebelumnya');
        Route::get('produksiextruder-kontrol-barmag-confirm/{produksiwjl}', [KontrolbarmagController::class, 'confirm'])->name('produksiextruder-kontrol-barmag.confirm');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|produksi.laminating.pengeringankain']], function () {
        Route::get('laminanting-pengeringankain', [PengeringankainController::class, 'index'])->name('produksilaminating.pengeringankain.index');
        Route::get('laminanting-get-pengeringankain', [PengeringankainController::class, 'get_pengeringankain'])->name('produksilaminating.pengeringankain.get_pengeringankain');
        Route::post('laminanting-pengeringankain', [PengeringankainController::class, 'store'])->name('produksilaminating.pengeringankain.store');
        Route::get('laminanting-pengeringankain/create', [PengeringankainController::class, 'create'])->name('produksilaminating.pengeringankain.create');
        Route::get('laminanting-pengeringankain/create-laporan', [PengeringankainController::class, 'create_laporan'])->name('produksilaminating.pengeringankain.create_laporan');
        Route::get('laminanting-pengeringankain/{pengeringankain}', [PengeringankainController::class, 'show'])->name('produksilaminating.pengeringankain.show');
        Route::put('laminanting-pengeringankain/{pengeringankain}', [PengeringankainController::class, 'update'])->name('produksilaminating.pengeringankain.update');
        Route::delete('laminanting-pengeringankain/{pengeringankain}', [PengeringankainController::class, 'destroy'])->name('produksilaminating.pengeringankain.destroy');

        Route::group(['middleware' => ['role_or_permission:superadmin|produksi.pengeringakain.edit']], function () {
            Route::get('laminanting-pengeringankain/{pengeringankain}/edit', [PengeringankainController::class, 'edit'])->name('produksilaminating.pengeringankain.edit');
        });

        Route::get('laminanting-pengeringankain-cetak', [PengeringankainController::class, 'cetak'])->name('produksilaminating.pengeringankain.cetak');
        Route::get('laminanting-pengeringankain-get-mesin', [PengeringankainController::class, 'get_mesin'])->name('produksilaminating.pengeringankain.get_mesin');
        Route::get('laminanting-pengeringankain-get-detail', [PengeringankainController::class, 'get_detail'])->name('produksilaminating.pengeringankain.get_detail');
        Route::get('laminanting-pengeringankain-cek-laporan-wjl', [PengeringankainController::class, 'cek_laporan_wjl'])->name('produksilaminating.pengeringankain.cek_laporan_wjl');
        Route::get('laminanting-pengeringankain-confirm/{pengeringankain}', [PengeringankainController::class, 'confirm'])->name('produksilaminating.pengeringankain.confirm');

        Route::get('laminanting-pengeringankain-export', [PengeringankainController::class, 'export'])->name('produksilaminating.pengeringankain.export');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|produksi.laminating.rekap']], function () {
        Route::resource('laminanting-rekap', RekappengeringankainController::class)->names('produksilaminating.rekap');
        Route::get('laminanting-rekap-get-rekap', [RekappengeringankainController::class, 'get_rekap'])->name('produksilaminating.rekap.get_rekap');

        Route::group(['middleware' => ['role_or_permission:superadmin|produksi.laminanting.konfirmasi']], function () {
            Route::get('laminanting-rekap-konfirmasi', [RekappengeringankainController::class, 'konfirmasi'])->name('produksilaminating.rekap.konfirmasi');
        });

        Route::get('laminanting-rekap-cetak', [RekappengeringankainController::class, 'cetak'])->name('produksilaminating.rekap.cetak');
        Route::get('laminanting-rekap-get-mesin', [RekappengeringankainController::class, 'get_mesin'])->name('produksilaminating.rekap.get_mesin');
        Route::get('laminanting-rekap-get-detail', [RekappengeringankainController::class, 'get_detail'])->name('produksilaminating.rekap.get_detail');

        Route::get('laminanting-rekap-export', [RekappengeringankainController::class, 'export'])->name('produksilaminating.rekap.export');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|laporan']], function () {
        Route::resource('laporan', LaporanController::class)->names('laporan');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|laporan.gudang']], function () {
        Route::resource('laporangudang', LaporangudangController::class)->names('laporangudang');

        Route::get('laporangudang-detail', [LaporangudangController::class, 'detail'])->name('laporangudang.detail');
        Route::get('laporangudang-cetak', [LaporangudangController::class, 'cetak'])->name('laporangudang.cetak');
        Route::get('laporangudang-export', [LaporangudangController::class, 'export'])->name('laporangudang.export');
        Route::post('laporangudang-store-keterangan', [LaporangudangController::class, 'store_keterangan'])->name('laporangudang.store_keterangan');
    });


    Route::group(['middleware' => ['role_or_permission:superadmin|produksi.extruder.kontrol-reifen']], function () {
        Route::get('produksiextruder-kontrol-reifen', [KontrolreifenController::class, 'index'])->name('produksiextruder-kontrol-reifen.index');
        Route::post('produksiextruder-kontrol-reifen', [KontrolreifenController::class, 'store'])->name('produksiextruder-kontrol-reifen.store');
        Route::post('produksiextruder-kontrol-reifen/store-laporan', [KontrolreifenController::class, 'store_laporan'])->name('produksiextruder-kontrol-reifen.store_laporan');
        Route::get('produksiextruder-kontrol-reifen/create', [KontrolreifenController::class, 'create'])->name('produksiextruder-kontrol-reifen.create');
        Route::get('produksiextruder-kontrol-reifen/create-laporan', [KontrolreifenController::class, 'create_laporan'])->name('produksiextruder-kontrol-reifen.create_laporan');
        Route::get('produksiextruder-kontrol-reifen/{kontrolreifen}', [KontrolreifenController::class, 'show'])->name('produksiextruder-kontrol-reifen.show');
        Route::put('produksiextruder-kontrol-reifen/{kontrolreifen}', [KontrolreifenController::class, 'update'])->name('produksiextruder-kontrol-reifen.update');
        Route::delete('produksiextruder-kontrol-reifen/{kontrolreifen}', [KontrolreifenController::class, 'destroy'])->name('produksiextruder-kontrol-reifen.destroy');
        Route::get('produksiextruder-kontrol-reifen/{kontrolreifen}/edit', [KontrolreifenController::class, 'edit'])->name('produksiextruder-kontrol-reifen.edit');

        Route::get('produksiextruder-kontrol-reifen-create-laporan', [KontrolreifenController::class, 'create_laporan'])->name('produksiextruder-kontrol-reifen.create_laporan');
        Route::get('produksiextruder-kontrol-reifen-get-material', [KontrolreifenController::class, 'get_material'])->name('produksiextruder-kontrol-reifen.get_material');
        Route::get('produksiextruder-kontrol-reifen-get-detail', [KontrolreifenController::class, 'get_detail'])->name('produksiextruder-kontrol-reifen.get_detail');
        Route::get('produksiextruder-kontrol-reifen-cek-sebelumnya', [KontrolreifenController::class, 'cek_sebelumnya'])->name('produksiextruder-kontrol-reifen.cek_sebelumnya');
        Route::get('produksiextruder-kontrol-reifen-confirm/{produksiwjl}', [KontrolreifenController::class, 'confirm'])->name('produksiextruder-kontrol-reifen.confirm');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|produksi.extruder.laporansulzer']], function () {
        Route::get('produksiextruder-laporansulzer', [LaporansulzerController::class, 'index'])->name('produksiextruder.laporansulzer.index');
        Route::get('produksiextruder-get-laporansulzer', [LaporansulzerController::class, 'get_laporansulzer'])->name('produksiextruder.laporansulzer.get_laporansulzer');
        Route::post('produksiextruder-laporansulzer', [LaporansulzerController::class, 'store'])->name('produksiextruder.laporansulzer.store');
        Route::get('produksiextruder-laporansulzer/create', [LaporansulzerController::class, 'create'])->name('produksiextruder.laporansulzer.create');
        Route::get('produksiextruder-laporansulzer/create-laporan', [LaporansulzerController::class, 'create_laporan'])->name('produksiextruder.laporansulzer.create_laporan');
        Route::get('produksiextruder-laporansulzer/{laporansulzer}', [LaporansulzerController::class, 'show'])->name('produksiextruder.laporansulzer.show');
        Route::put('produksiextruder-laporansulzer/{laporansulzer}', [LaporansulzerController::class, 'update'])->name('produksiextruder.laporansulzer.update');
        Route::delete('produksiextruder-laporansulzer/{laporansulzer}', [LaporansulzerController::class, 'destroy'])->name('produksiextruder.laporansulzer.destroy');
        Route::get('produksiextruder-laporansulzer/{laporansulzer}/edit', [LaporansulzerController::class, 'edit'])->name('produksiextruder.laporansulzer.edit');

        // Route::group(['middleware' => ['role_or_permission:superadmin|produksi.extruder.laporansulzer.edit']], function () {
        //     Route::get('produksiextruder-laporansulzer/{laporansulzer}/edit', [LaporansulzerController::class, 'edit'])->name('produksiextruder.laporansulzer.edit');
        // });

        Route::get('produksiextruder-laporansulzer-cetak', [LaporansulzerController::class, 'cetak'])->name('produksiextruder.laporansulzer.cetak');
        Route::get('produksiextruder-laporansulzer-get-mesin', [LaporansulzerController::class, 'get_mesin'])->name('produksiextruder.laporansulzer.get_mesin');
        Route::get('produksiextruder-laporansulzer-get-detail', [LaporansulzerController::class, 'get_detail'])->name('produksiextruder.laporansulzer.get_detail');
        Route::get('produksiextruder-laporansulzer-cek-laporan-wjl', [LaporansulzerController::class, 'cek_laporan_wjl'])->name('produksiextruder.laporansulzer.cek_laporan_wjl');
        Route::get('produksiextruder-laporansulzer-confirm/{laporansulzer}', [LaporansulzerController::class, 'confirm'])->name('produksiextruder.laporansulzer.confirm');

        Route::get('produksiextruder-laporansulzer-export', [LaporansulzerController::class, 'export'])->name('produksiextruder.laporansulzer.export');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|produksi.extruder.laporanrashel']], function () {
        Route::get('produksiextruder-laporanrashel', [LaporanrashelController::class, 'index'])->name('produksiextruder.laporanrashel.index');
        Route::get('produksiextruder-get-laporanrashel', [LaporanrashelController::class, 'get_laporanrashel'])->name('produksiextruder.laporanrashel.get_laporanrashel');
        Route::post('produksiextruder-laporanrashel', [LaporanrashelController::class, 'store'])->name('produksiextruder.laporanrashel.store');
        Route::get('produksiextruder-laporanrashel/create', [LaporanrashelController::class, 'create'])->name('produksiextruder.laporanrashel.create');
        Route::get('produksiextruder-laporanrashel/create-laporan', [LaporanrashelController::class, 'create_laporan'])->name('produksiextruder.laporanrashel.create_laporan');
        Route::get('produksiextruder-laporanrashel/{laporanrashel}', [LaporanrashelController::class, 'show'])->name('produksiextruder.laporanrashel.show');
        Route::put('produksiextruder-laporanrashel/{laporanrashel}', [LaporanrashelController::class, 'update'])->name('produksiextruder.laporanrashel.update');
        Route::delete('produksiextruder-laporanrashel/{laporanrashel}', [LaporanrashelController::class, 'destroy'])->name('produksiextruder.laporanrashel.destroy');
        Route::get('produksiextruder-laporanrashel/{laporanrashel}/edit', [LaporanrashelController::class, 'edit'])->name('produksiextruder.laporanrashel.edit');

        // Route::group(['middleware' => ['role_or_permission:superadmin|produksi.extruder.laporanrashel.edit']], function () {
        //     Route::get('produksiextruder-laporanrashel/{laporanrashel}/edit', [LaporanrashelController::class, 'edit'])->name('produksiextruder.laporanrashel.edit');
        // });

        Route::get('produksiextruder-laporanrashel-cetak', [LaporanrashelController::class, 'cetak'])->name('produksiextruder.laporanrashel.cetak');
        Route::get('produksiextruder-laporanrashel-get-mesin', [LaporanrashelController::class, 'get_mesin'])->name('produksiextruder.laporanrashel.get_mesin');
        Route::get('produksiextruder-laporanrashel-get-detail', [LaporanrashelController::class, 'get_detail'])->name('produksiextruder.laporanrashel.get_detail');
        Route::get('produksiextruder-laporanrashel-cek-laporan-wjl', [LaporanrashelController::class, 'cek_laporan_wjl'])->name('produksiextruder.laporanrashel.cek_laporan_wjl');
        Route::get('produksiextruder-laporanrashel-confirm/{laporanrashel}', [LaporanrashelController::class, 'confirm'])->name('produksiextruder.laporanrashel.confirm');

        Route::get('produksiextruder-laporanrashel-export', [LaporanrashelController::class, 'export'])->name('produksiextruder.laporanrashel.export');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|laporan.wjl.efisiensi']], function () {
        Route::resource('laporanwjl-efisiensi', LaporanwjlefisiensiController::class)->names('laporanwjl.efisiensi');

        Route::get('laporanwjl-efisiensi-detail', [LaporanwjlefisiensiController::class, 'detail'])->name('laporanwjl.efisiensi.detail');
        Route::get('laporanwjl-efisiensi-cetak', [LaporanwjlefisiensiController::class, 'cetak'])->name('laporanwjl.efisiensi.cetak');
        Route::get('laporanwjl-efisiensi-export', [LaporanwjlefisiensiController::class, 'export'])->name('laporanwjl.efisiensi.export');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|produksi.extruder.checklistbeaming']], function () {
        Route::get('produksiextruder-checklistbeaming', [ChecklistbeamingController::class, 'index'])->name('produksiextruder.checklistbeaming.index');
        Route::get('produksiextruder-get-checklistbeaming', [ChecklistbeamingController::class, 'get_checklistbeaming'])->name('produksiextruder.checklistbeaming.get_checklistbeaming');
        Route::post('produksiextruder-checklistbeaming', [ChecklistbeamingController::class, 'store'])->name('produksiextruder.checklistbeaming.store');
        Route::get('produksiextruder-checklistbeaming/create', [ChecklistbeamingController::class, 'create'])->name('produksiextruder.checklistbeaming.create');
        Route::get('produksiextruder-checklistbeaming/create-laporan', [ChecklistbeamingController::class, 'create_laporan'])->name('produksiextruder.checklistbeaming.create_laporan');
        Route::get('produksiextruder-checklistbeaming/{checklistbeaming}', [ChecklistbeamingController::class, 'show'])->name('produksiextruder.checklistbeaming.show');
        Route::put('produksiextruder-checklistbeaming/{checklistbeaming}', [ChecklistbeamingController::class, 'update'])->name('produksiextruder.checklistbeaming.update');
        Route::delete('produksiextruder-checklistbeaming/{checklistbeaming}', [ChecklistbeamingController::class, 'destroy'])->name('produksiextruder.checklistbeaming.destroy');
        Route::get('produksiextruder-checklistbeaming/{checklistbeaming}/edit', [ChecklistbeamingController::class, 'edit'])->name('produksiextruder.checklistbeaming.edit');

        // Route::group(['middleware' => ['role_or_permission:superadmin|produksi.extruder.checklistbeaming.edit']], function () {
        //     Route::get('produksiextruder-checklistbeaming/{checklistbeaming}/edit', [ChecklistbeamingController::class, 'edit'])->name('produksiextruder.checklistbeaming.edit');
        // });

        Route::get('produksiextruder-checklistbeaming-cetak', [ChecklistbeamingController::class, 'cetak'])->name('produksiextruder.checklistbeaming.cetak');
        Route::get('produksiextruder-checklistbeaming-get-mesin', [ChecklistbeamingController::class, 'get_mesin'])->name('produksiextruder.checklistbeaming.get_mesin');
        Route::get('produksiextruder-checklistbeaming-get-detail', [ChecklistbeamingController::class, 'get_detail'])->name('produksiextruder.checklistbeaming.get_detail');
        Route::get('produksiextruder-checklistbeaming-confirm/{checklistbeaming}', [ChecklistbeamingController::class, 'confirm'])->name('produksiextruder.checklistbeaming.confirm');

        Route::get('produksiextruder-checklistbeaming-export', [ChecklistbeamingController::class, 'export'])->name('produksiextruder.checklistbeaming.export');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|produksi.extruder.laporanbeaming']], function () {
        Route::get('produksiextruder-laporanbeaming', [LaporanbeamingController::class, 'index'])->name('produksiextruder.laporanbeaming.index');
        Route::get('produksiextruder-get-laporanbeaming', [LaporanbeamingController::class, 'get_laporanbeaming'])->name('produksiextruder.laporanbeaming.get_laporanbeaming');
        Route::post('produksiextruder-laporanbeaming', [LaporanbeamingController::class, 'store'])->name('produksiextruder.laporanbeaming.store');
        Route::get('produksiextruder-laporanbeaming/create', [LaporanbeamingController::class, 'create'])->name('produksiextruder.laporanbeaming.create');
        Route::get('produksiextruder-laporanbeaming/create-laporan', [LaporanbeamingController::class, 'create_laporan'])->name('produksiextruder.laporanbeaming.create_laporan');
        Route::get('produksiextruder-laporanbeaming/{laporanbeaming}', [LaporanbeamingController::class, 'show'])->name('produksiextruder.laporanbeaming.show');
        Route::put('produksiextruder-laporanbeaming/{laporanbeaming}', [LaporanbeamingController::class, 'update'])->name('produksiextruder.laporanbeaming.update');
        Route::delete('produksiextruder-laporanbeaming/{laporanbeaming}', [LaporanbeamingController::class, 'destroy'])->name('produksiextruder.laporanbeaming.destroy');
        Route::get('produksiextruder-laporanbeaming/{laporanbeaming}/edit', [LaporanbeamingController::class, 'edit'])->name('produksiextruder.laporanbeaming.edit');

        // Route::group(['middleware' => ['role_or_permission:superadmin|produksi.extruder.laporanbeaming.edit']], function () {
        //     Route::get('produksiextruder-laporanbeaming/{laporanbeaming}/edit', [LaporanbeamingController::class, 'edit'])->name('produksiextruder.laporanbeaming.edit');
        // });

        Route::get('produksiextruder-laporanbeaming-cetak', [LaporanbeamingController::class, 'cetak'])->name('produksiextruder.laporanbeaming.cetak');
        Route::get('produksiextruder-laporanbeaming-get-mesin', [LaporanbeamingController::class, 'get_mesin'])->name('produksiextruder.laporanbeaming.get_mesin');
        Route::get('produksiextruder-laporanbeaming-get-detail', [LaporanbeamingController::class, 'get_detail'])->name('produksiextruder.laporanbeaming.get_detail');
        Route::get('produksiextruder-laporanbeaming-confirm/{laporanbeaming}', [LaporanbeamingController::class, 'confirm'])->name('produksiextruder.laporanbeaming.confirm');

        Route::get('produksiextruder-laporanbeaming-export', [LaporanbeamingController::class, 'export'])->name('produksiextruder.laporanbeaming.export');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|produksi.extruder.beamatasmesin']], function () {
        Route::get('produksiextruder-beamatasmesin', [BeamatasmesinController::class, 'index'])->name('produksiextruder.beamatasmesin.index');
        Route::get('produksiextruder-get-beamatasmesin', [BeamatasmesinController::class, 'get_beamatasmesin'])->name('produksiextruder.beamatasmesin.get_beamatasmesin');
        Route::post('produksiextruder-beamatasmesin', [BeamatasmesinController::class, 'store'])->name('produksiextruder.beamatasmesin.store');
        Route::get('produksiextruder-beamatasmesin/create', [BeamatasmesinController::class, 'create'])->name('produksiextruder.beamatasmesin.create');
        Route::get('produksiextruder-beamatasmesin/create-laporan', [BeamatasmesinController::class, 'create_laporan'])->name('produksiextruder.beamatasmesin.create_laporan');
        Route::get('produksiextruder-beamatasmesin/{beamatasmesin}', [BeamatasmesinController::class, 'show'])->name('produksiextruder.beamatasmesin.show');
        Route::put('produksiextruder-beamatasmesin/{beamatasmesin}', [BeamatasmesinController::class, 'update'])->name('produksiextruder.beamatasmesin.update');
        Route::delete('produksiextruder-beamatasmesin/{beamatasmesin}', [BeamatasmesinController::class, 'destroy'])->name('produksiextruder.beamatasmesin.destroy');
        Route::get('produksiextruder-beamatasmesin/{beamatasmesin}/edit', [BeamatasmesinController::class, 'edit'])->name('produksiextruder.beamatasmesin.edit');

        // Route::group(['middleware' => ['role_or_permission:superadmin|produksi.extruder.beamatasmesin.edit']], function () {
        //     Route::get('produksiextruder-beamatasmesin/{beamatasmesin}/edit', [beamatasmesinController::class, 'edit'])->name('produksiextruder.beamatasmesin.edit');
        // });

        Route::get('produksiextruder-beamatasmesin-cetak', [BeamatasmesinController::class, 'cetak'])->name('produksiextruder.beamatasmesin.cetak');
        Route::get('produksiextruder-beamatasmesin-get-mesin', [BeamatasmesinController::class, 'get_mesin'])->name('produksiextruder.beamatasmesin.get_mesin');
        Route::get('produksiextruder-beamatasmesin-get-detail', [BeamatasmesinController::class, 'get_detail'])->name('produksiextruder.beamatasmesin.get_detail');
        Route::get('produksiextruder-beamatasmesin-get-beamatasmesin', [BeamatasmesinController::class, 'get_beamatasmesin'])->name('produksiextruder.beamatasmesin.get_beamatasmesin');
        Route::get('produksiextruder-beamatasmesin-confirm/{beamatasmesin}', [BeamatasmesinController::class, 'confirm'])->name('produksiextruder.beamatasmesin.confirm');

        Route::get('produksiextruder-beamatasmesin-export', [BeamatasmesinController::class, 'export'])->name('produksiextruder.laporanbeaming.export');
    });

    Route::group(['middleware' => ['role_or_permission:superadmin|produksi.extruder.beambawahmesin']], function () {
        Route::get('produksiextruder-beambawahmesin', [BeambawahmesinController::class, 'index'])->name('produksiextruder.beambawahmesin.index');
        Route::get('produksiextruder-get-beambawahmesin', [BeambawahmesinController::class, 'get_Beambawahmesin'])->name('produksiextruder.beambawahmesin.get_beambawahmesin');
        Route::post('produksiextruder-beambawahmesin', [BeambawahmesinController::class, 'store'])->name('produksiextruder.beambawahmesin.store');
        Route::get('produksiextruder-beambawahmesin/create', [BeambawahmesinController::class, 'create'])->name('produksiextruder.beambawahmesin.create');
        Route::get('produksiextruder-beambawahmesin/create-laporan', [BeambawahmesinController::class, 'create_laporan'])->name('produksiextruder.beambawahmesin.create_laporan');
        Route::get('produksiextruder-beambawahmesin/{beambawahmesin}', [BeambawahmesinController::class, 'show'])->name('produksiextruder.beambawahmesin.show');
        Route::put('produksiextruder-beambawahmesin/{beambawahmesin}', [BeambawahmesinController::class, 'update'])->name('produksiextruder.beambawahmesin.update');
        Route::delete('produksiextruder-beambawahmesin/{beambawahmesin}', [BeambawahmesinController::class, 'destroy'])->name('produksiextruder.beambawahmesin.destroy');
        Route::get('produksiextruder-beambawahmesin/{beambawahmesin}/edit', [BeambawahmesinController::class, 'edit'])->name('produksiextruder.beambawahmesin.edit');

        // Route::group(['middleware' => ['role_or_permission:superadmin|produksi.extruder.beambawahmesin.edit']], function () {
        //     Route::get('produksiextruder-beambawahmesin/{beambawahmesin}/edit', [beambawahmesin::class, 'edit'])->name('produksiextruder.beambawahmesin.edit');
        // });

        Route::get('produksiextruder-beambawahmesin-cetak', [BeambawahmesinController::class, 'cetak'])->name('produksiextruder.beambawahmesin.cetak');
        Route::get('produksiextruder-beambawahmesin-get-mesin', [BeambawahmesinController::class, 'get_mesin'])->name('produksiextruder.beambawahmesin.get_mesin');
        Route::get('produksiextruder-beambawahmesin-get-detail', [BeambawahmesinController::class, 'get_detail'])->name('produksiextruder.beambawahmesin.get_detail');
        Route::get('produksiextruder-beambawahmesin-get-Beambawahmesin', [BeambawahmesinController::class, 'get_beambawahmesin'])->name('produksiextruder.beambawahmesin.get_beambawahmesin');
        Route::get('produksiextruder-beambawahmesin-confirm/{Beambawahmesin}', [BeambawahmesinController::class, 'confirm'])->name('produksiextruder.beambawahmesin.confirm');

        Route::get('produksiextruder-beambawahmesin-export', [BeambawahmesinController::class, 'export'])->name('produksiextruder.laporanbeaming.export');
    });
});
