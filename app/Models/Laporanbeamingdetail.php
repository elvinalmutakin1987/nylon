<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laporanbeamingdetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $fillable = [
        'laporanbeaming_id',
        'slug',
        'tanggal',
        'shift',
        'meter_awal',
        'meter_akhir',
        'meter_hasil',
        'rata',
        'pinggiran_terjepit',
        'benang_hilang',
        'salah_motif',
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

    public function laporanbeaming(): BelongsTo
    {
        return $this->belongsTo(Laporanbeaming::class)->withDefault(['slug' => null]);
    }
}
