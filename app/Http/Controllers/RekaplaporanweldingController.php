<?php

namespace App\Http\Controllers;

use App\Exports\ProduksiwjlExport;
use App\Exports\RekaplaporanweldingExport;
use App\Models\Mesin;
use App\Models\Produksiwelding;
use App\Models\Produksiweldingdetail;
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

class RekaplaporanweldingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produksiwelding.rekap.index');
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produksiwelding $produksiwelding)
    {
        return view('produksiwelding.rekap.edit', compact('produksiwelding'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produksiwelding $produksiwelding)
    {
        $validator = Validator::make($request->all(), [
            'operator' => 'required',
            'tanggal' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $produksiwelding->tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
            $produksiwelding->operator = $request->operator;
            $produksiwelding->created_by = Auth::user()->id;
            $produksiwelding->save();
            if ($request->has('jenis')) {
                foreach ($request->jenis as $key => $jenis) {
                    $detail[] = [
                        'produksiwelding_id' => $produksiwelding->id,
                        'slug' => Controller::gen_slug(),
                        'jenis' => $request->jenis[$key],
                        'ukuran1' => $request->ukuran1[$key] ? Controller::unformat_angka($request->ukuran1[$key]) : null,
                        'ukuran2' => $request->ukuran2[$key] ? Controller::unformat_angka($request->ukuran2[$key]) : null,
                        'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : null,
                        'total' => $request->total[$key] ? Controller::unformat_angka($request->total[$key]) : null,
                        'keterangan' => $request->keteranga,
                    ];
                }
                $produksiwelding->produksiweldingdetail()->delete();
                $produksiwelding->produksiweldingdetail()->createMany($detail);
            }
            DB::commit();
            return redirect()->route('produksiwelding.rekap.index')->with([
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
    public function destroy(string $id)
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
        $produksiwelding = Produksiwelding::whereDate('tanggal', '>=', $tanggal_dari)
            ->whereDate('tanggal', '<=', $tanggal_sampai)
            ->orderBy('tanggal', 'asc')->get();
        $produksiwelding_operator = Produksiwelding::select('operator')->whereDate('tanggal', '>=', $tanggal_dari)
            ->whereDate('tanggal', '<=', $tanggal_sampai)
            ->groupBy('operator')->get();
        $produksiwelding_tanggal = Produksiwelding::select('tanggal')->whereDate('tanggal', '>=', $tanggal_dari)
            ->whereDate('tanggal', '<=', $tanggal_sampai)
            ->groupBy('tanggal')->get();
        $view = view('produksiwelding.rekap.show', compact('tanggal_dari', 'tanggal_sampai', 'produksiwelding', 'produksiwelding_operator', 'produksiwelding_tanggal'))->render();
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
        $produksiwelding = Produksiwelding::whereDate('tanggal', '>=', $tanggal_dari)
            ->whereDate('tanggal', '<=', $tanggal_sampai)
            ->orderBy('tanggal', 'asc')->get();
        $produksiwelding_operator = Produksiwelding::select('operator')->whereDate('tanggal', '>=', $tanggal_dari)
            ->whereDate('tanggal', '<=', $tanggal_sampai)
            ->groupBy('operator')->get();
        $produksiwelding_tanggal = Produksiwelding::select('tanggal')->whereDate('tanggal', '>=', $tanggal_dari)
            ->whereDate('tanggal', '<=', $tanggal_sampai)
            ->groupBy('tanggal')->get();
        $pdf = PDF::loadview('produksiwelding.rekap.cetak', compact(
            'tanggal_dari',
            'tanggal_sampai',
            'produksiwelding',
            'produksiwelding_operator',
            'produksiwelding_tanggal'
        ))->setPaper('A4', 'potrait');
        return $pdf->download('laporan-produksi-welding' . Carbon::parse($tanggal_dari)->format('Ymd') . '-' . Carbon::parse($tanggal_sampai)->format('Ymd') . '.pdf');
    }

    public function export(Request $request)
    {
        $tanggal_dari = $request->tanggal_dari;
        $tanggal_sampai = $request->tanggal_sampai;
        return Excel::download(new RekaplaporanweldingExport($tanggal_dari, $tanggal_sampai), 'laporan-produksi-welding' . Carbon::parse($tanggal_dari)->format('Ymd') . '-' . Carbon::parse($tanggal_sampai)->format('Ymd') . '.xlsx');
    }
}
