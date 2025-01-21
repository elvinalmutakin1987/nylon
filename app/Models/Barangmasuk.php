<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barangmasuk extends Model
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
        'packing_id',
        'referensi',
        'referensi_id',
        'no_dokumen',
        'gudang',
        'tanggal',
        'status',
        'catatan',
        'created_by',
        'updated_by',
        'deleted_by',
        'approved_by',
        'sent_by',
        'received_by',
        'created_at',
        'updated_at',
        'deleted_at',
        'approved_at',
        'sent_at',
        'received_at'
    ];

    public function barangmasukdetail(): HasMany
    {
        return $this->hasMany(Barangmasukdetail::class);
    }
}
