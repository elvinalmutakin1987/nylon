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

    public function kontroldenier(): BelongsTo
    {
        return $this->belongsTo(Kontroldenier::class)->withDefault(['nama' => null]);
    }

    public function laporanrashel(): HasMany
    {
        return $this->hasMany(Laporanrashel::class);
    }

    public function laporansulzer(): HasMany
    {
        return $this->hasMany(Laporansulzer::class);
    }

    public function laporanrasheldetail(): HasMany
    {
        return $this->hasMany(Laporanrasheldetail::class);
    }

    public function laporansulzerdetail(): HasMany
    {
        return $this->hasMany(Laporansulzerdetail::class);
    }

    public function prodwjl(): HasMany
    {
        return $this->hasMany(Prodwjl::class);
    }

    public function prodlaminating(): HasMany
    {
        return $this->hasMany(Prodlaminating::class);
    }

    public function produksiwelding(): HasMany
    {
        return $this->hasMany(Produksiwelding::class);
    }

    public function produksitarik(): HasMany
    {
        return $this->hasMany(Produksitarik::class);
    }

    public function prodtarik(): HasMany
    {
        return $this->hasMany(Prodtarik::class);
    }

    public function prodtarikdetail(): HasMany
    {
        return $this->hasMany(Prodtarikdetail::class);
    }
}
