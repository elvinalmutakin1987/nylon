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
        Schema::create('pengaturanlaporans', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->string('divisi')->nullable();
            $table->string('dokumen')->nullable();
            $table->string('shift')->nullable();
            $table->time('dari')->nullable();
            $table->time('sampai')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturanlaporans');
    }
};
