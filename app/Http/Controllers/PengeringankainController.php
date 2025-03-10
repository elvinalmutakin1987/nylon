<?php

namespace App\Http\Controllers;

use App\Models\Mesin;
use App\Models\Pengeringankain;
use App\Models\Pengeringankaindetail;
use App\Models\Produksiwjl;
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

class PengeringankainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produksilaminating.pengeringankain.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
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
                $pengeringankain->slug = Controller::gen_slug();
                $pengeringankain->produksiwjl_id = $produksiwjl->id;
                $pengeringankain->wjl_tanggal = $produksiwjl->tanggal;
                $pengeringankain->wjl_shift = $produksiwjl->shift;
                $pengeringankain->wjl_operator = $produksiwjl->operator;
                $pengeringankain->wjl_jenis_kain = $produksiwjl->jenis_kain;
                $pengeringankain->mesin_id = $mesin_id;
                $pengeringankain->status = 'Submit';
                $pengeringankain->created_by = Auth::user()->id;
                $pengeringankain->save();
            }
            DB::commit();
            if ($pengeringankain->status == 'Submit') {
                $action = "Edit";
                return view('produksilaminating.pengeringankain.edit', compact('shift', 'tanggal', 'mesin_id', 'mesin', 'action', 'pengeringankain'));
            }
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Laporan sudah di konfirmasi kepala regu / pengawas!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('error', compact('th'));
        }
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

    public function cek_laporan_wjl(Request $request)
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
        $produksiwjl = Produksiwjl::where('tanggal', $tanggal)->where('shift', $shift)->where('mesin_id', $mesin_id)->first();
        return response()->json([
            'status' => 'success',
            'data' => $produksiwjl,
            'message' => 'success'
        ]);
    }

    public function confirm(Request $request, Pengeringankain $pengeringankain)
    {
        return view('produksilaminating.pengeringankain.confirm');
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
