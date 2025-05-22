<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laporanbeaming extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $fillable = [
        'slug',
        'tanggal',
        'nomor',
        'beam_number',
        'jenis_bahan',
        'warna_benang',
        'lembar_tenunan',
        'denier',
        'lebar_benang',
        'jenis_produksi',
        'jumlah_lungsi',
        'lebar_beam',
        'front_reed',
        'rear_reed',
        'traverse_reed',
        'benang_pinggiran_kiri',
        'benang_pinggiran_kanan',
        'benang_pinggiran_benang',
        'lebar_traverse',
        'kecepatan_beaming',
        'cut_mark',
        'panjang_press_roller',
        'tekanan_press_roller',
        'tension_roller_no_1',
        'tension_roller_no_2',
        'traverse_reed_design',
        'status',
        'keterangan',
        'created_by',
        'updated_by',
        'deleted_by',
        'approved_by',
        'confirmed_by',
        'nomor_sulzer',
        'tanggal_sulzer',
        'approved_at',
        'confirmed_at',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function laporanbeamingdetail(): HasMany
    {
        return $this->hasMany(Laporanbeamingdetail::class);
    }

    public function laporanbeamingpanen(): HasMany
    {
        return $this->hasMany(Laporanbeamingpanen::class);
    }

    public function beamatasmesin(): HasMany
    {
        return $this->hasMany(Beamatasmesin::class);
    }

    public function beambawahmesin(): HasMany
    {
        return $this->hasMany(Beambawahmesin::class);
    }
}
