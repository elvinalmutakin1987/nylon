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
        Schema::create('penerimaanbarangs', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->string('no_dokumen')->nullable();
            $table->string('sj_supplier')->nullable();
            $table->string('supplier')->nullable();
            $table->string('nama_sopir')->nullable();
            $table->string('plat_nomor')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('status')->nullable();
            $table->text('catatan')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('sent_by')->nullable();
            $table->string('received_by')->nullable();
            $table->text('foto')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('received_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaanbarangs');
    }
};
