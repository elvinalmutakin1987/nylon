<?php

namespace App\Http\Controllers;

use App\Models\Mesin;
use App\Models\Kontroldenier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Symfony\Component\Console\Input\Input;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;
use Intervention\Image\Drivers\Gd\Driver;

class RekapkontroldenierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produksiextruder.rekapdenier.index');
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
    public function show(Kontroldenier $kontroldenier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kontroldenier $kontroldenier)
    {
        return view('produksiextruder.rekapdenier.edit', compact('kontroldenier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kontroldenier $kontroldenier)
    {
        DB::beginTransaction();
        try {
            $lokasi = $request->lokasi;
            foreach ($request->no_lokasi as $key => $no_lokasi) {
                $detail[] = [
                    'kontroldenier_id' => $kontroldenier->id,
                    'slug' => Controller::gen_slug(),
                    'lokasi' => $lokasi,
                    'no_lokasi' => $no_lokasi,
                    'nilai' => $request->nilai[$key] ?? null,
                    'rank' => $request->rank[$key] ?? null,
                    'created_by' => Auth::user()->id
                ];
            }
            $kontroldenier->kontroldenierdetail()->delete();
            $kontroldenier->kontroldenierdetail()->createMany($detail);
            DB::commit();
            return redirect()->route('produksiextruder-kontrol-denier.index')->with([
                'status' => 'success',
                'message' => 'Data telah disimpan!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('error', compact('th'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kontroldenier $kontroldenier)
    {
        //
    }
}
