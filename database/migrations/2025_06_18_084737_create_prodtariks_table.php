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
        Schema::create('prodtariks', function (Blueprint $table) {
            $table->id();
            $table->integer('prodwelding_id')->nullable();
            $table->integer('mesin_id')->nullable();
            $table->string('slug')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('shift')->nullable();
            $table->string('operator')->nullable();
            $table->string('nomor')->nullable();
            $table->string('nomor_roll')->nullable();
            $table->string('nomor_so')->nullable();
            $table->string('status')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('confirmed_by')->nullable();
            $table->integer('material_id')->nullable();
            $table->string('satuan')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('satuan2')->nullable();
            $table->string('jumlah2')->nullable();
            $table->date('tanggal_panen')->nullable();
            $table->text('keterangan_panen')->nullable();
            $table->timestamps();
            $table->index('mesin_id');
            $table->index('material_id');
            $table->index('prodwelding_id');
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
        Schema::dropIfExists('prodtariks');
    }
};
