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
        Schema::create('kontroldenierdetails', function (Blueprint $table) {
            $table->id();
            $table->integer('kontroldenier_id')->nullable();
            $table->string('slug')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('no_lokasi')->nullable();
            $table->string('nilai')->nullable();
            $table->string('rank')->nullable();
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
        Schema::dropIfExists('kontroldenierdetails');
    }
};
