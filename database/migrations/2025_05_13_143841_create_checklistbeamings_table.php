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
        Schema::create('checklistbeamings', function (Blueprint $table) {
            $table->id();
            $table->integer('mesin_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('shift')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('motif_sesuai_1')->nullable();
            $table->string('motif_sesuai_2')->nullable();
            $table->string('motif_sesuai_3')->nullable();
            $table->string('motif_sesuai_4')->nullable();
            $table->string('motif_sesuai_5')->nullable();
            $table->string('motif_sesuai_6')->nullable();
            $table->string('motif_sesuai_7')->nullable();
            $table->string('jumlah_benang_putus')->nullable();
            $table->string('jumlah_benang')->nullable();
            $table->string('lebar_benang')->nullable();
            $table->text('keterangan_produksi')->nullable();
            $table->text('status')->nullable();
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
        Schema::dropIfExists('checklistbeamings');
    }
};
