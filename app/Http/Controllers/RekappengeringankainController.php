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

class RekappengeringankainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produksilaminating.rekap.index');
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
    public function show(Pengeringankain $pengeringankain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $slug, Pengeringankain $pengeringankain)
    {
        $pengeringankain = Pengeringankain::where('slug', $slug)->first();
        return view('produksilaminating.rekap.edit', compact('pengeringankain'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $slug, Pengeringankain $pengeringankain)
    {
        DB::beginTransaction();
        try {
            $pengeringankain = Pengeringankain::where('slug', $slug)->first();
            $pengeringankain->wjl_no_roll = $request->wjl_no_roll;
            $pengeringankain->operator_1 = $request->operator_1;
            $pengeringankain->tanggal_1 = Carbon::parse($request->tanggal_1)->format('Y-m-d');
            $pengeringankain->jam_1 = Carbon::parse($request->jam_1)->format('h:i:s');
            $pengeringankain->kondisi_kain_1 = $request->kondisi_kain_1;
            $pengeringankain->lebar_1 = $request->lebar_1;
            $pengeringankain->panjang_1 = $request->panjang_1;
            $pengeringankain->berat_1 = $request->berat_1;
            $pengeringankain->suhu_1 = $request->suhu_1;
            $pengeringankain->kecepatan_screw_1 = $request->kecepatan_screw_1;
            $pengeringankain->kecepatan_winder_1 = $request->kecepatan_winder_1;
            $pengeringankain->kondisi_kain2_1 = $request->kondisi_kain2_1;
            $pengeringankain->operator_2 = $request->operator_2;
            $pengeringankain->tanggal_2 = Carbon::parse($request->tanggal_2)->format('Y-m-d');
            $pengeringankain->jam_2 = Carbon::parse($request->jam_2)->format('h:i:s');
            $pengeringankain->kondisi_kain_2 = $request->kondisi_kain_2;
            $pengeringankain->lebar_2 = $request->lebar_2;
            $pengeringankain->panjang_2 = $request->panjang_2;
            $pengeringankain->berat_2 = $request->berat_2;
            $pengeringankain->suhu_2 = $request->suhu_2;
            $pengeringankain->kecepatan_screw_2 = $request->kecepatan_screw_2;
            $pengeringankain->kecepatan_winder_2 = $request->kecepatan_winder_2;
            $pengeringankain->kondisi_kain2_2 = $request->kondisi_kain2_2;
            $pengeringankain->operator_3 = $request->operator_3;
            $pengeringankain->tanggal_3 = Carbon::parse($request->tanggal_3)->format('Y-m-d');
            $pengeringankain->jam_3 = Carbon::parse($request->jam_3)->format('h:i:s');
            $pengeringankain->kondisi_kain_3 = $request->kondisi_kain_3;
            $pengeringankain->lebar_3 = $request->lebar_3;
            $pengeringankain->panjang_3 = $request->panjang_3;
            $pengeringankain->berat_3 = $request->berat_3;
            $pengeringankain->suhu_3 = $request->suhu_3;
            $pengeringankain->kecepatan_screw_3 = $request->kecepatan_screw_3;
            $pengeringankain->kecepatan_winder_3 = $request->kecepatan_winder_3;
            $pengeringankain->kondisi_kain2_3 = $request->kondisi_kain2_3;
            $pengeringankain->updated_by = Auth::user()->id;
            $pengeringankain->save();
            if ($request->meter) {
                foreach ($request->meter as $key => $meter) {
                    $detail[] = [
                        'slug' => Controller::gen_slug(),
                        'pengeringankain_id' => $pengeringankain->id,
                        'meter' => $meter,
                        'kerusakan' => $request->kerusakan[$key],
                        'created_by' => Auth::user()->id
                    ];
                }
                $pengeringankain->pengeringankaindetail()->delete();
                $pengeringankain->pengeringankaindetail()->createMany($detail);
            }
            DB::commit();
            return redirect()->route('produksilaminating.rekap.index')->with([
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
    public function destroy(Pengeringankain $pengeringankain)
    {
        //
    }

    public function konfirmasi(Request $request, Pengeringankain $pengeringankain)
    {
        DB::beginTransaction();
        try {
            $tanggal_dari = $request->tanggal_dari;
            $tanggal_sampai = $request->tanggal_sampai;
            $mesin_id = $request->mesin_id;
            if ($mesin_id) {
                Pengeringankain::where('wjl_tanggal', '>=', $tanggal_dari)
                    ->where('wjl_tanggal', '<=', $tanggal_sampai)
                    ->where('mesin_id', $mesin_id)->update([
                        'status' => 'Confirmed',
                        'confirmed_by' => Auth::user()->id,
                        'confirmed_at' => date('Y-m-d H:i:s', time())
                    ]);
            } else {
                Pengeringankain::where('wjl_tanggal', '>=', $tanggal_dari)
                    ->where('wjl_tanggal', '<=', $tanggal_sampai)
                    ->update([
                        'status' => 'Confirmed',
                        'confirmed_by' => Auth::user()->id,
                        'confirmed_at' => date('Y-m-d H:i:s', time())
                    ]);
            }
            DB::commit();
            return redirect()->route('produksilaminating.rekap.index')->with([
                'status' => 'success',
                'message' => 'Data telah dikonfirmasi!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('error', compact('th'));
        }
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

    public function get_rekap(Request $request)
    {
        $tanggal_dari = $request->tanggal_dari;
        $tanggal_sampai = $request->tanggal_sampai;
        $mesin_id = $request->mesin_id;
        $pengeringankain = Pengeringankain::select('id')->whereDate('wjl_tanggal', '>=', $tanggal_dari)
            ->whereDate('wjl_tanggal', '<=', $tanggal_sampai)
            ->orderBy('wjl_tanggal', 'asc')
            ->orderBy('mesin_id', 'asc')
            ->orderBy('wjl_shift', 'asc');
        if ($mesin_id != '' && $mesin_id != 'null') {
            $pengeringankain->where('mesin_id', $mesin_id);
        }
        $pengeringankain = $pengeringankain->get();
        $pengeringankaindetail = Pengeringankaindetail::whereIn('pengeringankain_id', $pengeringankain)->get();
        $view = view('produksilaminating.rekap.show', compact('tanggal_dari', 'tanggal_sampai', 'mesin_id', 'pengeringankain', 'pengeringankaindetail'))->render();
        return response()->json([
            'status' => 'success',
            'data' => $view,
            'message' => 'success'
        ]);
    }

    public function cetak(Request $request)
    {
        $tanggal_dari = $request->tanggal_dari;
        $tanggal_sampai = $request->tanggal_sampai;
        $mesin_id = $request->mesin_id;
        $mesin = Mesin::find($mesin_id);
        $pengeringankain = Pengeringankain::whereDate('wjl_tanggal', '>=', $tanggal_dari)
            ->whereDate('wjl_tanggal', '<=', $tanggal_sampai)
            ->orderBy('wjl_tanggal', 'asc')
            ->orderBy('mesin_id', 'asc')
            ->orderBy('wjl_shift', 'asc');
        if ($mesin_id != '' && $mesin_id != 'null') {
            $pengeringankain->where('mesin_id', $mesin_id);
        }
        $pengeringankain->get();
        $pengeringankain = $pengeringankain->get();
        $pdf = PDF::loadview('produksilaminating.rekap.index', compact(
            'tanggal_dari',
            'tanggal_sampai',
            'mesin_id',
            'mesin',
            'pengeringankain'
        ))->setPaper('A4', 'landscape');
        return $pdf->download('laporan-produksi-pengeringan-kain_' . Carbon::parse($tanggal_dari)->format('Ymd') . '-' . Carbon::parse($tanggal_sampai)->format('Ymd') . '.pdf');
    }

    public function export(Request $request)
    {
        $tanggal_dari = $request->tanggal_dari;
        $tanggal_sampai = $request->tanggal_sampai;
        $mesin_id = $request->mesin_id;
        $mesin = Mesin::find($mesin_id);
        return Excel::download(new ProduksiwjlExport($tanggal_dari, $tanggal_sampai, $mesin_id), 'laporan-produksi-wjl_' . Carbon::parse($tanggal_dari)->format('Ymd') . '-' . Carbon::parse($tanggal_sampai)->format('Ymd') . '.xlsx');
    }
}
