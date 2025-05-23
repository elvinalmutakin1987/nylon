<?php

namespace App\Http\Controllers;

use App\Exports\BeamatasmesinExport;
use App\Models\Laporanbeaming;
use App\Models\Laporanbeamingdetail;
use App\Models\Laporanbeamingpanen;
use App\Models\Beamatasmesin;
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

class BeamatasmesinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $beamatasmesin = Beamatasmesin::all();
        return view('produksiextruder.beamatasmesin.index', compact('beamatasmesin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produksiextruder.beamatasmesin.create');
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
            $beamatasmesin = Beamatasmesin::where('tanggal', $request->tanggal)
                ->where('beam_number', $request->beam_number)
                ->where('jenis_produksi', $request->jenis_produksi)
                ->first();
            if (!$beamatasmesin) {
                $beamatasmesin = new Beamatasmesin();
                $beamatasmesin->slug = Controller::gen_slug();
                $beamatasmesin->tanggal = $request->tanggal;
                $beamatasmesin->beam_number = $request->beam_number;
                $beamatasmesin->jenis_produksi = $request->jenis_produksi;
            }
            $laporanbeaming = Laporanbeaming::where('tanggal', $request->tanggal)
                ->where('beam_number', $request->beam_number)
                ->where('jenis_produksi', $request->jenis_produksi)
                ->first();
            $config = config('jenisproduksi');
            $jenisproduksi = collect($config)->where('jenis_produksi', $request->jenis_produksi)->first();
            $beamatasmesin->laporanbeaming_id = $laporanbeaming->id ?? null;
            $beamatasmesin->rajutan_lusi = $jenisproduksi['rajutan_lusi'];
            $beamatasmesin->lebar_kain = $jenisproduksi['lebar_kain'];
            $beamatasmesin->jumlah_benang = $jenisproduksi['jumlah_benang'];
            $beamatasmesin->lebar_benang = $jenisproduksi['lebar_benang'];
            $beamatasmesin->denier = $jenisproduksi['denier'];
            $beamatasmesin->beam_isi = $jenisproduksi['beam_isi'];
            $beamatasmesin->beam_sisa = $request->beam_sisa ? Controller::unformat_angka($request->beam_sisa) : null;
            $beamatasmesin->berat = $request->berat ? Controller::unformat_angka($request->berat) : null;
            $beamatasmesin->created_by = Auth::user()->id;
            $beamatasmesin->save();
            DB::commit();
            return redirect()->route('produksiextruder.beamatasmesin.index')->with([
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
    public function show(Beamatasmesin $beamatasmesin)
    {
        return view('produksiextruder.beamatasmesin.show', compact('beamatasmesin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Beamatasmesin $beamatasmesin)
    {
        return view('produksiextruder.beamatasmesin.edit', compact('beamatasmesin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Beamatasmesin $beamatasmesin)
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
            $beamatasmesin->rajutan_lusi = $jenisproduksi['rajutan_lusi'];
            $beamatasmesin->lebar_kain = $jenisproduksi['lebar_kain'];
            $beamatasmesin->jumlah_benang = $jenisproduksi['jumlah_benang'];
            $beamatasmesin->lebar_benang = $jenisproduksi['lebar_benang'];
            $beamatasmesin->denier = $jenisproduksi['denier'];
            $beamatasmesin->beam_isi = $jenisproduksi['beam_isi'];
            $beamatasmesin->beam_sisa = $request->beam_sisa ? Controller::unformat_angka($request->beam_sisa) : null;
            $beamatasmesin->berat = $request->berat ? Controller::unformat_angka($request->berat) : null;
            $beamatasmesin->created_by = Auth::user()->id;
            $beamatasmesin->save();
            DB::commit();
            return redirect()->route('produksiextruder.beamatasmesin.index')->with([
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
    public function destroy(Beamatasmesin $beamatasmesin)
    {
        DB::beginTransaction();
        try {
            $beamatasmesin->delete();
            DB::commit();
            return redirect()->route('produksiextruder.beamatasmesin.index')->with([
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
        $beamatasmesin = Beamatasmesin::all();
        $pdf = PDF::loadview('produksiextruder.beamatasmesin.cetak', compact(
            'beamatasmesin'
        ));
        return $pdf->download('beam_atas_mesin.pdf');
    }

    public function export(Request $request)
    {
        return Excel::download(new BeamatasmesinExport(), 'beam_atas_mesin.xlsx');
    }
}
