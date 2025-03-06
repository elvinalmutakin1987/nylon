<?php

namespace App\Http\Controllers;

use App\Models\Pengeringankain;
use App\Models\Pengeringankaindetail;
use App\Models\Produksiwjl;
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

class PengeringankainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produksiwjl.pengeringankain.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mesin_id = $request->mesin_id;
        $mesin = Mesin::find($mesin_id);
        $shift = $request->shift;
        $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d') ?? date('Y-m-d');
        $order = $request->order;
        $produksiwjl = Produksiwjl::where('mesin_id', $mesin_id)->where('shift', $shift)->where('tanggal', $tanggal)->first();
        $pengeringankain = Pengeringankain::where('wjl_tanggal', $tanggal)->where('wjl_shift', $shift)->where('mesin_id', $mesin_id)->first();
        if ($mesin_id == 'null' || $mesin_id == '') {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Pilih mesin!'
            ]);
        }
        if ($tanggal == 'null' || $tanggal == '') {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Pilih tanggal!'
            ]);
        }
        if ($shift == 'null' || $shift == '') {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Pilih shift!'
            ]);
        }
        if (!$produksiwjl) {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Data Produksi WJL tidak ada.'
            ]);
        }
        if (!$pengeringankain) {
            $pengeringankain = new Pengeringankain();
            $pengeringankain->produksiwjl_id = $produksiwjl->id;
            $pengeringankain->wjl_tanggal = $produksiwjl->tanggal;
            $pengeringankain->wjl_shift = $produksiwjl->shift;
            $pengeringankain->wjl_operator = $produkswjl->operator;
            $pengeringankain->wjl_jenis_kain = $produksiwjl->jenis_kain;
            $pengeringankain->tanggal = $tanggal;
            $pengeringankain->save();
        }
        if ($pengeringankain->status == 'Submit') {
            $action = "Edit";
            return view('produksiwjl.pengeringankain.show', compact('shift', 'tanggal', 'mesin_id', 'mesin', 'action', 'pengeringakain'));
        }
        return redirect()->back()->with([
            'status' => 'error',
            'message' => 'Laporan sudah di konfirmasi kepala regu / pengawas!'
        ]);
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
    public function show(Pengeringankain $pengeringankain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengeringankain $pengeringankain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengeringankain $pengeringankain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengeringankain $pengeringankain)
    {
        //
    }
}
