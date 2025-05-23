<?php

namespace App\Exports;

use App\Models\Beamatasmesin;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BeamatasmesinExport implements FromView
{
    public function view(): View
    {
        $beamatasmesin = Beamatasmesin::all();
        return view('produksiextruder.beamatasmesin.export', [
            'beamatasmesin' => $beamatasmesin,
        ]);
    }
}
