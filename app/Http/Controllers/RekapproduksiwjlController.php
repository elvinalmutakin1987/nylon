<?php

namespace App\Http\Controllers;

use App\Exports\ProduksiwjlExport;
use App\Models\Mesin;
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

class RekapproduksiwjlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produksiwjl.rekap.index');
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
    public function show(Produksiwjl $produksiwjl)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produksiwjl $produksiwjl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produksiwjl $produksiwjl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produksiwjl $produksiwjl)
    {
        //
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
        $produksiwjl = Produksiwjl::where('mesin_id', $mesin_id)
            ->whereDate('tanggal', '>=', $tanggal_dari)
            ->whereDate('tanggal', '<=', $tanggal_sampai)
            ->orderBy('tanggal', 'asc')
            ->orderBy('order_shift', 'asc')
            ->get();
        $view = view('produksiwjl.rekap.show', compact('tanggal_dari', 'tanggal_sampai', 'mesin_id', 'produksiwjl'))->render();
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
        $produksiwjl = Produksiwjl::where('mesin_id', $mesin_id)
            ->whereDate('tanggal', '>=', $tanggal_dari)
            ->whereDate('tanggal', '<=', $tanggal_sampai)
            ->orderBy('tanggal', 'asc')
            ->orderBy('order_shift', 'asc')
            ->get();
        $pdf = PDF::loadview('produksiwjl.rekap.cetak', compact(
            'tanggal_dari',
            'tanggal_sampai',
            'mesin_id',
            'mesin',
            'produksiwjl'
        ))->setPaper('A4', 'landscape');
        return $pdf->download('laporan-produksi-wjl_' . Carbon::parse($tanggal_dari)->format('Ymd') . '-' . Carbon::parse($tanggal_sampai)->format('Ymd') . '.pdf');
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
