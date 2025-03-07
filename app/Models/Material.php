<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
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
        'kode',
        'nama',
        'jenis',
        'group',
        'ukuran',
        'bentuk',
        'keterangan',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function permintaanmaterialdetail(): HasMany
    {
        return $this->hasMany(Permintaanmaterialdetail::class);
    }

    public function penerimaanbarangdetail(): HasMany
    {
        return $this->hasMany(Penerimaanbarangdetail::class);
    }

    public function kontroldenier(): HasMany
    {
        return $this->hasMany(Kontroldenier::class);
    }

    public function materialstok(): HasOne
    {
        return $this->hasMany(Materialstok::class);
    }
}
