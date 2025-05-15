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
        Schema::create('checklistbeamingdetails', function (Blueprint $table) {
            $table->id();
            $table->integer('checklistbeaming_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('diameter_beam_timur')->nullable();
            $table->string('diameter_beam_1m_dari_timur')->nullable();
            $table->string('diameter_beam_2m_dari_timur')->nullable();
            $table->string('diameter_beam_1m_dari_barat')->nullable();
            $table->string('diameter_beam_barat')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('confirmed_by')->nullable();
            $table->timestamps();
            $table->index('checklistbeaming_id');
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
        Schema::dropIfExists('checklistbeamingdetails');
    }
};
