<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
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
        'no_order',
        'nama_pemesan',
        'tanggal',
        'kode',
        'alamat_kirim',
        'keterangan',
        'progress',
        'status',
        'jenis_barang',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function orderdetail(): HasMany
    {
        return $this->hasMany(Orderdetail::class);
    }

    public function ordercatatan(): HasMany
    {
        return $this->hasMany(Ordercatatan::class);
    }

    public function suratjalan(): HasMany
    {
        return $this->hasMany(Suratjalan::class);
    }
}
