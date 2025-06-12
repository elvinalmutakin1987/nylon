<?php

namespace App\Exports;

use App\Models\Mesin;
use App\Models\Produksiwelding;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RekaplaporanweldingExport implements FromView
{
    public function __construct(String $tanggal_dari, String $tanggal_sampai)
    {
        $this->tanggal_dari = $tanggal_dari;
        $this->tanggal_sampai = $tanggal_sampai;
    }

    public function view(): View
    {
        $produksiwelding = Produksiwelding::whereDate('tanggal', '>=', $this->tanggal_dari)
            ->whereDate('tanggal', '<=', $this->tanggal_sampai)
            ->orderBy('tanggal', 'asc')
            ->get();
        return view('produksiwelding.rekap.export', [
            'produksiwjl' => $produksiwjl,
            'tanggal_dari' => $this->tanggal_dari,
            'tanggal_sampai' => $this->tanggal_sampai,
        ]);
    }
}
