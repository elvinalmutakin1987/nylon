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
        Schema::create('kartustoks', function (Blueprint $table) {
            $table->id();
            $table->integer('lokasi_id')->nullable();
            $table->integer('material_id')->nullable();
            $table->string('jenis')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('gudang')->nullable();
            $table->string('dokumen')->nullable();
            $table->string('dokumen_id')->nullable();
            $table->decimal('stok_awal', 16, 2)->nullable();
            $table->decimal('masuk', 16, 2)->nullable();
            $table->decimal('keluar', 16, 2)->nullable();
            $table->decimal('stok_akhir', 16, 2)->nullable();
            $table->string('satuan')->nullable();
            $table->text('catatan')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->index('lokasi_id');
            $table->index('material_id');
            $table->index('dokumen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kartustoks');
    }
};
