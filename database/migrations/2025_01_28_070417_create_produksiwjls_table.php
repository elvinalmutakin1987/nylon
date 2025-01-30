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
        Schema::create('produksiwjls', function (Blueprint $table) {
            $table->id();
            $table->integer('mesin_id')->nullable();
            $table->string('slug')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('jenis_kain')->nullable();
            $table->string('operator')->nullable();
            $table->string('shift')->nullable();
            $table->string('meter_awal')->nullable();
            $table->string('meter_akhir')->nullable();
            $table->string('hasil')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('lungsi')->nullable();
            $table->string('pakan')->nullable();
            $table->string('lubang')->nullable();
            $table->string('pgr')->nullable();
            $table->string('lebar')->nullable();
            $table->string('mesin')->nullable();
            $table->string('teknisi')->nullable();
            $table->string('status')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->timestamps();
            $table->index('mesin_id');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksiwjls');
    }
};
