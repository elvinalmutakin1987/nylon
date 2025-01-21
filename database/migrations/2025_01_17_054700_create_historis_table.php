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
        Schema::create('historis', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('dokumen')->nullable();
            $table->string('dokumen_id')->nullable();
            $table->string('user')->nullable();
            $table->string('keterangan');
            $table->timestamp('waktu')->nullable();
            $table->timestamps();
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historis');
    }
};
