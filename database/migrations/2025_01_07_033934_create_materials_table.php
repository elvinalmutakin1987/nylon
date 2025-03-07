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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->integer('produk_id')->nullable();
            $table->integer('varian_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('sku')->nullable();
            $table->string('kode')->nullable();
            $table->string('nama')->nullable();
            $table->string('jenis')->nullable();
            $table->string('group')->nullable();
            $table->string('ukuran')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('bentuk')->nullable();
            $table->decimal('max_stok', 16, 2)->nullable();
            $table->decimal('min_stok', 16, 2)->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->index('produk_id');
            $table->index('varian_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
