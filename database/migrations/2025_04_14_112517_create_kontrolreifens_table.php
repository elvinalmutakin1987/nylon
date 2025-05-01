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
        Schema::create('kontrolreifens', function (Blueprint $table) {
            $table->id();
            $table->integer('mesin_id')->nullable();
            $table->string('slug')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('pengawas')->nullable();
            $table->string('shift')->nullable();
            $table->string('jenis')->nullable();
            $table->string('melt_flow')->nullable();
            $table->string('jenis_produksi')->nullable();
            $table->string('bahan_campuran')->nullable();
            $table->string('pengetesan_mesin')->nullable();
            $table->string('lebar_spacer')->nullable();
            $table->string('lebar_benang_jadi')->nullable();
            $table->string('jumlah_benang_jadi')->nullable();
            $table->string('denier')->nullable();
            $table->string('srt')->nullable();
            $table->string('tebal_film')->nullable();
            $table->string('screw_rpm')->nullable();
            $table->string('godet_1_rpm')->nullable();
            $table->string('godet_2_rpm')->nullable();
            $table->string('cylinder_1')->nullable();
            $table->string('cylinder_2')->nullable();
            $table->string('cylinder_3')->nullable();
            $table->string('cylinder_4')->nullable();
            $table->string('adaptor_1')->nullable();
            $table->string('adaptor_2')->nullable();
            $table->string('adaptor_3')->nullable();
            $table->string('dies_1')->nullable();
            $table->string('dies_2')->nullable();
            $table->string('dies_3')->nullable();
            $table->string('dies_4')->nullable();
            $table->string('dies_5')->nullable();
            $table->string('dies_6')->nullable();
            $table->string('dies_7')->nullable();
            $table->string('melt_presure')->nullable();
            $table->string('melt_temperatur')->nullable();
            $table->string('faltur_indicator')->nullable();
            $table->string('temp_olie_godet_2')->nullable();
            $table->string('temp_oven')->nullable();
            $table->string('temp_pendingin_film')->nullable();
            $table->string('bak_air')->nullable();
            $table->string('cylinder')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('status')->nullable();
            $table->string('upload')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('confirmed_by')->nullable();
            $table->timestamps();
            $table->index('mesin_id');
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
        Schema::dropIfExists('kontrolreifens');
    }
};
