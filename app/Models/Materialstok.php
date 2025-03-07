<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Materialstok extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'stok_akhir',
        'satuan',
        'keterangan'
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class)->withDefault(['nama' => null]);
    }
}
