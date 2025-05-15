<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checklistbeaming extends Model
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
        'slug',
        'tanggal',
        'shift',
        'motif_sesuai_1',
        'motif_sesuai_2',
        'motif_sesuai_3',
        'motif_sesuai_4',
        'motif_sesuai_5',
        'motif_sesuai_6',
        'motif_sesuai_7',
        'jumlah_benang_putus',
        'jumlah_benang',
        'lebar_benang',
        'keterangan_produksi',
        'created_by',
        'updated_by',
        'deleted_by',
        'approved_by',
        'confirmed_by',
        'approved_at',
        'confirmed_at',
        'deleted_at'
    ];

    public function checklistbeamingdetail(): HasMany
    {
        return $this->hasMany(Checklistbeamingdetail::class);
    }

    public function mesin(): BelongsTo
    {
        return $this->belongsTo(Mesin::class)->withDefault(['slug' => null]);
    }
}
