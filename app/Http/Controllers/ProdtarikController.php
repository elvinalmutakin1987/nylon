<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Mesin;
use App\Models\Prodwjl;
use App\Models\Prodwelding;
use App\Models\Prodlaminating;
use App\Models\Prodtarik;
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

class ProdtarikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $prodtarik = Prodtarik::query();
            return DataTables::of($prodtarik)
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
                            <a class="dropdown-item" href="' . route('prodtarik.show', $item->slug) . '")"> <i class="fas fa-eye"></i> Detail</a>';
                        if ($item->status == 'Draft') {
                            $button .= '<a class="dropdown-item" href="' . route('prodtarik.panen', $item->slug) . '")"> <i class="fa fa-download"></i> Panen</a>';
                        }
                        if (Auth::user()->can('produksi.laminating.edit')) {
                            $button .= '<a class="dropdown-item" href="' . route('prodtarik.edit', $item->slug) . '")"> <i class="fas fa-edit"></i> Edit</a>';
                        }
                        $button .= '<button class="dropdown-item" onClick="hapus(\'' . $item->slug . '\')"><i class="fas fa-trash"></i> Hapus</button>
                        </div>';
                    } else {
                        $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('prodtarik.show', $item->slug) . '")"> <i class="fas fa-eye"></i> Detail</a>
                            ';
                        if (Auth::user()->can('produksi.laminating.edit')) {
                            $button .= '<a class="dropdown-item" href="' . route('prodtarik.edit', $item->slug) . '")"> <i class="fas fa-edit"></i> Edit</a>';
                        }
                        $button .= '</div>';
                    }

                    return $button;
                })
                ->make();
        }
        return view('produksibelakang.tarik.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produksibelakang.tarik.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shift' => 'required',
            'operator' => 'required',
            'tanggal' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $gen_no_dokumen = Controller::gen_no_dokumen('produksitarik');
            $prodtarik = new Prodtarik();
            $prodtarik->nomor = "TAR-" . $gen_no_dokumen['nomor'];
            $prodtarik->slug = Controller::gen_slug();
            $prodtarik->status = 'Draft';
            $prodtarik->shift = $request->shift;
            $prodtarik->operator = $request->operator;
            $prodtarik->tanggal = $request->tanggal;
            $prodtarik->keterangan = $request->keterangan;
            $prodtarik->created_by = Auth::user()->id;
            $prodtarik->save();
            if ($request->has('material_id')) {
                foreach ($request->material_id as $key => $material_id) {
                    $detail[] = [
                        'prodtarik_id' => $prodtarik->id,
                        'slug' => Controller::gen_slug(),
                        'prodwelding_id' => $request->prodwelding_id && $request->prodwelding_id[$key] != 'undefined' ? $request->prowelding_id[$key] : null,
                        'material_id' => $request->material_id && $request->material_id[$key] != 'undefined' ? $request->material_id[$key] : null,
                        'mesin_id' => $request->mesin_id && $request->mesin_id[$key] != 'undefined' ? $request->mesin_id[$key] : null,
                        'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : null,
                        'jumlah2' => $request->jumlah2[$key] ? Controller::unformat_angka($request->jumlah2[$key]) : null,
                    ];
                }
                $prodtarik->prodtarikdetail()->delete();
                $prodtarik->prodtarikdetail()->createMany($detail);
            }
            DB::commit();
            return redirect()->route('prodtarik.index')->with([
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
    public function show(Prodtarik $prodtarik)
    {
        return view('produksibelakang.tarik.show', compact('prodtarik'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prodtarik $prodtarik)
    {
        return view('produksibelakang.tarik.edit', compact('prodtarik'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prodtarik $prodtarik)
    {
        $validator = Validator::make($request->all(), [
            'shift' => 'required',
            'operator' => 'required',
            'tanggal' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $prodtarik->shift = $request->shift;
            $prodtarik->operator = $request->operator;
            $prodtarik->tanggal = $request->tanggal;
            $prodtarik->keterangan = $request->keterangan;
            $prodtarik->created_by = Auth::user()->id;
            $prodtarik->save();
            if ($request->has('material_id')) {
                foreach ($request->material_id as $key => $material_id) {
                    $detail[] = [
                        'prodtarik_id' => $prodtarik->id,
                        'slug' => Controller::gen_slug(),
                        'prodwelding_id' => $request->prodwelding_id && $request->prodwelding_id[$key] != 'undefined' ? $request->prowelding_id[$key] : null,
                        'material_id' => $request->material_id && $request->material_id[$key] != 'undefined' ? $request->material_id[$key] : null,
                        'mesin_id' => $request->mesin_id && $request->mesin_id[$key] != 'undefined' ? $request->mesin_id[$key] : null,
                        'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : null,
                        'jumlah2' => $request->jumlah2[$key] ? Controller::unformat_angka($request->jumlah2[$key]) : null,
                    ];
                }
                $prodtarik->prodtarikdetail()->delete();
                $prodtarik->prodtarikdetail()->createMany($detail);
            }
            DB::commit();
            return redirect()->route('prodtarik.index')->with([
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
    public function destroy(Prodtarik $prodtarik)
    {
        DB::beginTransaction();
        try {
            $prodtarik->prodtarikdetail()->delete();
            $prodtarik->delete();
            DB::commit();
            return redirect()->route('prodtarik.index')->with([
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

    public function get_prodwelding(Request $request)
    {
        if ($request->ajax()) {
            $term = trim($request->term);
            $prodwelding = Prodwelding::selectRaw("id, nomor as text")
                ->where('status', 'Panen')
                ->where('nomor', 'like', '%' . $term . '%')
                ->orderByRaw('CONVERT(nomor, SIGNED) asc')->simplePaginate(10);
            $total_count = count($prodwelding);
            $morePages = true;
            $pagination_obj = json_encode($prodwelding);
            if (empty($prodwelding->nextPageUrl())) {
                $morePages = false;
            }
            $result = [
                "results" => $prodwelding->items(),
                "pagination" => [
                    "more" => $morePages
                ],
                "total_count" => $total_count
            ];
            return response()->json($result);
        }
    }

    public function get_prodwelding_by_id(Request $request)
    {
        if ($request->ajax()) {
            $prodwelding = Prodwelding::find($request->prodwelding_id);
            $mesin = Mesin::find($prodwelding->mesin_id);
            $data = [
                'prodwelding' => $prodwelding,
                'mesin' => $mesin,
            ];
            return response()->json($data);
        }
    }
}
