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
        Schema::create('produksiextruders', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->date('tanggal')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('b_plus')->nullable();
            $table->string('b')->nullable();
            $table->string('n')->nullable();
            $table->string('k')->nullable();
            $table->string('k_min')->nullable();
            $table->string('netto')->nullable();
            $table->string('status')->nullable();
            $table->string('order_shift')->nullable();
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
        Schema::dropIfExists('produksiextruders');
    }
};
