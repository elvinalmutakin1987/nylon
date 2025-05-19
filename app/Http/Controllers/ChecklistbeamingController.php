<?php

namespace App\Http\Controllers;

use App\Models\Checklistbeaming;
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

class ChecklistbeamingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produksiextruder.checklistbeaming.index');
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

        $checklistbeaming = Checklistbeaming::where('tanggal', $tanggal)
            ->where('shift', $shift)
            ->first();

        $checklistbeaming_sebelumnya = Checklistbeaming::where('tanggal', $tanggal_sebelumnya)
            ->where('shift', $shift_sebelumnya)
            ->first();

        $action = 'create';
        if (!$checklistbeaming) {
            $shift = $request->shift;
            $tanggal = $request->tanggal;
            $checklistbeaming = Checklistbeaming::where('shift', $shift)->where('tanggal', $tanggal)->where('status', 'Draft')->first();
            if (!$checklistbeaming) {
                $checklistbeaming = new Checklistbeaming();
                $checklistbeaming->slug = Controller::gen_slug();
                $checklistbeaming->shift = $shift;
                $checklistbeaming->tanggal = $tanggal;
                $checklistbeaming->status = 'Draft';
                $checklistbeaming->created_by = Auth::user()->id;
                $checklistbeaming->save();
            }
            $action = 'create';
            return view('produksiextruder.checklistbeaming.show', compact('shift', 'tanggal', 'mesin_id', 'mesin', 'action', 'checklistbeaming', 'checklistbeaming_sebelumnya'));
        }

        if ($checklistbeaming->status == 'Draft') {
            $action = 'edit';
            return view('produksiextruder.checklistbeaming.show', compact('shift', 'tanggal',  'mesin_id', 'mesin', 'action', 'checklistbeaming', 'checklistbeaming_sebelumnya'));
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
        return view('produksiextruder.checklistbeaming.create', compact('shift', 'tanggal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $checklistbeaming = Checklistbeaming::where('tanggal', Carbon::parse($request->tanggal)->format('Y-m-d'))->where('shift', $request->shift)->first();
            if (!$checklistbeaming) {
                $checklistbeaming = new Checklistbeaming();
                $checklistbeaming->slug = Controller::gen_slug();
                $checklistbeaming->tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
                $checklistbeaming->shift = $request->shift;
                $checklistbeaming->created_by = Auth::user()->id;
                $checklistbeaming->shift = $request->shift;
            }
            $checklistbeaming->motif_sesuai_1 = $request->motif_sesuai_1 ? '1' : null;
            $checklistbeaming->motif_sesuai_2 = $request->motif_sesuai_2 ? '1' : null;
            $checklistbeaming->motif_sesuai_3 = $request->motif_sesuai_3 ? '1' : null;
            $checklistbeaming->motif_sesuai_4 = $request->motif_sesuai_4 ? '1' : null;
            $checklistbeaming->motif_sesuai_5 = $request->motif_sesuai_5 ? '1' : null;
            $checklistbeaming->motif_sesuai_6 = $request->motif_sesuai_6 ? '1' : null;
            $checklistbeaming->motif_sesuai_7 = $request->motif_sesuai_7 ? '1' : null;
            $checklistbeaming->jumlah_benang_putus = $request->jumlah_benang_putus;
            $checklistbeaming->jumlah_benang = $request->jumlah_benang;
            $checklistbeaming->lebar_benang = $request->lebar_benang;
            $checklistbeaming->keterangan_produksi = $request->keterangan_produksi;
            $checklistbeaming->save();
            foreach ($request->diameter_beam_timur as $key => $diameter_beam_timur) {
                $detail[] = [
                    'checklistbeaming_id' => $checklistbeaming->id,
                    'slug' => Controller::gen_slug(),
                    'diameter_beam_timur' => $request->diameter_beam_timur[$key],
                    'diameter_beam_1m_dari_timur' => $request->diameter_beam_1m_dari_timur[$key],
                    'diameter_beam_barat' => $request->diameter_beam_barat[$key],
                ];
            }
            $checklistbeaming->checklistbeamingdetail()->delete();
            $checklistbeaming->checklistbeamingdetail()->createMany($detail);
            DB::commit();
            return redirect()->route('produksiextruder.checklistbeaming.index')->with([
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
        $checklistbeaming = Checklistbeaming::find($request->checklistbeaming_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Checklistbeaming $checklistbeaming)
    {
        $shift = $checklistbeaming->shift;
        $tanggal = $checklistbeaming->tanggal;
        return view('produksiextruder.checklistbeaming.edit', compact('shift', 'tanggal', 'checklistbeaming'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checklistbeaming $checklistbeaming)
    {
        $shift = $checklistbeaming->shift;
        $tanggal = $checklistbeaming->tanggal;
        return view('produksiextruder.checklistbeaming.edit', compact('shift', 'tanggal', 'checklistbeaming'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Checklistbeaming $checklistbeaming)
    {
        DB::beginTransaction();
        try {
            $checklistbeaming->motif_sesuai_1 = $request->motif_sesuai_1 ? '1' : null;
            $checklistbeaming->motif_sesuai_2 = $request->motif_sesuai_2 ? '1' : null;
            $checklistbeaming->motif_sesuai_3 = $request->motif_sesuai_3 ? '1' : null;
            $checklistbeaming->motif_sesuai_4 = $request->motif_sesuai_4 ? '1' : null;
            $checklistbeaming->motif_sesuai_5 = $request->motif_sesuai_5 ? '1' : null;
            $checklistbeaming->motif_sesuai_6 = $request->motif_sesuai_6 ? '1' : null;
            $checklistbeaming->motif_sesuai_7 = $request->motif_sesuai_7 ? '1' : null;
            $checklistbeaming->jumlah_benang_putus = $request->jumlah_benang_putus;
            $checklistbeaming->jumlah_benang = $request->jumlah_benang;
            $checklistbeaming->lebar_benang = $request->lebar_benang;
            $checklistbeaming->keterangan_produksi = $request->keterangan_produksi;
            $checklistbeaming->save();
            foreach ($request->diameter_beam_timur as $key => $diameter_beam_timur) {
                $detail[] = [
                    'checklistbeaming_id' => $checklistbeaming->id,
                    'slug' => Controller::gen_slug(),
                    'diameter_beam_timur' => $request->diameter_beam_timur[$key],
                    'diameter_beam_1m_dari_timur' => $request->diameter_beam_1m_dari_timur[$key],
                    'diameter_beam_barat' => $request->diameter_beam_barat[$key],
                ];
            }
            $checklistbeaming->checklistbeamingdetail()->delete();
            $checklistbeaming->checklistbeamingdetail()->createMany($detail);
            DB::commit();
            return redirect()->route('produksiextruder.checklistbeaming.index')->with([
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
    public function destroy(Checklistbeaming $checklistbeaming)
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
        $checklistbeaming = Checklistbeaming::where('tanggal', $tanggal)->where('shift', $shift)->first();
        return response()->json([
            'status' => 'success',
            'data' => $checklistbeaming,
            'message' => 'success'
        ]);
    }

    public function confirm(Request $request, Checklistbeaming $checklistbeaming)
    {
        return view('produksiextruder.checklistbeaming.confirm');
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
