<?php

namespace App\Http\Controllers;

use App\Exports\LaporangudangExport;
use App\Models\Material;
use App\Models\Materialstok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PDF;


class LaporangudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenis = request()->jenis;
        if (request()->jenis == 'bahanbaku') {
            return view('laporangudang.bahanbaku.index', compact('jenis'));
        } elseif (request()->jenis == 'bahanpenolong') {
            return view('laporangudang.bahanpenolong.index', compact('jenis'));
        } elseif (request()->jenis == "workinprogress") {
            return view('laporangudang.workinprogress.index', compact('jenis'));
        } elseif (request()->jenis == 'avalan') {
            return view('laporangudang.avalan.index', compact('jenis'));
        } elseif (request()->jenis == 'barangjadi') {
            return view('laporangudang.barangjadi.index', compact('jenis'));
        }
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function detail(Request $request)
    {
        $tanggal = $request->tanggal;
        $jenis = $request->jenis;
        $bentuk = $request->bentuk;
        $view = view('laporangudang.' . $jenis . '.detail', compact('tanggal', 'jenis', 'bentuk'))->render();
        return response()->json([
            'status' => 'success',
            'data' => $view,
            'message' => 'success'
        ]);
    }

    public function cetak(Request $request)
    {
        $tanggal = $request->tanggal;
        $bentuk = $request->bentuk;
        $jenis = $request->jenis;
        $pdf = PDF::loadview('laporangudang.barangjadi.cetak', compact(
            'tanggal',
            'bentuk',
            'jenis'
        ));
        return $pdf->download('laporanstok_' . $jenis . '_' . $bentuk . '_' . date('Ymd', strtotime($tanggal)) . '.pdf');
    }

    public function export(Request $request)
    {
        $tanggal = $request->tanggal;
        $bentuk = $request->bentuk;
        $jenis = $request->jenis;
        return Excel::download(new LaporangudangExport($tanggal, $bentuk, $jenis), 'laporanstok_' . $jenis . '_' . $bentuk . '_' . date('Ymd', strtotime($tanggal)) . '.xlsx');
    }

    public function store_keterangan(Request $request)
    {
        DB::beginTransaction();
        try {
            $tanggal = $request->tanggal;
            $bentuk = $request->bentuk;
            $jenis = $request->jenis;
            if ($request->has('material_id')) {
                foreach ($request->material_id as $key => $material_id) {
                    $materialstok = Materialstok::where('material_id', $material_id)->first();
                    if (!$materialstok) {
                        $materialstok = new Materialstok();
                        $materialstok->material_id = $material_id;
                    }
                    $materialstok->keterangan = $request->keterangan[$key];
                    $materialstok->save();
                }
            }
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'success'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('error', compact('th'));
        }
    }
}
