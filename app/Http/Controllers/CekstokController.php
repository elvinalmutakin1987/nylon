<?php

namespace App\Http\Controllers;

use App\Models\Kartustok;
use App\Models\Material;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Number as SupportNumber;
use Maatwebsite\Excel\Facades\Excel;

class CekstokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $jenis = '';
            $gudang = '';
            if (request()->gudang == 'bahan-baku') {
                $jenis = "Bahan Baku";
                $gudang = "Gudang Bahan Baku";
            } elseif (request()->gudang == 'benang') {
                $jenis = "Benang";
                $gudang = "Gudang Benang";
            } elseif (request()->gudang == 'barang-jadi') {
                $jenis = "Barang Jadi";
                $gudang = "Gudang Barang Jadi";
            } elseif (request()->gudang == 'bahan-penolong') {
                $jenis = "Bahan Baku";
                $gudang = "Gudang Bahan Baku";
            }

            $kartustok = Kartustok::query();
            $kartustok = $kartustok->select('material_id', 'satuan');
            $kartustok = $kartustok->groupBy('material_id', 'satuan');
            $kartustok = $kartustok->get();
            return DataTables::of($kartustok)
                ->addIndexColumn()
                ->addColumn('stok', function ($item) use ($gudang) {
                    $kartustok = Kartustok::where('material_id', $item->material_id)
                        ->where('gudang', $gudang)->where('satuan', $item->satuan)
                        ->orderBy('id', 'desc')
                        ->first();
                    return $kartustok ? SupportNumber::format((float) $kartustok->stok_akhir, precision: 1) : 0.0;
                })
                ->addColumn('nama', function ($item) {
                    $material = Material::find($item->material_id);
                    return $material->nama;
                })
                ->addColumn('action', function ($item) {
                    $material = Material::find($item->material_id);
                    $button = '
                        <a type="button" class="btn btn-info" href="' . route('cekstok.show', $material->slug) . '")"><i
                                class="fa fa-exchange"></i> Kartu Stok</a>
                        ';
                    return $button;
                })
                ->make();
        }
        if (request()->gudang == 'bahan-baku' || request()->gudang == 'bahan-penolong') {
            return view('gudangbahanbaku.cekstok.index');
        } elseif (request()->gudang == 'benang') {
            return view('gudangbenang.cekstok.index');
        } elseif (request()->gudang == 'barang-jadi') {
            return view('gudangbarangjadi.cekstok.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
