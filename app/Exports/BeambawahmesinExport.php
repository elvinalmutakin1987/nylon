<?php

namespace App\Exports;

use App\Models\Beambawahmesin;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BeambawahmesinExport implements FromView
{
    public function view(): View
    {
        $beambawahmesin = Beambawahmesin::all();
        return view('produksiextruder.beambawahmesin.export', [
            'beambawahmesin' => $beambawahmesin,
        ]);
    }
}
