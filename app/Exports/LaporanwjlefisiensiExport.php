<?php

namespace App\Exports;

use App\Models\Produksiwjl;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanwjlefisiensiExport implements FromView
{
    public function __construct(String $tanggal_dari, String $tanggal_sampai, String $operator)
    {
        $this->tanggal_dari = $tanggal_dari;
        $this->tanggal_sampai = $tanggal_sampai;
        $this->operator = $operator;
    }

    public function view(): View
    {
        $tanggal_dari = $this->tanggal_dari;
        $tanggal_sampai = $this->tanggal_sampai;
        $operator = $this->operator;
        $produksiwjl = Produksiwjl::where('operator', '=', $this->operator)
            ->whereDate('tanggal', '>=', $this->tanggal_dari)
            ->whereDate('tanggal', '<=', $this->tanggal_sampai)
            ->orderBy('tanggal', 'asc')
            ->orderBy('mesin_id', 'asc')
            ->get();
        return view('laporanwjlefisiensi.export', [
            'tanggal_dari' => $tanggal_dari,
            'tanggal_sampai' => $tanggal_sampai,
            'operator' => $operator,
            'produksiwjl' => $produksiwjl
        ]);
    }
}
