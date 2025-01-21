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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->string('no_order')->nullable();
            $table->string('nama_pemesan')->nullable();
            $table->date('tanggal')->nullable();
            $table->date('tanggal_kirim')->nullable();
            $table->text('alamat_kirim')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('jenis_barang')->nullable();
            $table->string('kode')->nullable();
            $table->string('progress')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
