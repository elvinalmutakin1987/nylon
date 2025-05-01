<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Carbon\Carbon;
use App\Models\Kontrolbarmag;
use App\Models\Kontrolbarmagdetail;
use App\Models\Kontrolreifen;
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


class KontrolreifenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produksiextruder.kontrolreifen.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $shift = $request->shift;
        $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d') ?? date('Y-m-d');
        $shift_sebelumnya = '';
        if ($shift == 'Pagi') {
            $shift_sebelumnya = 'Malam';
            $tanggal_sebelumnya = Carbon::parse($tanggal)->subDays(1)->format('Y-m-d');
        } elseif ($shift == 'Sore') {
            $shift_sebelumnya = 'Pagi';
            $tanggal_sebelumnya = $tanggal;
        } elseif ($shift == 'Malam') {
            $shift_sebelumnya = 'Sore';
            $tanggal_sebelumnya = $tanggal;
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

        $kontrolreifen = Kontrolreifen::where('tanggal', $tanggal)
            ->where('shift', $shift)
            ->first();

        $kontrolreifen_sebelumnya = kontrolreifen::where('tanggal', $tanggal_sebelumnya)
            ->where('shift', $shift_sebelumnya)
            ->first();

        $action = 'create';
        if (!$kontrolreifen) {
            $shift = $request->shift;
            $tanggal = $request->tanggal;
            $kontrolreifen = Kontrolreifen::where('shift', $shift)->where('tanggal', $tanggal)->where('status', 'Draft')->first();
            if (!$kontrolreifen) {
                $kontrolreifen = new Kontrolreifen();
                $kontrolreifen->slug = Controller::gen_slug();
                $kontrolreifen->shift = $shift;
                $kontrolreifen->tanggal = $tanggal;
                $kontrolreifen->status = 'Draft';
                $kontrolreifen->save();
            }
            $action = 'create';
            return view('produksiextruder.kontrolreifen.show', compact('shift', 'tanggal', 'action', 'kontrolreifen', 'kontrolreifen_sebelumnya'));
        }

        if ($kontrolreifen->status == 'Draft') {
            $action = 'edit';
            return view('produksiextruder.kontrolreifen.show', compact('shift', 'tanggal', 'action', 'kontrolreifen', 'kontrolreifen_sebelumnya'));
        }

        return redirect()->back()->with([
            'status' => 'error',
            'message' => 'Laporan sudah di konfirmasi!'
        ]);
    }

    public function create_laporan(Request $request)
    {
        $shift = $request->shift;
        $tanggal = $request->tanggal;
        $kontrolreifen = Kontrolreifen::where('shift', $shift)->where('tanggal', $tanggal)->where('status', 'Draft')->first();
        if (!$kontrolreifen) {
            $kontrolreifen = new Kontrolreifen();
            $kontrolreifen->slug = Controller::gen_slug();
            $kontrolreifen->shift = $shift;
            $kontrolreifen->tanggal = $tanggal;
            $kontrolreifen->status = 'Draft';
            $kontrolreifen->save();
        }
        return view('produksiextruder.kontrolreifen.create', compact('shift', 'tanggal', 'kontrolreifen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function store_laporan(Request $request)
    {
        $shift = $request->shift;
        $tanggal = $request->tanggal;
        $kontrolreifen = Kontrolreifen::find($request->kontrolreifen_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kontrolreifen $kontrolreifen)
    {
        $shift = $kontrolbarmag->shift;
        $tanggal = $kontrolbarmag->tanggal;
        return view('produksiextruder.kontrolreifen.edit', compact('shift', 'tanggal', 'kontrolreifen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kontrolreifen $kontrolreifen)
    {
        $shift = $kontrolreifen->shift;
        $tanggal = $kontrolreifen->tanggal;
        return view('produksiextruder.kontrolreifen.edit', compact('shift', 'tanggal', 'kontrolreifen'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kontrolreifen $kontrolreifen)
    {
        DB::beginTransaction();
        try {
            $kontrolreifen->pengawas = $request->pengawas;
            $kontrolreifen->jenis = $request->jenis;
            $kontrolreifen->melt_flow = $request->melt_flow;
            $kontrolreifen->jenis_produksi = $request->jenis_produksi;
            $kontrolreifen->bahan_campuran = $request->bahan_campuran;
            $kontrolreifen->pengetesan_mesin = $request->pengetesan_mesin;
            $kontrolreifen->lebar_spacer = $request->lebar_spacer;
            $kontrolreifen->lebar_benang_jadi = $request->lebar_benang_jadi;
            $kontrolreifen->jumlah_benang_jadi = $request->jumlah_benang_jadi;
            $kontrolreifen->denier = $request->denier;
            $kontrolreifen->srt = $request->srt;
            $kontrolreifen->tebal_film = $request->tebal_film;
            $kontrolreifen->screw_rpm = $request->screw_rpm;
            $kontrolreifen->godet_1_rpm = $request->godet_1_rpm;
            $kontrolreifen->godet_2_rpm = $request->godet_2_rpm;
            $kontrolreifen->cylinder_1 = $request->cylinder_1;
            $kontrolreifen->cylinder_2 = $request->cylinder_2;
            $kontrolreifen->cylinder_3 = $request->cylinder_3;
            $kontrolreifen->cylinder_4 = $request->cylinder_4;
            $kontrolreifen->adaptor_1 = $request->adaptor_1;
            $kontrolreifen->adaptor_2 = $request->adaptor_2;
            $kontrolreifen->adaptor_3 = $request->adaptor_3;
            $kontrolreifen->dies_1 = $request->dies_1;
            $kontrolreifen->dies_2 = $request->dies_2;
            $kontrolreifen->dies_3 = $request->dies_3;
            $kontrolreifen->dies_4 = $request->dies_4;
            $kontrolreifen->dies_5 = $request->dies_5;
            $kontrolreifen->dies_6 = $request->dies_6;
            $kontrolreifen->dies_7 = $request->dies_7;
            $kontrolreifen->melt_presure = $request->melt_presure;
            $kontrolreifen->melt_temperatur = $request->melt_temperatur;
            $kontrolreifen->faltur_indicator = $request->faltur_indicator;
            $kontrolreifen->temp_olie_godet_2 = $request->temp_olie_godet_2;
            $kontrolreifen->temp_oven = $request->temp_oven;
            $kontrolreifen->temp_pendingin_film = $request->temp_pendingin_film;
            $kontrolreifen->bak_air = $request->bak_air;
            $kontrolreifen->cylinder = $request->cylinder;
            $kontrolreifen->keterangan = $request->keterangan;
            $kontrolreifen->updated_by = Auth::user()->id;
            $kontrolreifen->save();
            DB::commit();
            return redirect()->route('produksiextruder-kontrol-reifen.index')->with([
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
    public function destroy(Kontrolreifen $kontrolreifen)
    {
        //
    }

    public function cek_sebelumnya(Request $request)
    {
        $mesin_id = $request->mesin_id;
        $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d') ?? date('Y-m-d');
        $shift = $request->shift;
        if ($shift == 'Pagi') {
            $shift = "Malam";
            $tanggal = Carbon::parse($tanggal)->subDays(1)->format('Y-m-d');
        } elseif ($shift == 'Sore') {
            $shift = "Pagi";
        } elseif ($shitf == 'Malam') {
            $shift = "Sore";
        }
        $kontrolreifen = Kontrolreifen::where('tanggal', $tanggal)->where('shift', $shift)->where('mesin_id', $mesin_id)->first();
        return response()->json([
            'status' => 'success',
            'data' => $produksiwjl,
            'message' => 'success'
        ]);
    }

    public function confirm(Request $request, Kontrolreifen $kontrolreifen)
    {
        return view('produksiextruder.kontrolreifen.confirm');
    }
}
