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
        Schema::create('mesins', function (Blueprint $table) {
            $table->id();
            $table->integer('lokasi_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('nama')->nullable();
            $table->string('bagian')->nullable();
            $table->string('target_produksi')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('d_plus_top')->nullable();
            $table->string('d_plus_bottom')->nullable();
            $table->string('d_top')->nullable();
            $table->string('d_bottom')->nullable();
            $table->string('n_top')->nullable();
            $table->string('n_bottom')->nullable();
            $table->string('k_top')->nullable();
            $table->string('k_bottom')->nullable();
            $table->string('k_min_top')->nullable();
            $table->string('k_min_bottom')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->index('lokasi_id');
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesins');
    }
};
