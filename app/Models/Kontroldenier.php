<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kontroldenier extends Model
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
        'material_id',
        'mesin_id',
        'tanggal',
        'panen_ke',
        'jam',
        'jenis_benang',
        'denier',
        'shift',
        'operator',
        'pengawas',
        'nilai',
        'kode',
        'keterangan',
        'status',
        'order_shift',
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

    public function kontroldenierdetail(): HasMany
    {
        return $this->hasMany(Kontroldenierdetail::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class)->withDefault(['nama' => null]);
    }

    public function mesin(): BelongsTo
    {
        return $this->belongsTo(Mesin::class)->withDefault(['nama' => null]);
    }
}
