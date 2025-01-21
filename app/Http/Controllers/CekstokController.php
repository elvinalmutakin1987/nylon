<?php

namespace App\Http\Controllers;

use App\Models\Kartustok;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
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
            $material = Material::query();
            $material->where('jenis', $jenis)->get();
            return DataTables::of($material)
                ->addIndexColumn()
                ->addColumn('stok', function ($item) use ($gudang) {
                    $kartustok = Kartustok::where('material_id', $item->id)->where('gudang', $gudang)->orderBy('id', 'desc')->first();
                    return $kartustok ? $kartustok->stok_akhir : 0;
                })
                ->addColumn('action', function ($item) {
                    $button = '
                        <a type="button" class="btn btn-info" href="' . route('cekstok.show', $item->slug) . '")"><i
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
