<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prodwjl extends Model
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
        'shift',
        'operator',
        'tanggal',
        'nomor',
        'nomor_roll',
        'nomor_so',
        'status',
        'keterangan',
        'created_by',
        'updated_by',
        'deleted_by',
        'approved_by',
        'confirmed_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'approved_at',
        'confirmed_at',
        'material_id',
        'satuan',
        'jumlah',
        'satuan2',
        'jumlah2'
    ];

    public function prodwjldetail(): HasMany
    {
        return $this->hasMany(Prodwjldetail::class);
    }

    public function mesin(): BelongsTo
    {
        return $this->belongsTo(Mesin::class)->withDefault(['slug' => null]);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class)->withDefault(['slug' => null]);
    }

    public function prodlaminating(): HasMany
    {
        return $this->hasMany(Prodlaminating::class);
    }
}
