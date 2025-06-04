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
        Schema::create('prodwjldetails', function (Blueprint $table) {
            $table->id();
            $table->integer('prodwjl_id')->nullable();
            $table->integer('material_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('satuan')->nullable()
            $table->string('satuan2')->nullable()
            $table->string('jumlah')->nullable()
            $table->string('jumlah2')->nullable()
            $table->timestamps();
            $table->index('prodwjl_id');
            $table->index('material_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodwjldetails');
    }
};
