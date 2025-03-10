<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengeringankain extends Model
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
        'produksiwjl_id',
        'mesin_id',
        'wjl_tanggal',
        'wjl_shift',
        'wjl_operator',
        'wjl_jenis_kain',
        'wjl_no_roll',
        'wjl_kondisi_kain',
        'wjl_panjang',
        'wjl_lebar',
        'wjl_berat',
        'operator_1',
        'tanggal_1',
        'jam_1',
        'kondisi_kain_1',
        'lebar_1',
        'panjang_1',
        'berat_1',
        'kecepatan_screw_1',
        'kecepatan_winder_1',
        'kondisi_kain2_1',
        'operator_2',
        'tanggal_2',
        'jam_2',
        'kondisi_kain_2',
        'lebar_2',
        'panjang_2',
        'berat_2',
        'kecepatan_screw_2',
        'kecepatan_winder_2',
        'kondisi_kain2_2',
        'operator_3',
        'tanggal_3',
        'jam_3',
        'kondisi_kain_3',
        'lebar_3',
        'panjang_3',
        'berat_3',
        'kecepatan_screw_3',
        'kecepatan_winder_3',
        'kondisi_kain2_3',
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
        'confirmed_at',
    ];

    public function pengeringankaindetail(): HasMany
    {
        return $this->hasMany(Pengeringankaindetail::class);
    }

    public function produksiwjl(): BelongsTo
    {
        return $this->belongsTo(Produksiwjl::class)->withDefault(['slug' => null]);
    }
}
