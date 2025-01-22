<?php

namespace App\Http\Controllers;

use App\Models\Histori;
use App\Models\Kartustok;
use App\Models\Nomordokumen;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use NumConvert;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index()
    {
        return view('index');
    }

    public static function gen_slug()
    {
        return Str::random(32);
    }

    public static function unformat_angka(String $angka)
    {
        $val = str_replace(",", ".", $angka);
        $val = preg_replace("/[\,\.](\d{3})/", "$1", $val);
        return $val;
    }

    public static function gen_no_dokumen(String $dokumen)
    {
        $nomordokumen = Nomordokumen::where('dokumen', $dokumen)->where('tahun', date('Y'))->where('bulan', date('m'))->orderBy('id')->first();
        if (!$nomordokumen) {
            $nomordokumen = new nomordokumen();
            $prefix = 1;
        } else {
            $prefix = (int) $nomordokumen->prefix + 1;
        }
        $tanggal = date('Y-m-d');
        $tahun = date('Y');
        $bulan = date('m');
        $hari = date('d');
        $tahun_romawi = NumConvert::roman((int)$tahun);
        $bulan_romawi = NumConvert::roman((int)$bulan);
        $hari_romawi = NumConvert::roman((int)$hari);
        $nomor = $tahun . $bulan . '-' . str_pad($prefix, 5, '0', STR_PAD_LEFT);
        $nomordokumen->dokumen = $dokumen;
        $nomordokumen->nomor = $nomor;
        $nomordokumen->tanggal = date('Y-m-d');
        $nomordokumen->prefix = $prefix;
        $nomordokumen->bulan = $bulan;
        $nomordokumen->tahun = $tahun;
        $nomordokumen->hari = $hari;
        $nomordokumen->save();
        $data = [
            'nomor' => $nomor,
            'tanggal' => $tanggal,
            'prefix' => $prefix,
            'tahun' => $tahun,
            'bulan' => $bulan,
            'hari' => $hari,
            'tahun_romawi' => $tahun_romawi,
            'bulan_romawi' => $bulan_romawi,
            'hari_romawi' => $hari_romawi
        ];
        return $data;
    }

    public static function simpan_histori(String $dokumen, String $dokumen_id, String $keterangan)
    {
        $histori = new Histori();
        $histori->slug = Controller::gen_slug();
        $histori->dokumen = $dokumen;
        $histori->dokumen_id = $dokumen_id;
        $histori->user = Auth::user()->name;
        $histori->user_id = Auth::user()->id;
        $histori->keterangan = $keterangan;
        $histori->save();
    }

    public static function update_stok(String $jenis, String $gudang, String $dokumen, String $dokumen_id, String $material_id, String $jumlah, String $satuan)
    {
        $kartustok_akhir = Kartustok::where('material_id', $material_id)->where('gudang', $gudang)->where('satuan', $satuan)->orderBy('id', 'desc')->first();
        $stok_akhir = $kartustok_akhir ? $kartustok_akhir->stok_akhir : 0;
        $kartustok = new Kartustok();
        $kartustok->gudang = $gudang;
        $kartustok->dokumen = $dokumen;
        $kartustok->dokumen_id = $dokumen_id;
        $kartustok->jenis = $jenis;
        $kartustok->material_id = $material_id;
        if ($jenis == 'Masuk') {
            $kartustok->stok_awal = $stok_akhir;
            $kartustok->masuk = $jumlah;
            $kartustok->keluar = 0;
            $kartustok->stok_akhir = $stok_akhir + $jumlah;
        } else {
            $kartustok->stok_awal = $stok_akhir;
            $kartustok->masuk = 0;
            $kartustok->keluar = $jumlah;
            $kartustok->stok_akhir = $stok_akhir - $jumlah;
        }
        $kartustok->satuan = $satuan;
        $kartustok->created_by = Auth::user()->id;
        $kartustok->save();
    }
}
