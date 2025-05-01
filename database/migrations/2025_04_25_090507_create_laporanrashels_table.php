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
        Schema::create('laporanrashels', function (Blueprint $table) {
            $table->id();
            $table->integer('mesin_id')->nullable();
            $table->string('slug')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('shift')->nullable();
            $table->string('jenis_produksi')->nullable();
            $table->string('meter_awal')->nullable();
            $table->string('meter_akhir')->nullable();
            $table->string('hasil')->nullable();
            $table->text('keterangan_produksi')->nullable();
            $table->text('keterangan_mesin')->nullable();
            $table->time('jam_stop')->nullable();
            $table->time('jam_jalan')->nullable();
            $table->time('lama_jalan')->nullable();
            $table->string('operator')->nullable();
            $table->string('teknisi')->nullable();
            $table->string('status')->nullable();
            $table->string('upload')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('confirmed_by')->nullable();
            $table->timestamps();
            $table->index('mesin_id');
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
        Schema::dropIfExists('laporanrashels');
    }
};
