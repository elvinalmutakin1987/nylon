<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stockbemaingdetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $fillable = [
        'stockbeaming_id',
        'slug',
        'shift',
        'tanggal',
        'posisi',
        'operator',
        'meter',
        'created_by',
        'updated_by',
        'deleted_by',
        'approved_by',
        'confirmed_by',
        'approved_at',
        'confirmed_at',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function stockbeaming(): BelongsTo
    {
        return $this->belongsTo(Stockbeaming::class)->withDefault(['slug' => null]);
    }
}
