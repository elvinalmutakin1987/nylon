<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mesin extends Model
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
        'nama',
        'target_produksi',
        'lokasi_id',
        'keterangan',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at'
    ];

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class)->withDefault(['nama' => null]);
    }

    public function produksiwjl(): HasMany
    {
        return $this->hasMany(Produksiwjl::class);
    }
}
