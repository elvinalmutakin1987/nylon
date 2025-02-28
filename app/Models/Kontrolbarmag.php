<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kontrolbarmag extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $fillable = [
        'mesin_id',
        'slug',
        'tanggal',
        'pengawas',
        'shift',
        'melt_flow',
        'jenis_produksi',
        'bahan_campuran',
        'pengetesan_mesin',
        'lebar_spacer',
        'lebar_benang_jadi',
        'jumlah_benang_jadi',
        'denier',
        'srt',
        'tebal_film',
        'screw_rpm',
        'take_of_speed',
        'godet_1_rpm',
        'godet_2_rpm',
        'godet_3_rpm',
        'cylinder_1',
        'cylinder_2',
        'cylinder_3',
        'adaptor_1',
        'long_life_filter',
        'dies_1',
        'dies_2',
        'dies_3',
        'olie_g2roll_45',
        'olie_g2roll_67',
        'temp_oven_1',
        'temp_oven_2',
        'temp_pendingin_film',
        'bak_air',
        'cyller',
        'keterangan',
        'status',
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

    public function kontrolbarmagdetail(): HasMany
    {
        return $this->hasMany(kontrolbarmagdetail::class);
    }
}
