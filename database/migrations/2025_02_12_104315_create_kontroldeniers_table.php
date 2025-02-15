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
        Schema::create('kontroldeniers', function (Blueprint $table) {
            $table->id();
            $table->integer('mesin_id')->nullable();
            $table->integer('material_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('panen_ke')->nullable();
            $table->time('jam')->nullable();
            $table->string('jenis_benang')->nullable();
            $table->string('denier')->nullable();
            $table->string('shift')->nullable();
            $table->string('operator')->nullable();
            $table->string('pengawas')->nullable();
            $table->string('nilai')->nullable();
            $table->string('kode')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status')->nullable();
            $table->string('order_shift')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('confirmed_by')->nullable();
            $table->timestamps();
            $table->index('material_id');
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
        Schema::dropIfExists('kontroldeniers');
    }
};
