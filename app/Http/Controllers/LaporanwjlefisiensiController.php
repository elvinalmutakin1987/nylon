<?php

namespace App\Http\Controllers;

use App\Exports\LaporanwjlefisiensiExport;
use App\Models\Produksiwjl;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use PDF;

class LaporanwjlefisiensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $operator = Produksiwjl::distinct()->orderBy('operator')->get('operator');
        return view('laporanwjlefisiensi.index', compact('operator'));
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
        $tanggal_dari = $request->tanggal_dari;
        $tanggal_sampai = $request->tanggal_sampai;
        $operator = $request->operator;
        $view = view('laporanwjlefisiensi.detail', compact('tanggal_dari', 'tanggal_sampai', 'operator'))->render();
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
        $operator = $request->operator;
        $pdf = PDF::loadview('laporanwjlefisiensi.cetak', compact(
            'tanggal_dari',
            'tanggal_sampai',
            'operator'
        ))->setPaper('A4', 'potrait');
        return $pdf->download('laporan_efisiensi_' . $operator . '_' . Carbon::parse($tanggal_dari)->format('Ymd') . '-' . Carbon::parse($tanggal_sampai)->format('Ymd') . '.pdf');
    }

    public function export(Request $request)
    {
        $tanggal_dari = $request->tanggal_dari;
        $tanggal_sampai = $request->tanggal_sampai;
        $operator = $request->operator;
        return Excel::download(new LaporanwjlefisiensiExport($tanggal_dari, $tanggal_sampai, $operator), 'laporan-efisiensi-' . $operator . '_' . Carbon::parse($tanggal_dari)->format('Ymd') . '-' . Carbon::parse($tanggal_sampai)->format('Ymd') . '.xlsx');
    }
}
