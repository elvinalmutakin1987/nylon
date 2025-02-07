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
        Schema::create('suratjalans', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('no_dokumen')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('nama_toko')->nullable();
            $table->string('nopol')->nullable();
            $table->string('sopir')->nullable();
            $table->string('status')->nullable();
            $table->text('catatan')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('sent_by')->nullable();
            $table->text('foto')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->index('order_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suratjalans');
    }
};
