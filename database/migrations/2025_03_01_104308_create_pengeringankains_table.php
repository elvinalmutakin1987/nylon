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
        Schema::create('pengeringankains', function (Blueprint $table) {
            $table->id();
            $table->integer('produksiwjl_id')->nullable();
            $table->integer('mesin_id')->nullable();
            $table->string('slug')->nullable();
            $table->date('wjl_tanggal')->nullable();
            $table->string('wjl_shift')->nullable();
            $table->string('wjl_operator')->nullable();
            $table->string('wjl_jenis_kain')->nullable();
            $table->string('wjl_no_roll')->nullable();
            $table->string('wjl_kondisi_kain')->nullable();
            $table->string('wjl_panjang')->nullable();
            $table->string('wjl_lebar')->nullable();
            $table->string('wjl_berat')->nullable();
            $table->string('operator_1')->nullable();
            $table->date('tanggal_1')->nullable();
            $table->time('jam_1')->nullable();
            $table->string('kondisi_kain_1')->nullable();
            $table->string('lebar_1')->nullable();
            $table->string('panjang_1')->nullable();
            $table->string('berat_1')->nullable();
            $table->string('kecepatan_screw_1')->nullable();
            $table->string('kecepatan_winder_1')->nullable();
            $table->string('kondisi_kain2_1')->nullable();
            $table->string('operator_2')->nullable();
            $table->date('tanggal_2')->nullable();
            $table->time('jam_2')->nullable();
            $table->string('kondisi_kain_2')->nullable();
            $table->string('lebar_2')->nullable();
            $table->string('panjang_2')->nullable();
            $table->string('berat_2')->nullable();
            $table->string('kecepatan_screw_2')->nullable();
            $table->string('kecepatan_winder_2')->nullable();
            $table->string('kondisi_kain2_2')->nullable();
            $table->string('operator_3')->nullable();
            $table->date('tanggal_3')->nullable();
            $table->time('jam_3')->nullable();
            $table->string('kondisi_kain_3')->nullable();
            $table->string('lebar_3')->nullable();
            $table->string('panjang_3')->nullable();
            $table->string('berat_3')->nullable();
            $table->string('kecepatan_screw_3')->nullable();
            $table->string('kecepatan_winder_3')->nullable();
            $table->string('kondisi_kain2_3')->nullable();
            $table->string('status')->nullable();
            $table->string('created_by')->nullable();
            $table->string('created_by2')->nullable();
            $table->string('created_by3')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('updated_by2')->nullable();
            $table->string('updated_by3')->nullable();
            $table->string('deleted_by')->nullable();
            $table->string('deleted_by2')->nullable();
            $table->string('deleted_by3')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('confirmed_by')->nullable();
            $table->timestamps();
            $table->timestamp('created_at2')->nullable();
            $table->timestamp('created_at3')->nullable();
            $table->timestamp('updated_at2')->nullable();
            $table->timestamp('updated_at3')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('deleted_at2')->nullable();
            $table->timestamp('deleted_at3')->nullable();
            $table->index('produksiwjl_id');
            $table->index('mesin_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeringankains');
    }
};
