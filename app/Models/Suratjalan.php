<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class Suratjalan extends Model
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
        'order_id',
        'no_dokumen',
        'tanggal',
        'status',
        'nama_toko',
        'catatan',
        'nopol',
        'sopir',
        'created_by',
        'updated_by',
        'deleted_by',
        'approved_by',
        'sent_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'approved_at',
        'sent_at'
    ];

    public function suratjalandetail(): HasMany
    {
        return $this->hasMany(Suratjalandetail::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class)->withDefault(['no_dokumen' => null]);
    }
}
