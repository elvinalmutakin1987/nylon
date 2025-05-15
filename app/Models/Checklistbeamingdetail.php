<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checklistbeamingdetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $fillable = [
        'checklistbeaming_id',
        'slug',
        'diameter_beam_timur',
        'diameter_beam_1m_dari_timur',
        'diameter_beam_2m_dari_timur',
        'diameter_beam_1m_dari_barat',
        'diameter_beam_barat',
        'created_by',
        'updated_by',
        'deleted_by',
        'approved_by',
        'confirmed_by',
        'approved_at',
        'confirmed_at',
        'deleted_at'
    ];

    public function checklistbeaming(): BelongsTo
    {
        return $this->belongsTo(Checklistbeaming::class)->withDefault(['slug' => null]);
    }
}
