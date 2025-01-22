<?php

use App\Http\Controllers\BarangkeluarController;
use App\Http\Controllers\BarangmasukController;
use App\Http\Controllers\CekstokController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DatamasterController;
use App\Http\Controllers\GudangbarangjadicekstokController;
use App\Http\Controllers\GudangbarangjadiorderController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\PermintaanmaterialController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\SuratjalanController;
use App\Http\Controllers\VarianController;
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

    Route::group(['middleware' => ['role_or_permission:superuser|produksi']], function () {
        Route::resource('produksi', ProduksiController::class)->names('produksi');
    });

    Route::group(['middleware' => ['role_or_permission:superuser|datamaster']], function () {
        Route::resource('datamaster', DatamasterController::class)->names('datamaster');
    });

    Route::group(['middleware' => ['role_or_permission:superuser|pengaturan']], function () {
        Route::resource('pengaturan', PengaturanController::class)->names('pengaturan');
    });

    Route::group(['middleware' => ['role_or_permission:superuser|lokasi']], function () {
        Route::resource('lokasi', LokasiController::class)->names('lokasi');

        Route::get('lokasi-export', [LokasiController::class, 'export'])->name('lokasi.export');
        Route::post('lokasi-import', [LokasiController::class, 'import'])->name('lokasi.import');
    });

    Route::group(['middleware' => ['role_or_permission:superuser|mesin']], function () {
        Route::resource('mesin', MesinController::class)->names('mesin');

        Route::get('mesin-get-lokasi', [MesinController::class, 'get_lokasi'])->name('mesin.get_lokasi');
        Route::get('mesin-export', [MesinController::class, 'export'])->name('mesin.export');
        Route::post('mesin-import', [MesinController::class, 'import'])->name('mesin.import');
    });

    Route::group(['middleware' => ['role_or_permission:superuser|varian']], function () {
        Route::resource('varian', VarianController::class)->names('varian');

        Route::get('varian-export', [VarianController::class, 'export'])->name('varian.export');
        Route::post('varian-import', [VarianController::class, 'import'])->name('varian.import');
    });

    Route::group(['middleware' => ['role_or_permission:superuser|material']], function () {
        Route::resource('material', MaterialController::class)->names('material');

        Route::get('material-export', [MaterialController::class, 'export'])->name('material.export');
        Route::post('material-import', [MaterialController::class, 'import'])->name('material.import');
    });

    Route::group(['middleware' => ['role_or_permission:superuser|produksi']], function () {
        Route::resource('produksi', ProduksiController::class)->names('produksi');
    });

    Route::group(['middleware' => ['role_or_permission:superuser|order']], function () {
        Route::resource('order', OrderController::class)->names('order');

        Route::post('order-progress/{order}', [OrderController::class, 'store_progress'])->name('order.progress');
        Route::delete('order-progress/{order}', [OrderController::class, 'destroy_progress'])->name('order.progress.destroy');
    });

    Route::group(['middleware' => ['role_or_permission:superuser|permintaanmaterial']], function () {
        Route::resource('permintaanmaterial', PermintaanmaterialController::class)->names('permintaanmaterial');

        Route::get('permintaanmaterial/{permintaanmaterial}/cetak', [PermintaanmaterialController::class, 'cetak'])->name('permintaanmaterial.cetak');
        Route::get('permintaanmaterial-get-material', [PermintaanmaterialController::class, 'get_material'])->name('permintaanmaterial.get_material');
    });

    Route::group(['middleware' => ['role_or_permission:superuser|gudang']], function () {
        Route::resource('gudang', GudangController::class)->names('gudang');
    });

    Route::group(['middleware' => ['role_or_permission:superuser|barangkeluar']], function () {
        Route::resource('barangkeluar', BarangkeluarController::class)->names('barangkeluar');

        Route::get('barangkeluar/{barangkeluar}/cetak', [BarangkeluarController::class, 'cetak'])->name('barangkeluar.cetak');
        Route::get('barangkeluar-get-material', [BarangkeluarController::class, 'get_material'])->name('barangkeluar.get_material');
        Route::get('barangkeluar-get-referensi', [BarangkeluarController::class, 'get_referensi'])->name('barangkeluar.get_referensi');
        Route::get('barangkeluar-get-permintaanmaterial', [BarangkeluarController::class, 'get_permintaanmaterial'])->name('barangkeluar.get_permintaanmaterial');
        Route::get('barangkeluar-get-permintaanmaterial-by-id', [BarangkeluarController::class, 'get_permintaanmaterial_by_id'])->name('barangkeluar.get_permintaanmaterial_by_id');
    });

    Route::group(['middleware' => ['role_or_permission:superuser|gudangbarangjadi.order']], function () {
        Route::resource('gudangbarangjadi-order', GudangbarangjadiorderController::class)->names('gudangbarangjadiorder');
        Route::post('gudangbarangjadi-order-progress/{order}', [GudangbarangjadiorderController::class, 'store_progress'])->name('gudangbarangjadiorder.progress');
    });

    Route::group(['middleware' => ['role_or_permission:superuser|gudangbarangjadi.cekstok']], function () {
        Route::resource('cekstok', CekstokController::class)->names('cekstok');
    });

    Route::group(['middleware' => ['role_or_permission:superuser|suratjalan']], function () {
        Route::resource('suratjalan', SuratjalanController::class)->names('suratjalan');

        Route::get('suratjalan/{suratjalan}/cetak', [SuratjalanController::class, 'cetak'])->name('suratjalan.cetak');
        Route::get('suratjalan-get-order', [SuratjalanController::class, 'get_order'])->name('suratjalan.get_order');
        Route::get('suratjalan-get-toko', [SuratjalanController::class, 'get_toko'])->name('suratjalan.get_toko');
        Route::get('suratjalan-get-material', [SuratjalanController::class, 'get_material'])->name('suratjalan.get_material');
        Route::get('suratjalan-get-referensi', [SuratjalanController::class, 'get_referensi'])->name('suratjalan.get_referensi');
        Route::get('suratjalan-get-order-by-id', [SuratjalanController::class, 'get_order_by_id'])->name('suratjalan.get_order_by_id');
    });

    Route::group(['middleware' => ['role_or_permission:superuser|barangmasuk']], function () {
        Route::resource('barangmasuk', BarangmasukController::class)->names('barangmasuk');

        Route::get('barangmasuk/{barangmasuk}/cetak', [BarangmasukController::class, 'cetak'])->name('barangmasuk.cetak');
        Route::get('barangmasuk-get-material', [BarangmasukController::class, 'get_material'])->name('barangmasuk.get_material');
        Route::get('barangmasuk-get-referensi', [BarangmasukController::class, 'get_referensi'])->name('barangmasuk.get_referensi');
        Route::get('barangmasuk-get-barangkeluar', [BarangmasukController::class, 'get_barangkeluar'])->name('barangmasuk.get_barangkeluar');
        Route::get('barangmasuk-get-barangkeluar-by-id', [BarangmasukController::class, 'ge_barangkeluar_by_id'])->name('barangmasuk.get_barangkeluar_by_id');
    });
});
