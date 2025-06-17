<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Mesin;
use App\Models\Pengaturan;
use App\Models\Produksiwelding;
use App\Models\Produksiweldingdetail;
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

class ProduksiweldingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $produksiwelding = Produksiwelding::query();
            return DataTables::of($produksiwelding)
                ->addIndexColumn()
                ->addColumn('total_produksi', function ($item) {
                    $total_produksi = 0;
                    $produksiweldingdetail = Produksiweldingdetail::where('produksiwelding_id', $item->id)->get();
                    foreach ($produksiweldingdetail as $d) {
                        $total_produksi += (float)$d->total;
                    }
                    return $total_produksi;
                })
                ->addColumn('action', function ($item) {
                    $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('produksiwelding.laporan.show', $item->slug) . '")"> <i class="fas fa-eye"></i> Detail</a>';
                    if (Auth::user()->can('produksi.welding.laporan.edit')) {
                        $button .= '<a class="dropdown-item" href="' . route('produksiwelding.laporan.edit', $item->slug) . '")"> <i class="fas fa-edit"></i> Edit</a>';
                        $button .= '<button class="dropdown-item" onClick="hapus(\'' . $item->slug . '\')"><i class="fas fa-trash"></i> Hapus</button>
                        </div>';
                    }
                    return $button;
                })
                ->make();
        }
        return view('produksiwelding.laporan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produksiwelding.laporan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'operator' => 'required',
            'tanggal' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $gen_no_dokumen = Controller::gen_no_dokumen('produksiwelding');
            $produksiwelding = Produksiwelding::where('tanggal', Carbon::parse($request->tanggal)->format('Y-m-d'))
                ->where('operator', $request->operator)
                ->first();
            if (!$produksiwelding) {
                $produksiwelding = new Produksiwelding();
                $produksiwelding->slug = Controller::gen_slug();
                $produksiwelding->tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
                $produksiwelding->operator = $request->operator;
                $produksiwelding->shift = $request->shift;
                $produksiwelding->created_by = Auth::user()->id;
            }
            $produksiwelding->updated_by = Auth::user()->id;
            $produksiwelding->save();
            if ($request->has('jenis')) {
                foreach ($request->jenis as $key => $jenis) {
                    $detail[] = [
                        'produksiwelding_id' => $produksiwelding->id,
                        'slug' => Controller::gen_slug(),
                        'jenis' => $request->jenis[$key],
                        'ukuran1' => $request->ukuran1[$key] ? Controller::unformat_angka($request->ukuran1[$key]) : null,
                        'ukuran2' => $request->ukuran2[$key] ? Controller::unformat_angka($request->ukuran2[$key]) : null,
                        'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : null,
                        'total' => $request->total[$key] ? Controller::unformat_angka($request->total[$key]) : null,
                        'keterangan' => $request->keteranga,
                    ];
                }
                $produksiwelding->produksiweldingdetail()->delete();
                $produksiwelding->produksiweldingdetail()->createMany($detail);
            }
            DB::commit();
            return redirect()->route('produksiwelding.laporan.index')->with([
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
    public function show(Produksiwelding $produksiwelding)
    {
        return view('produksiwelding.laporan.show', compact('produksiwelding'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produksiwelding $produksiwelding)
    {
        return view('produksiwelding.laporan.edit', compact('produksiwelding'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produksiwelding $produksiwelding)
    {
        $validator = Validator::make($request->all(), [
            'operator' => 'required',
            'tanggal' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $produksiwelding->tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
            $produksiwelding->operator = $request->operator;
            $produksiwelding->shift = $request->shift;
            $produksiwelding->created_by = Auth::user()->id;
            $produksiwelding->save();
            if ($request->has('jenis')) {
                foreach ($request->jenis as $key => $jenis) {
                    $detail[] = [
                        'produksiwelding_id' => $produksiwelding->id,
                        'slug' => Controller::gen_slug(),
                        'jenis' => $request->jenis[$key],
                        'ukuran1' => $request->ukuran1[$key] ? Controller::unformat_angka($request->ukuran1[$key]) : null,
                        'ukuran2' => $request->ukuran2[$key] ? Controller::unformat_angka($request->ukuran2[$key]) : null,
                        'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : null,
                        'total' => $request->total[$key] ? Controller::unformat_angka($request->total[$key]) : null,
                        'keterangan' => $request->keteranga,
                    ];
                }
                $produksiwelding->produksiweldingdetail()->delete();
                $produksiwelding->produksiweldingdetail()->createMany($detail);
            }
            DB::commit();
            return redirect()->route('produksiwelding.laporan.index')->with([
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
    public function destroy(Produksiwelding $produksiwelding)
    {
        DB::beginTransaction();
        try {
            $produksiwelding->produksiweldingdetail()->delete();
            $produksiwelding->delete();
            DB::commit();
            return redirect()->route('produksiwelding.laporan.index')->with([
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
}
