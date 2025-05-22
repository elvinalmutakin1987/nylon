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
        Schema::create('beamatasmesins', function (Blueprint $table) {
            $table->id();
            $table->integer('laporanbeaming_id')->nullable();
            $table->string('slug')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('beam_number')->nullable();
            $table->string('beam_serie')->nullable();
            $table->string('jenis_produksi')->nullable();
            $table->string('rajutan_lusi')->nullable();
            $table->string('lebar_kain')->nullable();
            $table->string('jumlah_benang')->nullable();
            $table->string('lebar_benang')->nullable();
            $table->string('denier')->nullable();
            $table->string('beam_isi')->nullable();
            $table->string('beam_sisa')->nullable();
            $table->string('berat')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('confirmed_by')->nullable();
            $table->timestamps();
            $table->index('laporanbeaming_id');
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
        Schema::dropIfExists('beamatasmesins');
    }
};
