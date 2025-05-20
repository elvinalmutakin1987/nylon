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
        Schema::create('laporanbeamingdetails', function (Blueprint $table) {
            $table->id();
            $table->integer('laporanbeaming_id')->nullable();
            $table->string('slug')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('shift')->nullable();
            $table->string('meter_awal')->nullable();
            $table->string('meter_akhir')->nullable();
            $table->string('meter_hasil')->nullable();
            $table->string('rata')->nullable();
            $table->string('pinggiran_terjepit')->nullable();
            $table->string('benang_hilang')->nullable();
            $table->string('salah_motif')->nullable();
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
        Schema::dropIfExists('laporanbeamingdetails');
    }
};
