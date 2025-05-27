<?php

namespace App\Http\Controllers;

use App\Models\Laporanbeaming;
use App\Models\Laporanbeamingdetail;
use App\Models\Stockbeaming;
use App\Models\Stockbemaingdetail;
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

class StockbeamingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $stockbeaming = Stockbeaming::query();
            if (request()->posisi != 'null' && request()->posisi != '' && request()->posisi != 'Semua') {
                $stockbeaming->where('posisi', request()->posisi);
            }
            if (request()->status != 'null' && request()->status != '' && request()->status != 'Semua') {
                $stockbeaming->where('status', request()->status);
            }
            $stockbeaming = $stockbeaming->get();
            return DataTables::of($stockbeaming)
                ->addIndexColumn()
                ->addColumn('beam_number', function ($item) {
                    $laporanbeaming = Laporanbeaming::find($item->laporanbeaming_id);
                    return $laporanbeaming ? $laporanbeaming->beam_number : null;
                })
                ->addColumn('tanggal_panen', function ($item) {
                    $laporanbeaming = Laporanbeaming::find($item->laporanbeaming_id);
                    return $laporanbeaming ? $laporanbeaming->tanggal : null;
                })
                ->addColumn('meter', function ($item) {
                    $stockbeamingdetail = Stockbemaingdetail::where('stockbeaming_id', $item->id)->sum('meter');
                    return $stockbeamingdetail ? $stockbeamingdetail->meter : "0";
                })
                ->addColumn('action', function ($item) {
                    if ($item->status == 'Aktif') {
                        $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('produksiextruder.stockbeaming.beamnaik', $item->slug) . '")"> <i class="fas fa-arrow-up"></i> Beam Naik</a>
                            <a class="dropdown-item" href="' . route('produksiextruder.stockbeaming.beamnaik', $item->slug) . '")"> <i class="fas fa-arrow-down"></i> Beam Turun</a>
                            <a class="dropdown-item" href="' . route('produksiextruder.stockbeaming.edit', $item->slug) . '")"> <i class="fas fa-pencil-alt"></i> Update Meter</a>
                            <button class="dropdown-item" onClick="hapus(\'' . $item->slug . '\')"><i class="fas fa-trash"></i> Tidak Aktif</button>
                        </div>';
                    } else {
                        $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('produksiextruder.stockbeaming.show', $item->slug) . '")"> <i class="fas fa-search"></i> Detail</a>
                        </div>';
                    }
                    return $button;
                })
                ->make();
        }
        return view('produksiextruder.stockbeaming.index');
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
    public function show(Stockbeaming $stockbeaming)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stockbeaming $stockbeaming)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stockbeaming $stockbeaming)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stockbeaming $stockbeaming)
    {
        DB::beginTransaction();
        try {
            $stockbeaming->status = 'Tidak Aktif';
            $stockbeaming->save();
            DB::commit();
            return redirect()->route('produksiextruder.stockbeaming.index')->with([
                'status' => 'success',
                'message' => 'Data telah dihapus!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('error', compact('th'));
        }
    }

    public function beamnaik(Stockbeaming $stockbeaming)
    {
        // Uncomment the line below to return the view for beam naik
        return view('produksiextruder.stockbeaming.beamnaik', compact('stockbeaming'));
    }

    public function beamturun(Stockbeaming $stockbeaming)
    {
        return view('produksiextruder.stockbeaming.beamturun', compact('stockbeaming'));
    }

    public function update_beamnaik(Request $request, Stockbeaming $stockbeaming)
    {
        DB::beginTransaction();
        try {
            $stockbeamingdetail = new Stockbemaingdetail();
            $stockbeamingdetail->stockbeaming_id = $stockbeaming->id;
            $stockbeamingdetail->slug = Str::slug($stockbeaming->slug . '-' . Str::random(5));
            $stockbeamingdetail->shift = $request->shift;
            $stockbeamingdetail->tanggal = $request->tanggal;
            $stockbeamingdetail->posisi = 'Atas';
            $stockbeamingdetail->operator = $request->operator;
            $stockbeamingdetail->meter = $request->meter ? Controller::unformat_angka($request->meter) : 0;
            $stockbeamingdetail->keterangan = $request->keterangan;
            $stockbeamingdetail->created_by = Auth::user()->name;
            $stockbeamingdetail->save();
            $stockbeaming->posisi = 'Atas';
            $stockbeaming->save();
            DB::commit();
            return redirect()->route('produksiextruder.stockbeaming.index')->with([
                'status' => 'success',
                'message' => 'Data telah dihapus!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('error', compact('th'));
        }
    }

    public function update_beamturun(Request $request, Stockbeaming $stockbeaming)
    {
        DB::beginTransaction();
        try {
            $stockbeamingdetail = new Stockbemaingdetail();
            $stockbeamingdetail->stockbeaming_id = $stockbeaming->id;
            $stockbeamingdetail->slug = Str::slug($stockbeaming->slug . '-' . Str::random(5));
            $stockbeamingdetail->shift = $request->shift;
            $stockbeamingdetail->tanggal = $request->tanggal;
            $stockbeamingdetail->posisi = 'Bawah';
            $stockbeamingdetail->operator = $request->operator;
            $stockbeamingdetail->meter = $request->meter ? Controller::unformat_angka($request->meter) : 0;
            $stockbeamingdetail->keterangan = $request->keterangan;
            $stockbeamingdetail->created_by = Auth::user()->name;
            $stockbeamingdetail->save();
            $stockbeaming->posisi = 'Bawah';
            $stockbeaming->save();
            DB::commit();
            return redirect()->route('produksiextruder.stockbeaming.index')->with([
                'status' => 'success',
                'message' => 'Data telah dihapus!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('error', compact('th'));
        }
    }
}
