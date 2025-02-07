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
        Schema::create('panenwjls', function (Blueprint $table) {
            $table->id();
            $table->integer('mesin_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('no_dokumen')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('operator')->nullable();
            $table->string('jenis_kain')->nullable();
            $table->string('no_roll')->nullable();
            $table->string('kondisi_kain')->nullable();
            $table->string('panjang')->nullable();
            $table->string('lebar')->nullable();
            $table->string('berat')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->index('mesin_id');
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panenwjls');
    }
};
