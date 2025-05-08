<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laporanrasheldetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $fillable = [
        'mesin_id',
        'laporanrashel_id',
        'slug',
        'tanggal',
        'shift',
        'jenis_produksi',
        'meter_awal',
        'meter_akhir',
        'hasil',
        'keterangan_produksi',
        'keterangan_mesin',
        'jam_stop',
        'jam_jalan',
        'lama_jalan',
        'operator',
        'teknisi',
        'status',
        'upload',
        'created_by',
        'updated_by',
        'deleted_by',
        'approved_by',
        'confirmed_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'approved_at',
        'confirmed_at'
    ];

    public function laporanrashel(): BelongsTo
    {
        return $this->belongsTo(Laporanrashel::class)->withDefault(['slug' => null]);
    }

    public function mesin(): BelongsTo
    {
        return $this->belongsTo(Mesin::class)->withDefault(['nama' => null]);
    }
}
