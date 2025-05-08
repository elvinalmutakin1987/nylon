<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Laporansulzer;
use App\Models\Mesin;
use Carbon\Carbon;
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

class LaporansulzerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produksiextruder.laporansulzer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $mesin_id = $request->mesin_id;
        $shift = $request->shift;
        $mesin = Mesin::find($mesin_id);
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

        if ($mesin_id == 'null' || $mesin_id == '') {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Pilih mesin!'
            ]);
        }

        $laporansulzer = Laporansulzer::where('tanggal', $tanggal)
            ->where('shift', $shift)
            ->where('mesin_id', $mesin_id)
            ->first();

        $laporansulzer_sebelumnya = Laporansulzer::where('tanggal', $tanggal_sebelumnya)
            ->where('shift', $shift_sebelumnya)
            ->where('mesin_id', $mesin_id)
            ->first();

        $action = 'create';
        if (!$laporansulzer) {
            $shift = $request->shift;
            $tanggal = $request->tanggal;
            $laporansulzer = Laporansulzer::where('shift', $shift)->where('tanggal', $tanggal)->where('mesin_id', $mesin_id)->where('status', 'Draft')->first();
            if (!$laporansulzer) {
                $laporansulzer = new Laporansulzer();
                $laporansulzer->slug = Controller::gen_slug();
                $laporansulzer->shift = $shift;
                $laporansulzer->tanggal = $tanggal;
                $laporansulzer->mesin_id = $mesin_id;
                $laporansulzer->status = 'Draft';
                $laporansulzer->save();
            }
            $action = 'create';
            return view('produksiextruder.laporansulzer.show', compact('shift', 'tanggal', 'action', 'mesin', 'mesin_id', 'laporansulzer', 'laporansulzer_sebelumnya'));
        }

        if ($laporansulzer->status == 'Draft') {
            $action = 'edit';
            return view('produksiextruder.laporansulzer.show', compact('shift', 'tanggal', 'action', 'mesin', 'mesin_id', 'laporansulzer', 'laporansulzer_sebelumnya'));
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
        $mesin_id = $request->mesin_id;
        $mesin = Mesin::find($mesin_id);
        return view('produksiextruder.laporansulzer.create', compact('shift', 'tanggal', 'mesin', 'mesin_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $laporansulzer = Laporansulzer::where('tanggal', Carbon::parse($request->tanggal)->format('Y-m-d'))->where('shift', $request->shift)->where('mesin_id', $request->mesin_id)->first();
            if (!$laporansulzer) {
                $laporansulzer = new Laporansulzer();
                $laporansulzer->slug = Controller::gen_slug();
                $laporansulzer->tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
                $laporansulzer->shift = $request->shift;
                $laporansulzer->mesin_id = $request->mesin_id;
            }
            $laporansulzer->jenis_produksi = $request->jenis_produksi;
            $laporansulzer->save();
            foreach ($request->meter_awal as $key => $meter_awal) {
                $detail[] = [
                    'laporansulzer_id' => $laporansulzer->id,
                    'slug' => Controller::gen_slug(),
                    'meter_awal' => $request->meter_awal[$key] ? Controller::unformat_angka($meter_awal) : null,
                    'meter_akhir' => $request->meter_akhir[$key] ? Controller::unformat_angka($request->meter_akhir[$key]) : null,
                    'keterangan_produksi' => $request->keterangan_produksi[$key],
                    'keterangan_mesin' => $request->keterangan_mesin[$key],
                    'jam_stop' => $request->jam_stop[$key] ? Carbon::parse($request->jam_stop[$key])->format('H:i:s') : null,
                    'jam_jalan' => $request->jam_jalan[$key] ? Carbon::parse($request->jam_jalan[$key])->format('H:i:s') : null
                ];
            }
            $laporansulzer->laporansulzerdetail()->delete();
            $laporansulzer->laporansulzerdetail()->createMany($detail);
            DB::commit();
            return redirect()->route('produksiextruder.laporansulzer.index')->with([
                'status' => 'success',
                'message' => 'Data telah disimpan!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('error', compact('th'));
        }
    }

    public function store_laporan(Request $request)
    {
        $shift = $request->shift;
        $tanggal = $request->tanggal;
        $mesin_id = $request->mesin_id;
        $mesin = Mesin::find($mesin_id);
        $laporansulzer = Laporansulzer::find($request->laporansulzer_id);
        return view('produksiextruder.laporansulzer.create', compact('shift', 'tanggal', 'mesin_id', 'mesin'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Laporansulzer $laporansulzer)
    {
        $shift = $laporansulzer->shift;
        $tanggal = $laporansulzer->tanggal;
        $mesin_id = $laporansulzer->mesin_id;
        $mesin = Mesin::find($mesin_id);
        return view('produksiextruder.laporansulzer.edit', compact('shift', 'tanggal', 'mesin_id', 'mesin', 'laporansulzer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laporansulzer $laporansulzer)
    {
        $shift = $laporansulzer->shift;
        $tanggal = $laporansulzer->tanggal;
        $mesin_id = $laporansulzer->mesin_id;
        $mesin = Mesin::find($mesin_id);
        return view('produksiextruder.laporansulzer.edit', compact('shift', 'tanggal', 'mesin_id', 'mesin', 'laporansulzer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Laporansulzer $laporansulzer)
    {
        DB::beginTransaction();
        try {
            $laporansulzer->jenis_produksi = $request->jenis_produksi;
            $laporansulzer->save();
            foreach ($request->meter_awal as $key => $meter_awal) {
                $detail[] = [
                    'laporansulzer_id' => $laporansulzer->id,
                    'slug' => Controller::gen_slug(),
                    'meter_awal' => $request->meter_awal[$key] ? Controller::unformat_angka($meter_awal) : null,
                    'meter_akhir' => $request->meter_akhir[$key] ? Controller::unformat_angka($request->meter_akhir[$key]) : null,
                    'keterangan_produksi' => $request->keterangan_produksi[$key],
                    'keterangan_mesin' => $request->keterangan_mesin[$key],
                    'jam_stop' => $request->jam_stop[$key] ? Carbon::parse($request->jam_stop[$key])->format('H:i:s') : null,
                    'jam_jalan' => $request->jam_jalan[$key] ? Carbon::parse($request->jam_jalan[$key])->format('H:i:s') : null
                ];
            }
            $laporansulzer->laporansulzerdetail()->delete();
            $laporansulzer->laporansulzerdetail()->createMany($detail);
            DB::commit();
            return redirect()->route('produksiextruder.laporansulzer.index')->with([
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
    public function destroy(Laporansulzer $laporansulzer)
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
        $laporansulzer = Laporansulzer::where('tanggal', $tanggal)->where('shift', $shift)->where('mesin_id', $mesin_id)->first();
        return response()->json([
            'status' => 'success',
            'data' => $laporansulzer,
            'message' => 'success'
        ]);
    }

    public function confirm(Request $request, Laporansulzer $Laporansulzer)
    {
        return view('produksiextruder.laporanrashel.confirm');
    }

    public function get_mesin(Request $request)
    {
        if ($request->ajax()) {
            $term = trim($request->term);
            $mesin = Mesin::selectRaw("id, nama as text")
                ->where('nama', 'like', '%' . $term . '%')
                ->orderByRaw('CONVERT(nama, SIGNED) asc')->simplePaginate(10);
            $total_count = count($mesin);
            $morePages = true;
            $pagination_obj = json_encode($mesin);
            if (empty($mesin->nextPageUrl())) {
                $morePages = false;
            }
            $result = [
                "results" => $mesin->items(),
                "pagination" => [
                    "more" => $morePages
                ],
                "total_count" => $total_count
            ];
            return response()->json($result);
        }
    }
}
