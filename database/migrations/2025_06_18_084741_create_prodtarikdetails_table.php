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
        Schema::create('prodtarikdetails', function (Blueprint $table) {
            $table->id();
            $table->integer('prodtarik_id')->nullable();
            $table->integer('prodwelding_id')->nullable();
            $table->integer('prodlaminating_id')->nullable();
            $table->integer('mesin_id')->nullable();
            $table->integer('material_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('jenis')->nullable();
            $table->string('ukuran1')->nullable();
            $table->string('ukuran2')->nullable();
            $table->string('jumlah')->nullable();
            $table->string('total')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('confirmed_by')->nullable();
            $table->timestamps();
            $table->index('prodtarik_id');
            $table->index('prodwelding_id');
            $table->index('prodlaminating_id');
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
        Schema::dropIfExists('prodtarikdetails');
    }
};
