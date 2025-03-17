<?php

namespace App\Exports;

use App\Models\Kontroldenier;
use Maatwebsite\Excel\Concerns\FromCollection;

class KontroldenierExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Kontroldenier::all();
    }
}
