<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Laporanrashel;
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

class LaporanrashelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produksiextruder.laporanrashel.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $mesin_id = $request->mesin_id;
        $mesin = Mesin::find($mesin_id);
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

        if ($mesin_id == 'null' || $mesin_id == '') {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Pilih mesin!'
            ]);
        }

        $laporanrashel = Laporanrashel::where('tanggal', $tanggal)
            ->where('shift', $shift)
            ->first();

        $laporanrashel_sebelumnya = Laporanrashel::where('tanggal', $tanggal_sebelumnya)
            ->where('shift', $shift_sebelumnya)
            ->first();

        $action = 'create';
        if (!$laporanrashel) {
            $shift = $request->shift;
            $tanggal = $request->tanggal;
            $laporanrashel = Laporanrashel::where('shift', $shift)->where('tanggal', $tanggal)->where('status', 'Draft')->first();
            if (!$laporanrashel) {
                $laporanrashel = new Laporanrashel();
                $laporanrashel->slug = Controller::gen_slug();
                $laporanrashel->shift = $shift;
                $laporanrashel->tanggal = $tanggal;
                $laporanrashel->status = 'Draft';
                $laporanrashel->save();
            }
            $action = 'create';
            return view('produksiextruder.laporanrashel.show', compact('shift', 'tanggal', 'mesin_id', 'mesin', 'action', 'laporanrashel', 'laporanrashel_sebelumnya'));
        }

        if ($laporanrashel->status == 'Draft') {
            $action = 'edit';
            return view('produksiextruder.laporanrashel.show', compact('shift', 'tanggal',  'mesin_id', 'mesin', 'action', 'laporanrashel', 'laporanrashel_sebelumnya'));
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
        return view('produksiextruder.laporanrashel.create', compact('shift', 'tanggal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $laporanrashel = Laporanrashel::where('tanggal', Carbon::parse($request->tanggal)->format('Y-m-d'))->where('shift', $request->shift)->where('status', 'Draft')->first();
            if (!$laporanrashel) {
                $laporanrashel = new Laporanrashel();
                $laporanrashel->slug = Controller::gen_slug();
                $laporanrashel->tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
                $laporanrashel->shift = $request->shift;
            }
            $laporanrashel->save();
            foreach ($request->meter_awal as $key => $meter_awal) {
                $detail[] = [
                    'laporanrashel_id' => $laporanrashel->id,
                    'slug' => Controller::gen_slug(),
                    'mesin_id' => $request->mesin_id[$key] ?? null,
                    'jenis_produksi' => $request->jenis_produksi[$key] ?? null,
                    'meter_awal' => $request->meter_awal[$key] ? Controller::unformat_angka($meter_awal) : null,
                    'meter_akhir' => $request->meter_akhir[$key] ? Controller::unformat_angka($request->meter_akhir[$key]) : null,
                    'hasil' => $request->hasil[$key] ? Controller::unformat_angka($request->hasil[$key]) : null,
                    'keterangan_produksi' => $request->keterangan_produksi[$key],
                    'keterangan_mesin' => $request->keterangan_mesin[$key],
                    'jam_stop' => $request->jam_stop[$key] ? Carbon::parse($request->jam_stop[$key])->format('H:i:s') : null,
                    'jam_jalan' => $request->jam_jalan[$key] ? Carbon::parse($request->jam_jalan[$key])->format('H:i:s') : null
                ];
            }
            $laporanrashel->laporanrasheldetail()->delete();
            $laporanrashel->laporanrasheldetail()->createMany($detail);
            DB::commit();
            return redirect()->route('produksiextruder.laporanrashel.index')->with([
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
        $laporanrashel = Laporanrashel::find($request->laporanrashel_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Laporanrashel $laporanrashel)
    {
        $shift = $laporanrashel->shift;
        $tanggal = $laporanrashel->tanggal;
        return view('produksiextruder.laporanrashel.edit', compact('shift', 'tanggal', 'laporanrashel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laporanrashel $laporanrashel)
    {
        $shift = $laporanrashel->shift;
        $tanggal = $laporanrashel->tanggal;
        return view('produksiextruder.laporanrashel.edit', compact('shift', 'tanggal', 'laporanrashel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Laporanrashel $laporanrashel)
    {
        DB::beginTransaction();
        try {
            $laporanrashel->save();
            foreach ($request->meter_awal as $key => $meter_awal) {
                $detail[] = [
                    'laporanrashel_id' => $laporanrashel->id,
                    'slug' => Controller::gen_slug(),
                    'mesin_id' => $request->mesin_id[$key] ?? null,
                    'jenis_produksi' => $request->jenis_produksi[$key] ?? null,
                    'meter_awal' => $request->meter_awal[$key] ? Controller::unformat_angka($meter_awal) : null,
                    'meter_akhir' => $request->meter_akhir[$key] ? Controller::unformat_angka($request->meter_akhir[$key]) : null,
                    'hasil' => $request->hasil[$key] ? Controller::unformat_angka($request->hasil[$key]) : null,
                    'keterangan_produksi' => $request->keterangan_produksi[$key],
                    'keterangan_mesin' => $request->keterangan_mesin[$key],
                    'jam_stop' => $request->jam_stop[$key] ? Carbon::parse($request->jam_stop[$key])->format('H:i:s') : null,
                    'jam_jalan' => $request->jam_jalan[$key] ? Carbon::parse($request->jam_jalan[$key])->format('H:i:s') : null
                ];
            }
            $laporanrashel->laporanrasheldetail()->delete();
            $laporanrashel->laporanrasheldetail()->createMany($detail);
            DB::commit();
            return redirect()->route('produksiextruder.laporanrashel.index')->with([
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
    public function destroy(Laporanrashel $laporanrashel)
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
        $laporanrashel = Laporanrashel::where('tanggal', $tanggal)->where('shift', $shift)->first();
        return response()->json([
            'status' => 'success',
            'data' => $laporanrashel,
            'message' => 'success'
        ]);
    }

    public function confirm(Request $request, Laporanrashel $laporanrashel)
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
