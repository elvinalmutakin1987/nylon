<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Mesin;
use App\Models\Prodwjl;
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

class ProdwjlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $prodwjl = Prodwjl::query();
            return DataTables::of($prodwjl)
                ->addIndexColumn()
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
                            <a class="dropdown-item" href="' . route('prodwjl.show', $item->slug) . '")"> <i class="fas fa-eye"></i> Detail</a>';
                        if ($item->status == 'Draft') {
                            $button .= '<a class="dropdown-item" href="' . route('prodwjl.panen', $item->slug) . '")"> <i class="fa fa-download"></i> Panen</a>';
                        }
                        if (Auth::user()->can('produksi.wjl.edit')) {
                            $button .= '<a class="dropdown-item" href="' . route('prodwjl.edit', $item->slug) . '")"> <i class="fas fa-edit"></i> Edit</a>';
                        }
                        $button .= '<button class="dropdown-item" onClick="hapus(\'' . $item->slug . '\')"><i class="fas fa-trash"></i> Hapus</button>
                        </div>';
                    } else {
                        $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('prodwjl.show', $item->slug) . '")"> <i class="fas fa-eye"></i> Detail</a>
                            ';
                        if (Auth::user()->can('produksi.wjl.edit')) {
                            $button .= '<a class="dropdown-item" href="' . route('prodwjl.edit', $item->slug) . '")"> <i class="fas fa-edit"></i> Edit</a>';
                        }
                        $button .= '</div>';
                    }

                    return $button;
                })
                ->make();
        }
        return view('produksibelakang.wjl.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produksibelakang.wjl.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_so' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $gen_no_dokumen = Controller::gen_no_dokumen('produksiwjl');
            $prodwjl = new Prodwjl();
            $prodwjl->nomor = $gen_no_dokumen['nomor'];
            $prodwjl->mesin_id = $request->mesin_id;
            $prodwjl->nomor_so = $request->nomor_so;
            $prodwjl->slug = Str::slug($request->nomor_so . '-' . time());
            $prodwjl->status = 'Draft';
            $prodwjl->shift = $request->shift;
            $prodwjl->operator = $request->operator;
            $prodwjl->tanggal = $request->tanggal;
            $prodwjl->keterangan = $request->keterangan;
            $prodwjl->created_by = Auth::user()->id;
            $prodwjl->save();
            if ($request->has('material_id')) {
                foreach ($request->material_id as $key => $material_id) {
                    $detail[] = [
                        'prodwjl_id' => $prodwjl->id,
                        'slug' => Controller::gen_slug(),
                        'material_id' => $request->material_id[$key] ?? null,
                        'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : null,
                        'jumlah2' => $request->jumlah2[$key] ? Controller::unformat_angka($request->jumlah2[$key]) : null,
                    ];
                }
                $prodwjl->prodwjldetail()->delete();
                $prodwjl->prodwjldetail()->createMany($detail);
            }
            DB::commit();
            return redirect()->route('prodwjl.index')->with([
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
    public function show(Prodwjl $prodwjl)
    {
        return view('produksibelakang.wjl.show', compact('prodwjl'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prodwjl $prodwjl)
    {
        return view('produksibelakang.wjl.edit', compact('prodwjl'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prodwjl $prodwjl)
    {
        $validator = Validator::make($request->all(), [
            'nomor_so' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {

            $prodwjl->mesin_id = $request->mesin_id;
            $prodwjl->nomor_so = $request->nomor_so;
            $prodwjl->slug = Str::slug($request->nomor_so . '-' . time());
            $prodwjl->shift = $request->shift;
            $prodwjl->operator = $request->operator;
            $prodwjl->tanggal = $request->tanggal;
            $prodwjl->keterangan = $request->keterangan;
            $prodwjl->updated_by = Auth::user()->id;
            $prodwjl->save();
            if ($request->has('material_id')) {
                foreach ($request->material_id as $key => $material_id) {
                    $detail[] = [
                        'prodwjl_id' => $prodwjl->id,
                        'slug' => Controller::gen_slug(),
                        'material_id' => $request->material_id[$key] ?? null,
                        'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : null,
                        'jumlah2' => $request->jumlah2[$key] ? Controller::unformat_angka($request->jumlah2[$key]) : null,
                    ];
                }
                $prodwjl->prodwjldetail()->delete();
                $prodwjl->prodwjldetail()->createMany($detail);
            }
            DB::commit();
            return redirect()->route('prodwjl.index')->with([
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
    public function destroy(Prodwjl $prodwjl)
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

    public function panen(Prodwjl $prodwjl)
    {
        if ($prodwjl->status != 'Draft') {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Data sudah dipanen!'
            ]);
        }
        return view('produksibelakang.wjl.panen', compact('prodwjl'));
    }

    public function update_panen(Request $request, Prodwjl $prodwjl)
    {
        DB::beginTransaction();
        try {
            $prodwjl->tanggal_panen  = $request->tanggal_panen;
            $prodwjl->keterangan_panen = $request->keterangan_panen;
            $prodwjl->status = 'Panen';
            $prodwjl->jumlah = $request->jumlah_panen ? Controller::unformat_angka($request->jumlah_panen) : null;
            $prodwjl->jumlah2 = $request->jumlah_panen2 ? Controller::unformat_angka($request->jumlah_panen2) : null;
            $prodwjl->material_id = $request->material_id_panen;
            $prodwjl->updated_by = Auth::user()->id;
            $prodwjl->save();
            DB::commit();
            return redirect()->route('prodwjl.index')->with([
                'status' => 'success',
                'message' => 'Data telah disimpan!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('error', compact('th'));
        }
    }
}
