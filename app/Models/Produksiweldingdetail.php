<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produksiweldingdetail extends Model
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
        'produksiwelding_id',
        'material_id',
        'jenis',
        'ukuran1',
        'ukuran2',
        'jumlah',
        'total',
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
        'confirmed_at'
    ];

    public function produksiwelding(): BelongsTo
    {
        return $this->belongsTo(Produksiwelding::class)->withDefault(['slug' => null]);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class)->withDefault(['nama' => null]);
    }
}
