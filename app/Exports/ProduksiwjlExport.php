<?php

namespace App\Exports;

use App\Models\Mesin;
use App\Models\Produksiwjl;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProduksiwjlExport implements FromView
{
    public function __construct(String $tanggal_dari, String $tanggal_sampai, String $mesin_id)
    {
        $this->tanggal_dari = $tanggal_dari;
        $this->tanggal_sampai = $tanggal_sampai;
        $this->mesin_id = $mesin_id;
    }

    public function view(): View
    {
        $mesin = Mesin::find($this->mesin_id);
        $produksiwjl = Produksiwjl::where('mesin_id', '=', $this->mesin_id)
            ->whereDate('tanggal', '>=', $this->tanggal_dari)
            ->whereDate('tanggal', '<=', $this->tanggal_sampai)
            ->orderBy('tanggal', 'asc')
            ->orderBy('order_shift', 'asc')
            ->get();
        return view('produksiwjl.rekap.export', [
            'produksiwjl' => $produksiwjl,
            'tanggal_dari' => $this->tanggal_dari,
            'tanggal_sampai' => $this->tanggal_sampai,
            'mesin_id' => $this->mesin_id,
            'mesin' => $mesin
        ]);
    }
}
