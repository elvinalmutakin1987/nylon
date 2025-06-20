<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Mesin;
use App\Models\Prodwjl;
use App\Models\Prodlaminating;
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

class ProdlaminatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $prodlaminating = Prodlaminating::query();
            return DataTables::of($prodlaminating)
                ->addIndexColumn()
                ->addColumn('nomor_wjl', function ($item) {
                    $prodwjl = Prodwjl::find($item->prodwjl_id);
                    return $prodwjl ? $prodwjl->nomor : null;
                })
                ->addColumn('mesin', function ($item) {
                    $mesin = Mesin::find($item->mesin_id);
                    return $mesin ? $mesin->nama : null;
                })
                ->addColumn('action', function ($item) {
                    if ($item->status == 'Draft') {
                        $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('prodlaminating.show', $item->slug) . '")"> <i class="fas fa-eye"></i> Detail</a>';
                        if ($item->status == 'Draft') {
                            $button .= '<a class="dropdown-item" href="' . route('prodlaminating.panen', $item->slug) . '")"> <i class="fa fa-download"></i> Panen</a>';
                        }
                        if (Auth::user()->can('produksi.laminating.edit')) {
                            $button .= '<a class="dropdown-item" href="' . route('prodlaminating.edit', $item->slug) . '")"> <i class="fas fa-edit"></i> Edit</a>';
                        }
                        $button .= '<button class="dropdown-item" onClick="hapus(\'' . $item->slug . '\')"><i class="fas fa-trash"></i> Hapus</button>
                        </div>';
                    } else {
                        $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('prodlaminating.show', $item->slug) . '")"> <i class="fas fa-eye"></i> Detail</a>
                            ';
                        if (Auth::user()->can('produksi.laminating.edit')) {
                            $button .= '<a class="dropdown-item" href="' . route('prodlaminating.edit', $item->slug) . '")"> <i class="fas fa-edit"></i> Edit</a>';
                        }
                        $button .= '</div>';
                    }

                    return $button;
                })
                ->make();
        }
        return view('produksibelakang.laminating.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produksibelakang.laminating.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prodwjl_id' => 'required',
            'nomor_so' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $gen_no_dokumen = Controller::gen_no_dokumen('produksilaminating');
            $prodlaminating = new Prodlaminating();
            $prodlaminating->prodwjl_id = $request->prodwjl_id;
            $prodlaminating->nomor = "LAM-" . $gen_no_dokumen['nomor'];
            $prodlaminating->mesin_id = $request->mesin_id;
            $prodlaminating->nomor_so = $request->nomor_so;
            $prodlaminating->nomor_roll = $request->nomor_roll;
            $prodlaminating->slug = Controller::gen_slug();
            $prodlaminating->status = 'Draft';
            $prodlaminating->shift = $request->shift;
            $prodlaminating->operator = $request->operator;
            $prodlaminating->tanggal = $request->tanggal;
            $prodlaminating->keterangan = $request->keterangan;
            $prodlaminating->created_by = Auth::user()->id;
            $prodlaminating->save();
            if ($request->has('material_id')) {
                foreach ($request->material_id as $key => $material_id) {
                    $detail[] = [
                        'prodlaminating_id' => $prodlaminating->id,
                        'slug' => Controller::gen_slug(),
                        'material_id' => $request->material_id[$key] ?? null,
                        'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : null,
                        'jumlah2' => $request->jumlah2[$key] ? Controller::unformat_angka($request->jumlah2[$key]) : null,
                    ];
                }
                $prodlaminating->prodlaminatingdetail()->delete();
                $prodlaminating->prodlaminatingdetail()->createMany($detail);
            }
            DB::commit();
            return redirect()->route('prodlaminating.index')->with([
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
    public function show(Prodlaminating $prodlaminating)
    {
        return view('produksibelakang.laminating.show', compact('prodlaminating'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prodlaminating $prodlaminating)
    {
        return view('produksibelakang.laminating.edit', compact('prodlaminating'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prodlaminating $prodlaminating)
    {
        $validator = Validator::make($request->all(), [
            'prodwjl_id' => 'required',
            'nomor_so' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $prodlaminating->prodwjl_id = $request->prodwjl_id;
            $prodlaminating->mesin_id = $request->mesin_id;
            $prodlaminating->nomor_so = $request->nomor_so;
            $prodlaminating->nomor_roll = $request->nomor_roll;
            $prodlaminating->shift = $request->shift;
            $prodlaminating->operator = $request->operator;
            $prodlaminating->tanggal = $request->tanggal;
            $prodlaminating->keterangan = $request->keterangan;
            $prodlaminating->tanggal_panen  = $request->tanggal_panen;
            $prodlaminating->jumlah = $request->jumlah_panen ? Controller::unformat_angka($request->jumlah_panen) : null;
            $prodlaminating->jumlah2 = $request->jumlah_panen2 ? Controller::unformat_angka($request->jumlah_panen2) : null;
            $prodlaminating->material_id = $request->material_id_panen;
            $prodlaminating->updated_by = Auth::user()->id;
            $prodlaminating->save();
            if ($request->has('material_id')) {
                foreach ($request->material_id as $key => $material_id) {
                    $detail[] = [
                        'prodlaminating_id' => $prodlaminating->id,
                        'slug' => Controller::gen_slug(),
                        'material_id' => $request->material_id[$key] ?? null,
                        'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : null,
                        'jumlah2' => $request->jumlah2[$key] ? Controller::unformat_angka($request->jumlah2[$key]) : null,
                    ];
                }
                $prodlaminating->prodlaminatingdetail()->delete();
                $prodlaminating->prodlaminatingdetail()->createMany($detail);
            }
            DB::commit();
            return redirect()->route('prodlaminating.index')->with([
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
    public function destroy(Prodlaminating $prodlaminating)
    {
        DB::beginTransaction();
        try {
            $prodlaminating->prodlaminatingdetail()->delete();
            $prodlaminating->delete();
            DB::commit();
            return redirect()->route('prodlaminating.index')->with([
                'status' => 'success',
                'message' => 'Data telah dihapus!'
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

    public function get_material(Request $request)
    {
        if ($request->ajax()) {
            $term = trim($request->term);
            $material = Material::selectRaw("id, nama as text")
                ->where('nama', 'like', '%' . $term . '%')
                ->orderByRaw('CONVERT(nama, SIGNED) asc')->simplePaginate(10);
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

    public function get_prodwjl(Request $request)
    {
        if ($request->ajax()) {
            $term = trim($request->term);
            $prodwjl = Prodwjl::selectRaw("id, nomor as text")
                ->where('status', 'Panen')
                ->where('nomor', 'like', '%' . $term . '%')
                ->orderByRaw('CONVERT(nomor, SIGNED) asc')->simplePaginate(10);
            $total_count = count($prodwjl);
            $morePages = true;
            $pagination_obj = json_encode($prodwjl);
            if (empty($prodwjl->nextPageUrl())) {
                $morePages = false;
            }
            $result = [
                "results" => $prodwjl->items(),
                "pagination" => [
                    "more" => $morePages
                ],
                "total_count" => $total_count
            ];
            return response()->json($result);
        }
    }

    public function get_prodwjl_by_id(Request $request)
    {
        if ($request->ajax()) {
            $prodwjl = Prodwjl::find($request->prodwjl_id);
            $mesin = Mesin::find($prodwjl->mesin_id);
            $data = [
                'prodwjl' => $prodwjl,
                'mesin' => $mesin,
            ];
            return response()->json($data);
        }
    }

    public function panen(Prodlaminating $prodlaminating)
    {
        if ($prodlaminating->status != 'Draft') {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Data sudah dipanen!'
            ]);
        }
        return view('produksibelakang.laminating.panen', compact('prodlaminating'));
    }

    public function update_panen(Request $request, Prodlaminating $prodlaminating)
    {
        DB::beginTransaction();
        try {
            $prodlaminating->tanggal_panen  = $request->tanggal_panen;
            $prodlaminating->keterangan_panen = $request->keterangan_panen;
            $prodlaminating->status = 'Panen';
            $prodlaminating->jumlah = $request->jumlah_panen ? Controller::unformat_angka($request->jumlah_panen) : null;
            $prodlaminating->jumlah2 = $request->jumlah_panen2 ? Controller::unformat_angka($request->jumlah_panen2) : null;
            $prodlaminating->material_id = $request->material_id_panen;
            $prodlaminating->updated_by = Auth::user()->id;
            $prodlaminating->save();
            DB::commit();
            return redirect()->route('prodlaminating.index')->with([
                'status' => 'success',
                'message' => 'Data telah disimpan!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('error', compact('th'));
        }
    }
}
