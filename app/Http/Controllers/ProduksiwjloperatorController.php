<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Mesin;
use App\Models\Pengaturan;
use App\Models\Produksiwjl;
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

class ProduksiwjloperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produksiwjl.operator.index');
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
            return redirect()->back()->withErrors([
                'status' => 'error',
                'message' => $validator->getMessageBag()
            ])->withInput();
        }
        DB::beginTransaction();
        try {
            $pengaturan = Pengaturan::where('keterangan', 'produksiwjl.operator.butuh.approval')->first();
            $gen_no_dokumen = Controller::gen_no_dokumen('produksiwjl');
            $produksiwjl = Produksiwjl::where('tanggal', $request->tanggal)->where('shift', $request->shift)->first();
            $cek = 0;
            if ($produksiwjl) {
                $cek = 1;
                if ($produksiwjl->status == 'Approved') {
                    return redirect()->route('produksiwjl.operator.index')->with([
                        'status' => 'error',
                        'message' => 'Data sudah masuk laporan. Tidak bisa diubah!'
                    ]);
                }
            }
            if ($cek == 0) {
                $produksiwjl = new Produksiwjl();
                $produksiwjl->slug = Controller::gen_slug();
            }
            $produksiwjl->tanggal = $request->tanggal;
            $produksiwjl->operator = $request->operator;
            $produksiwjl->shift = $request->shift;
            $produksiwjl->mesin_id = $request->mesin_id;
            $produksiwjl->jenis_kain = $request->jenis_kain;
            $produksiwjl->meter_awal = Controller::unformat_angka($request->meter_awal);
            $produksiwjl->meter_akhir = Controller::unformat_angka($request->meter_akhir);
            $produksiwjl->hasil = Controller::unformat_angka($request->hasil);
            $produksiwjl->keterangan = $request->keterangan;
            $produksiwjl->lungsi = Controller::unformat_angka($request->lungsi);
            $produksiwjl->pakan = Controller::unformat_angka($request->pakan);
            $produksiwjl->lubang = $request->lubang;
            $produksiwjl->pgr = $request->pgr;
            $produksiwjl->lebar = Controller::unformat_angka($request->lebar);
            $produksiwjl->mesin = $request->mesin;
            $produksiwjl->teknisi = $request->teknisi;
            if ($cek == 0) {
                $produksiwjl->created_by = Auth::user()->id;
            } else {
                $produksiwjl->updated_by = Auth::user()->id;
            }
            $produksiwjl->status = $pengaturan->nilai == 'Ya' ? 'Submit' : 'Approved';
            $produksiwjl->save();
            if ($request->hasFile('foto')) {
                if ($cek == 1) {
                    $fotonya = Foto::where('dokumen', 'produksiwjl')->where('dokumen_id', $produksiwjl->id)->get();
                    foreach ($fotonya as $f) {
                        if (Storage::exists($f->fulltext)) {
                            Storage::delete($f->fulltext);
                        }
                    }
                    Foto::where('dokumen', 'produksiwjl')->where('dokumen_id', $produksiwjl->id)->delete();
                }
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
            return redirect()->route('produksiwjl.operator.index')->with([
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
                ->orderBy('nama')->simplePaginate(10);
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
