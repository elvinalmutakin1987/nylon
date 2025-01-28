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
        Schema::create('lapproduksiwjls', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('mesin_id')->nullable();
            $table->string('jenis_kain')->nullable();
            $table->string('operator')->nullable();
            $table->string('shift')->nullable();
            $table->decimal('meter_awal', 16, 2)->nullable();
            $table->decimal('meter_akhir', 16, 2)->nullable();
            $table->decimal('hasil', 16, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->decimal('lungsi', 16, 2)->nullable();
            $table->decimal('pakan', 16, 2)->nullable();
            $table->decimal('lubang', 16, 2)->nullable();
            $table->string('pgr')->nullable();
            $table->decimal('lebar', 16, 2)->nullable();
            $table->string('mesin')->nullable();
            $table->string('teknisi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapproduksiwjls');
    }
};
