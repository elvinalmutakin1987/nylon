<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporanbeamings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('nomor')->nullable();
            $table->string('beam_number')->nullable();
            $table->string('lembar_tenunan')->nullable();
            $table->string('jenis_bahan')->nullable();
            $table->string('denier')->nullable();
            $table->string('jenis_produksi')->nullable();
            $table->string('lebar_benang')->nullable();
            $table->string('warna_benang')->nullable();
            $table->string('jumlah_lungsi')->nullable();
            $table->string('lebar_beam')->nullable();
            $table->string('front_reed')->nullable();
            $table->string('rear_reed')->nullable();
            $table->string('traverse_reed')->nullable();
            $table->string('benang_pinggiran_kiri')->nullable();
            $table->string('benang_pinggiran_kanan')->nullable();
            $table->string('benang_pinggiran_benang')->nullable();
            $table->string('lebar_traverse')->nullable();
            $table->string('kecepatan_beaming')->nullable();
            $table->string('cut_mark')->nullable();
            $table->string('panjang_press_roller')->nullable();
            $table->string('tekanan_press_roller')->nullable();
            $table->string('tension_roller_no_1')->nullable();
            $table->string('tension_roller_no_2')->nullable();
            $table->string('traverse_reed_design')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('confirmed_by')->nullable();
            $table->string('nomor_sulzer')->nullable();
            $table->date('tanggal_sulzer')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('status')->nullable();
            $table->timestamps();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporanbeamings');
    }
};
