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
        return view('produksiwjl.rekap.edit', compact('produksiwjl'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produksiwjl $produksiwjl)
    {
        $validator = Validator::make($request->all(), [
            'operator' => 'required',
            'mesin_id' => 'required',
            'jenis_kain' => 'required',
            'shift' => 'required',
            'meter_awal' => 'required',
            'meter_akhir' => 'required',
            'hasil' => 'required',
            'keterangan' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $produksiwjl->operator = $request->operator;
            $produksiwjl->jenis_kain = $request->jenis_kain;
            $produksiwjl->meter_awal = Controller::unformat_angka($request->meter_awal ?? '0');
            $produksiwjl->meter_akhir = Controller::unformat_angka($request->meter_akhir ?? '0');
            $produksiwjl->hasil = Controller::unformat_angka($request->hasil ?? '0');
            $produksiwjl->keterangan = $request->keterangan;
            $produksiwjl->lungsi = Controller::unformat_angka($request->lungsi ?? '0');
            $produksiwjl->pakan = Controller::unformat_angka($request->pakan ?? '0');
            $produksiwjl->lubang = $request->lubang;
            $produksiwjl->pgr = $request->pgr;
            $produksiwjl->lebar = Controller::unformat_angka($request->lebar ?? '0');
            $produksiwjl->mesin = $request->mesin;
            $produksiwjl->teknisi = $request->teknisi;
            $produksiwjl->updated_by = Auth::user()->id;
            $produksiwjl->status = 'Submit'; //$pengaturan->nilai == 'Ya' ? 'Submit' : 'Confirmed';
            $produksiwjl->save();
            if ($request->hasFile('foto')) {
                $files = $request->file('foto');
                foreach ($files as $file) {
                    $realname = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $directory = "produksiwjl";
                    $filename = Str::random(24) . "." . $extension;
                    $file->storeAs($directory, $filename);

                    // $manager = new ImageManager(new Driver());
                    // $image = ImageManager::imagick()->read('storage/' . $directory . '/' . $filename);
                    // $image->resizeDown(height: 100);
                    // $image->scaleDown(height: 100);

                    $foto_db = new Foto();
                    $foto_db->slug = Controller::gen_slug();
                    $foto_db->dokumen = 'produksiwjl';
                    $foto_db->dokumen_id = $produksiwjl->id;
                    $foto_db->fulltext = 'storage/' . $directory . '/' . $filename;
                    $foto_db->directory = $directory;
                    $foto_db->filename = $filename;
                    $foto_db->realname = $realname;
                    $foto_db->extension = $extension;
                    $foto_db->created_by = Auth::user()->id;
                    $foto_db->save();
                }
            }
            DB::commit();
            return redirect()->route('produksiwjl.rekap.index')->with([
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
    public function destroy(Produksiwjl $produksiwjl)
    {
        //
    }

    public function konfirmasi(Request $request, Produksiwjl $produksiwjl)
    {

        DB::beginTransaction();
        try {
            $tanggal_dari = $request->tanggal_dari;
            $tanggal_sampai = $request->tanggal_sampai;
            $mesin_id = $request->mesin_id;
            if ($mesin_id) {
                Produksiwjl::where('tanggal', '>=', $tanggal_dari)
                    ->where('tanggal', '<=', $tanggal_sampai)
                    ->where('mesin_id', $mesin_id)->update([
                        'status' => 'Confirmed',
                        'confirmed_by' => Auth::user()->id,
                        'confirmed_at' => date('Y-m-d H:i:s', time())
                    ]);
            } else {
                Produksiwjl::where('tanggal', '>=', $tanggal_dari)
                    ->where('tanggal', '<=', $tanggal_sampai)
                    ->update([
                        'status' => 'Confirmed',
                        'confirmed_by' => Auth::user()->id,
                        'confirmed_at' => date('Y-m-d H:i:s', time())
                    ]);
            }
            DB::commit();
            return redirect()->route('produksiwjl.rekap.index')->with([
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
        $produksiwjl = Produksiwjl::whereDate('tanggal', '>=', $tanggal_dari)
            ->whereDate('tanggal', '<=', $tanggal_sampai)
            ->orderBy('tanggal', 'asc')
            ->orderBy('order_shift', 'asc');
        if ($mesin_id != '' && $mesin_id != 'null') {
            $produksiwjl->where('mesin_id', $mesin_id);
        }
        $produksiwjl->get();
        $produksiwjl = $produksiwjl->get();
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
        $produksiwjl = Produksiwjl::whereDate('tanggal', '>=', $tanggal_dari)
            ->whereDate('tanggal', '<=', $tanggal_sampai)
            ->orderBy('tanggal', 'asc')
            ->orderBy('order_shift', 'asc');
        if ($mesin_id != '' && $mesin_id != 'null') {
            $produksiwjl->where('mesin_id', $mesin_id);
        }
        $produksiwjl->get();
        $produksiwjl = $produksiwjl->get();
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
