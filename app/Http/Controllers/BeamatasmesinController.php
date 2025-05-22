<?php

namespace App\Http\Controllers;

use App\Models\Laporanbeaming;
use App\Models\Laporanbeamingdetail;
use App\Models\Laporanbeamingpanen;
use App\Models\Beamatasmesin;
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

class BeamatasmesinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $beamatasmesin = Beamatasmesin::all();
            return DataTables::of($beamatasmesin)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('produksiextruder.beamatasmesin.show', $item->slug) . '")"> <i class="fas fa-search"></i> Detail</a>
                            <a class="dropdown-item" href="' . route('produksiextruder.beamatasmesin.cetak', $item->slug) . '")"> <i class="fas fa-print"></i> Cetak</a>
                            <a class="dropdown-item" href="' . route('produksiextruder.beamatasmesin.edit', $item->slug) . '")"> <i class="fas fa-pencil-alt"></i> Edit</a>
                            <button class="dropdown-item" onClick="hapus(\'' . $item->slug . '\')"><i class="fas fa-trash"></i> Hapus</button>
                        </div>';
                })
                ->make();
        }
        return view('produksiextruder.beamatasmesin.index');
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
    public function show(Beamatasmesin $beamatasmesin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Beamatasmesin $beamatasmesin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Beamatasmesin $beamatasmesin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Beamatasmesin $beamatasmesin)
    {
        //
    }
}
