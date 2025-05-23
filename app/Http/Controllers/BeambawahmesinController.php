<?php

namespace App\Http\Controllers;

use App\Models\Laporanbeaming;
use App\Models\Laporanbeamingdetail;
use App\Models\Laporanbeamingpanen;
use App\Models\Beambawahmesin;
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

class BeambawahmesinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $beambawahmesin = Beambawahmesin::all();
        return view('produksiextruder.beambawahmesin.index', compact('beambawahmesin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produksiextruder.beambawahmesin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'beam_sisa' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $beambawahmesin = Beambawahmesin::where('tanggal', $request->tanggal)
                ->where('beam_number', $request->beam_number)
                ->where('jenis_produksi', $request->jenis_produksi)
                ->first();
            if (!$beambawahmesin) {
                $beambawahmesin = new Beambawahmesin();
                $beambawahmesin->slug = Controller::gen_slug();
                $beambawahmesin->tanggal = $request->tanggal;
                $beambawahmesin->beam_number = $request->beam_number;
                $beambawahmesin->jenis_produksi = $request->jenis_produksi;
            }
            $laporanbeaming = Laporanbeaming::where('tanggal', $request->tanggal)
                ->where('beam_number', $request->beam_number)
                ->where('jenis_produksi', $request->jenis_produksi)
                ->first();
            $config = config('jenisproduksi');
            $jenisproduksi = collect($config)->where('jenis_produksi', $request->jenis_produksi)->first();
            $beambawahmesin->laporanbeaming_id = $laporanbeaming->id ?? null;
            $beambawahmesin->rajutan_lusi = $jenisproduksi['rajutan_lusi'];
            $beambawahmesin->lebar_kain = $jenisproduksi['lebar_kain'];
            $beambawahmesin->jumlah_benang = $jenisproduksi['jumlah_benang'];
            $beambawahmesin->lebar_benang = $jenisproduksi['lebar_benang'];
            $beambawahmesin->denier = $jenisproduksi['denier'];
            $beambawahmesin->beam_isi = $jenisproduksi['beam_isi'];
            $beambawahmesin->beam_sisa = $request->beam_sisa ? Controller::unformat_angka($request->beam_sisa) : null;
            $beambawahmesin->berat = $request->berat ? Controller::unformat_angka($request->berat) : null;
            $beambawahmesin->created_by = Auth::user()->id;
            $beambawahmesin->save();
            DB::commit();
            return redirect()->route('produksiextruder.beambawahmesin.index')->with([
                'status' => 'success',
                'message' => 'Data telah disimpan!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('error', compact('th'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Beambawahmesin $beambawahmesin)
    {
        return view('produksiextruder.beambawahmesin.show', compact('beambawahmesin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Beambawahmesin $beambawahmesin)
    {
        return view('produksiextruder.beambawahmesin.edit', compact('beambawahmesin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Beambawahmesin $beambawahmesin)
    {
        $validator = Validator::make($request->all(), [
            'beam_sisa' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $config = config('jenisproduksi');
            $jenisproduksi = collect($config)->where('jenis_produksi', $request->jenis_produksi)->first();
            $beambawahmesin->rajutan_lusi = $jenisproduksi['rajutan_lusi'];
            $beambawahmesin->lebar_kain = $jenisproduksi['lebar_kain'];
            $beambawahmesin->jumlah_benang = $jenisproduksi['jumlah_benang'];
            $beambawahmesin->lebar_benang = $jenisproduksi['lebar_benang'];
            $beambawahmesin->denier = $jenisproduksi['denier'];
            $beambawahmesin->beam_isi = $jenisproduksi['beam_isi'];
            $beambawahmesin->beam_sisa = $request->beam_sisa ? Controller::unformat_angka($request->beam_sisa) : null;
            $beambawahmesin->berat = $request->berat ? Controller::unformat_angka($request->berat) : null;
            $beambawahmesin->created_by = Auth::user()->id;
            $beambawahmesin->save();
            DB::commit();
            return redirect()->route('produksiextruder.beambawahmesin.index')->with([
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
    public function destroy(Beambawahmesin $beambawahmesin)
    {
        DB::beginTransaction();
        try {
            $beambawahmesin->delete();
            DB::commit();
            return redirect()->route('produksiextruder.beambawahmesin.index')->with([
                'status' => 'success',
                'message' => 'Data telah disimpan!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('error', compact('th'));
        }
    }

    public function get_beamnumber(Request $request)
    {
        if ($request->ajax()) {
            $term = trim($request->term);
            $laporanbeaming = Laporanbeaming::selectRaw("beam_number as id, beam_number as text")
                ->where('tanggal', '=', $request->tanggal)
                ->where('beam_number', 'like', '%' . $term . '%')
                ->orderByRaw('CONVERT(beam_number, SIGNED) asc')->simplePaginate(10);
            $total_count = count($laporanbeaming);
            $morePages = true;
            $pagination_obj = json_encode($laporanbeaming);
            if (empty($laporanbeaming->nextPageUrl())) {
                $morePages = false;
            }
            $result = [
                "results" => $laporanbeaming->items(),
                "pagination" => [
                    "more" => $morePages
                ],
                "total_count" => $total_count
            ];
            return response()->json($result);
        }
    }

    public function cetak(Request $request)
    {
        $beambawahmesin = Beambawahmesin::all();
        $pdf = PDF::loadview('produksiextruder.beambawahmesin.cetak', compact(
            'beambawahmesin'
        ));
        return $pdf->download('beam_atas_mesin.pdf');
    }

    public function export(Request $request)
    {
        return Excel::download(new BeambawahmesinExport(), 'beam_bawah_mesin.xlsx');
    }
}
