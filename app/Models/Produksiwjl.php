<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produksiwjl extends Model
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
        'mesin_id',
        'tanggal',
        'jenis_kain',
        'operator',
        'shift',
        'meter_awal',
        'meter_akhir',
        'hasil',
        'keterangan',
        'lungsi',
        'pakan',
        'lubang',
        'pgr',
        'lebar',
        'mesin',
        'teknisi',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
