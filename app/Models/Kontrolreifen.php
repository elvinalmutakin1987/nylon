<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kontrolreifen extends Model
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
        'godet_1_rpm',
        'godet_2_rpm',
        'cylinder_1',
        'cylinder_2',
        'cylinder_3',
        'cylinder_4',
        'adaptor_1',
        'adaptor_2',
        'adaptor_3',
        'dies_1',
        'dies_2',
        'dies_3',
        'dies_4',
        'dies_5',
        'dies_6',
        'dies_7',
        'melt_presure',
        'melt_temperatur',
        'faltur_indicator',
        'temp_olie_godet_2',
        'temp_oven',
        'temp_pendingin_film',
        'bak_air',
        'cylinder',
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

    public function kontrolreifendetail(): HasMany
    {
        return $this->hasMany(Kontrolreifendetail::class);
    }
}
