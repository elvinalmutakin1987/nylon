<?php

namespace App\Exports;

use App\Models\Material;
use App\Models\Materialstok;
use App\Models\Kartustok;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporangudangExport implements FromView
{
    public function __construct(String $tanggal, String $jenis, String $bentuk)
    {
        $this->tanggal = $tanggal;
        $this->jenis = $jenis;
        $this->bentuk = $bentuk;
    }

    public function view(): View
    {
        $tanggal = $this->tanggal;
        $jenis = $this->jenis;
        $bentuk = $this->bentuk;
        return view('laporangudang.barangjadi.export', [
            'tanggal' => $tanggal,
            'jenis' => $this->jenis,
            'bentuk' => $this->bentuk,
        ]);
    }
}
