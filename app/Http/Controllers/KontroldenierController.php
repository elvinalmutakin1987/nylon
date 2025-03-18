<?php

namespace App\Http\Controllers;

use App\Models\Kontroldenier;
use App\Models\Kontroldenierdetail;
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
        $jenis_benang = $request->jenis_benang;
        $d_plus_bottom = $request->d_plus_bottom;
        $d_plus_top = $request->d_plus_top;
        $d_bottom = $request->d_bottom;
        $d_top = $request->d_top;
        $n_bottom = $request->n_bottom;
        $n_top = $request->n_top;
        $k_bottom = $request->k_bottom;
        $k_top = $request->k_top;
        $k_min_bottom = $request->k_min_bottom;
        $k_min_top = $request->k_min_top;
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
            $shift = $request->shift;
            $tanggal = $request->tanggal;
            $material_id = $request->material_id;
            $material = Material::find($material_id);
            $kontroldenier = Kontroldenier::where('material_id', $material_id)->where('shift', $shift)->where('tanggal', $tanggal)->where('status', 'Draft')->first();
            if (!$kontroldenier) {
                $kontroldenier = new Kontroldenier();
                $kontroldenier->slug = Controller::gen_slug();
                $kontroldenier->shift = $shift;
                $kontroldenier->material_id = $material_id;
                $kontroldenier->tanggal = $tanggal;
                $kontroldenier->status = 'Draft';
                $kontroldenier->jenis_benang = $jenis_benang;
                $kontroldenier->d_plus_bottom = $d_plus_bottom;
                $kontroldenier->d_plus_top = $d_plus_top;
                $kontroldenier->d_bottom = $d_bottom;
                $kontroldenier->d_top = $d_top;
                $kontroldenier->n_bottom = $n_bottom;
                $kontroldenier->n_top = $n_top;
                $kontroldenier->k_bottom = $k_bottom;
                $kontroldenier->k_top = $k_top;
                $kontroldenier->k_min_bottom = $k_min_bottom;
                $kontroldenier->k_min_top = $k_min_top;
                $kontroldenier->created_by = Auth::user()->id;
                $kontroldenier->save();
            }
            $action = 'create';
            return view('produksiextruder.kontroldenier.show', compact('shift', 'tanggal', 'material_id', 'material', 'action', 'kontroldenier', 'kontroldenier_sebelumnya'));
        }
        $kontroldenier->jenis_benang = $jenis_benang;
        $kontroldenier->d_plus_bottom = $d_plus_bottom;
        $kontroldenier->d_plus_top = $d_plus_top;
        $kontroldenier->d_bottom = $d_bottom;
        $kontroldenier->d_top = $d_top;
        $kontroldenier->n_bottom = $n_bottom;
        $kontroldenier->n_top = $n_top;
        $kontroldenier->k_bottom = $k_bottom;
        $kontroldenier->k_top = $k_top;
        $kontroldenier->k_min_bottom = $k_min_bottom;
        $kontroldenier->k_min_top = $k_min_top;
        $kontroldenier->updated_by = Auth::user()->id;
        $kontroldenier->save();
        if ($kontroldenier->status == 'Draft') {
            $action = 'edit';
            return view('produksiextruder.kontroldenier.show', compact('shift', 'tanggal', 'material_id', 'material', 'action', 'kontroldenier', 'kontroldenier_sebelumnya'));
        }

        return redirect()->back()->with([
            'status' => 'error',
            'message' => 'Laporan sudah di konfirmasi!'
        ]);
    }

    public function create_laporan(Request $request)
    {
        $shift = $request->shift;
        $tanggal = $request->tanggal;
        $material_id = $request->material_id;
        $material = Material::find($material_id);
        $jenis_benang = $request->jenis_benang;
        $d_plus_bottom = $request->d_plus_bottom;
        $d_plus_top = $request->d_plus_top;
        $d_bottom = $request->d_bottom;
        $d_top = $request->d_top;
        $n_bottom = $request->n_bottom;
        $n_top = $request->n_top;
        $k_bottom = $request->k_bottom;
        $k_top = $request->k_top;
        $k_min_bottom = $request->k_min_bottom;
        $k_min_top = $request->k_min_top;
        $kontroldenier = Kontroldenier::where('material_id', $material_id)->where('shift', $shift)->where('tanggal', $tanggal)->where('status', 'Draft')->first();
        if (!$kontroldenier) {
            $kontroldenier = new Kontroldenier();
            $kontroldenier->slug = Controller::gen_slug();
            $kontroldenier->shift = $shift;
            $kontroldenier->material_id = $material_id;
            $kontroldenier->tanggal = $tanggal;
            $kontroldenier->jenis_benang = $jenis_benang;
            $kontroldenier->d_plus_bottom = $d_plus_bottom;
            $kontroldenier->d_plus_top = $d_plus_top;
            $kontroldenier->d_bottom = $d_bottom;
            $kontroldenier->d_top = $d_top;
            $kontroldenier->n_bottom = $n_bottom;
            $kontroldenier->n_top = $n_top;
            $kontroldenier->k_bottom = $k_bottom;
            $kontroldenier->k_top = $k_top;
            $kontroldenier->k_min_bottom = $k_min_bottom;
            $kontroldenier->k_min_top = $k_min_top;
            $kontroldenier->status = 'Draft';
            $kontroldenier->created_by = Auth::user()->id;
            $kontroldenier->save();
        }
        return view('produksiextruder.kontroldenier.create', compact('shift', 'tanggal', 'material_id', 'material', 'kontroldenier'));
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

    public function store_laporan(Request $request)
    {
        $shift = $request->shift;
        $tanggal = $request->tanggal;
        $material_id = $request->material_id;
        $material = Material::find($material_id);
        $kontroldenier = Kontroldenier::find($requet->kontroldenier_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kontroldenier $kontroldenier)
    {
        $shift = $kontroldenier->shift;
        $tanggal = $kontroldenier->tanggal;
        $material_id = $kontroldenier->material_id;
        $material = Material::find($material_id);
        return view('produksiextruder.kontroldenier.edit', compact('shift', 'tanggal', 'material_id', 'material', 'kontroldenier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Kontroldenier $kontroldenier)
    {
        $shift = $kontroldenier->shift;
        $tanggal = $kontroldenier->tanggal;
        $material_id = $kontroldenier->material_id;
        $material = Material::find($material_id);
        return view('produksiextruder.kontroldenier.edit', compact('shift', 'tanggal', 'material_id', 'material', 'kontroldenier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kontroldenier $kontroldenier)
    {
        DB::beginTransaction();
        try {
            $lokasi = $request->lokasi;
            if ($request->kr_nilai) {
                foreach ($request->kr_no_lokasi as $key => $kr_no_lokasi) {
                    if ($request->kr_nilai[$key] != '') {
                        $detail[] = [
                            'kontroldenier_id' => $kontroldenier->id,
                            'slug' => Controller::gen_slug(),
                            'lokasi' => "KR",
                            'no_lokasi' => $kr_no_lokasi,
                            'nilai' => $request->kr_nilai[$key] ?? null,
                            'rank' => $request->kr_rank[$key] ?? null,
                            'created_by' => Auth::user()->id
                        ];
                    }
                }
            }
            if ($request->kn_nilai) {
                foreach ($request->kn_no_lokasi as $key => $kn_no_lokasi) {
                    if ($request->kn_nilai[$key] != '') {
                        $detail[] = [
                            'kontroldenier_id' => $kontroldenier->id,
                            'slug' => Controller::gen_slug(),
                            'lokasi' => "KN",
                            'no_lokasi' => $kn_no_lokasi,
                            'nilai' => $request->kn_nilai[$key] ?? null,
                            'rank' => $request->kn_rank[$key] ?? null,
                            'created_by' => Auth::user()->id
                        ];
                    }
                }
            }
            if ($request->kr_nilai || $request->kn_nilai) {
                $kontroldenier->kontroldenierdetail()->delete();
                $kontroldenier->kontroldenierdetail()->createMany($detail);
            }
            DB::commit();
            return redirect()->route('produksiextruder-kontrol-denier.index')->with([
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

    public function confirm(Request $request, Kontroldenier $kontroldenier)
    {
        return view('produksiextruder.kontroldenier.confirm');
    }
}
