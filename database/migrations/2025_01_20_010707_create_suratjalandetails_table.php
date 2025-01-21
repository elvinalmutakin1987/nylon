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
        Schema::create('suratjalandetails', function (Blueprint $table) {
            $table->id();
            $table->integer('suratjalan_id')->nullable();
            $table->integer('material_id')->nullable();
            $table->string('slug')->nullable();
            $table->decimal('jumlah', 16, 2)->nullable();
            $table->string('satuan')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->index('suratjalan_id');
            $table->index('material_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suratjalandetails');
    }
};
