<?php

namespace App\Http\Controllers;

use App\Models\Kontroldenier;
use App\Models\Material;
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

class KontroldenierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produksiextruder.kontroldenier.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $material_id = $request->material_id;
        $material = Material::find($material_id);
        $shift = $request->shift;
        $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d') ?? date('Y-m-d');
        $shift_sebelumnya = '';

        if ($shift == 'Pagi') {
            $shift_sebelumnya = 'Malam';
            $tanggal_sebelumnya = Carbon::parse($tanggal)->subDays(1)->format('Y-m-d');
        } elseif ($shift == 'Sore') {
            $shift_sebelumnya = 'Pagi';
            $tanggal_sebelumnya = $tanggal;
        } elseif ($shift == 'Malam') {
            $shift_sebelumnya = 'Sore';
            $tanggal_sebelumnya = $tanggal;
        }

        if ($material_id == 'null' || $material_id == '') {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Pilih jenis barang!'
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

        $kontroldenier = Kontroldenier::where('material_id', $material_id)
            ->where('tanggal', $tanggal)
            ->where('shift', $shift)
            ->first();

        $kontroldenier_sebelumnya = Kontroldenier::where('material_id', $material_id)
            ->where('tanggal', $tanggal_sebelumnya)
            ->where('shift', $shift_sebelumnya)
            ->first();

        $action = 'create';
        if (!$kontroldenier) {
            $action = 'create';
            return view('produksiextruder.kontroldenier.show', compact('shift', 'tanggal', 'material_id', 'material', 'action', 'kontroldenier_sebelumnya'));
        }

        if ($kontroldenier->status == 'Submit') {
            $action = 'edit';
            return view('produksiextruder.kontroldenier.show', compact('shift', 'tanggal', 'material_id', 'material', 'action', 'kontroldenier', 'kontroldenier_sebelumnya'));
        }

        return redirect()->back()->with([
            'status' => 'error',
            'message' => 'Laporan sudah di konfirmasi kepala regu / pengawas!'
        ]);
    }

    public function create_laporan(Request $request)
    {
        $shift = $request->shift;
        $tanggal = $request->tanggal;
        $material_id = $request->material_id;
        $material = Material::find($material_id);
        return view('produksiextruder.kontroldenier.create', compact('shift', 'tanggal', 'material_id', 'material'));
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
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $order_shift = '';
            if ($request->shift == 'Pagi') {
                $order_shift = '1';
            } elseif ($request->shift == 'Sore') {
                $order_shift = '2';
            } elseif ($request->shift == 'Malam') {
                $order_shift = '3';
            }
            //$pengaturan = Pengaturan::where('keterangan', 'produksiwjl.operator.butuh.approval')->first();
            $gen_no_dokumen = Controller::gen_no_dokumen('produksiwjl');
            $produksiwjl = new Produksiwjl();
            $produksiwjl->slug = Controller::gen_slug();
            $produksiwjl->tanggal = $request->tanggal;

            $produksiwjl->created_by = Auth::user()->id;
            $produksiwjl->status = 'Submit'; //$pengaturan->nilai == 'Ya' ? 'Submit' : 'Confirmed';
            $produksiwjl->order_shift = $order_shift;
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
    public function show(Kontroldenier $kontroldenier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kontroldenier $kontroldenier)
    {
        dd("OK");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kontroldenier $kontroldenier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kontroldenier $kontroldenier)
    {
        //
    }
    public function get_material(Request $request)
    {
        if ($request->ajax()) {
            $term = trim($request->term);
            $material = Material::selectRaw("id, nama as text")
                ->where('nama', 'like', '%' . $term . '%')
                ->orderBy('nama')->simplePaginate(10);
            $total_count = count($material);
            $morePages = true;
            $pagination_obj = json_encode($material);
            if (empty($material->nextPageUrl())) {
                $morePages = false;
            }
            $result = [
                "results" => $material->items(),
                "pagination" => [
                    "more" => $morePages
                ],
                "total_count" => $total_count
            ];
            return response()->json($result);
        }
    }

    public function get_detail(Request $request)
    {
        $material_id = $request->material_id;
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
        $kontroldenier = Kontroldenier::where('tanggal', $tanggal)->where('shift', $shift)->where('material_id', $material_id)->first();
        $view =  view('produksiextruder.kontroldenier.show', compact('kontroldenier'))->render();
        return response()->json([
            'status' => 'success',
            'data' => $view,
            'message' => 'success'
        ]);
    }

    public function cek_sebelumnya(Request $request)
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

    public function confirm(Request $request, Produksiwjl $produksiwjl)
    {
        return view('produksiwjl.operator.confirm');
    }
}
