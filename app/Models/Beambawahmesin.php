<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class Beambawahmesin extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $fillable = [
        'laporanbeaming_id',
        'slug',
        'tanggal',
        'beam_number',
        'jenis_produksi',
        'rajutan_lusi',
        'lebar_kain',
        'jumlah_benang',
        'lebar_benang',
        'denier',
        'beam_isi',
        'beam_sisa',
        'berat',
        'created_by',
        'updated_by',
        'deleted_by',
        'approved_by',
        'confirmed_by',
        'approved_at',
        'confirmed_at',
        'deleted_at'
    ];

    public function laporanbeaming(): BelongsTo
    {
        return $this->belongsTo(Laporanbeaming::class)->withDefault(['slug' => null]);
    }
}
