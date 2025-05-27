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
        Schema::create('stockbemaingdetails', function (Blueprint $table) {
            $table->id();
            $table->integer('stockbeaming_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('shift')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('posisi')->nullable();
            $table->string('operator')->nullable();
            $table->string('meter')->nullable();
            $table->string('jam')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('confirmed_by')->nullable();
            $table->timestamps();
            $table->index('stockbeaming_id');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stockbemaingdetails');
    }
};
