<?php

namespace App\Exports;

use App\Models\Stockbeaming;
use App\Models\Stockgudang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StockgudangExport implements FromView
{
    public function __construct(String $export, String $posisi, String $status, String $stockbeaming_id)
    {
        $this->export = $export;
        $this->posisi = $posisi;
        $this->status = $status;
        $this->stockbeaming_id = $stockbeaming_id;
    }

    public function view(): View
    {
        if ($this->export == 'export') {
            $stockbeaming = Stockbeaming::query();
            if ($this->posisi != 'null' && $this->posisi != '' && $this->posisi != 'Semua') {
                $stockbeaming->where('posisi', $this->posisi);
            }
            if ($this->status != 'null' && $this->status != '' && $this->status != 'Semua') {
                $stockbeaming->where('status', $this->status);
            }
            $stockbeaming = $stockbeaming->get();
            return view('produksiextruder.stockbeaming.export', [
                'stockbeaming' => $stockbeaming
            ]);
        } else {
            $stockbeaming = Stockbeaming::find($this->stockbeaming_id);
            return view('produksiextruder.stockbeaming.export2', [
                'stockbeaming' => $stockbeaming
            ]);
        }
    }
}
