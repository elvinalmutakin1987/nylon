<?php

namespace App\Http\Controllers;

use App\Models\Histori;
use App\Models\Material;
use App\Models\Pengaturan;
use App\Models\Permintaanmaterial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class PermintaanmaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $permintaanmaterial = Permintaanmaterial::query();
            $permintaanmaterial->where('dokumen', 'Permintaan Bahan Baku')->get();
            return DataTables::of($permintaanmaterial)
                ->addIndexColumn()
                ->addColumn('dibuat_oleh', function ($item) {
                    $user = User::find($item->created_by);
                    return $user ? $user->name : null;
                })
                ->addColumn('disetujui_oleh', function ($item) {
                    $user = User::find($item->approved_by);
                    return $user ? $user->name : null;
                })
                ->addColumn('action', function ($item) {
                    $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('permintaanmaterial.cetak', $item->slug) . '")"> <i class="fas fa-print"></i> Cetak</a>
                            <a class="dropdown-item" href="' . route('permintaanmaterial.show', $item->slug) . '")"> <i class="fas fa-search"></i> Detail</a>
                            <a class="dropdown-item" href="' . route('permintaanmaterial.edit', $item->slug) . '")"> <i class="fas fa-pencil-alt"></i> Edit</a>
                            <button class="dropdown-item" onClick="hapus(\'' . $item->slug . '\')"><i class="fas fa-trash"></i> Hapus</button>
                        </div>';
                    return $button;
                })
                ->make();
        }
        return view('permintaanmaterial.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pengaturan = Pengaturan::where('keterangan', 'permintaanmaterial.butuh.approval')->first();
        return view('permintaanmaterial.create', compact('pengaturan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $pengaturan = Pengaturan::where('keterangan', 'permintaanmaterial.butuh.approval')->first();
            $gen_no_dokumen = Controller::gen_no_dokumen('permintaanmaterial');
            $permintaanmaterial = new Permintaanmaterial();
            $permintaanmaterial->slug = Controller::gen_slug();
            $permintaanmaterial->dokumen = "Permintaan Bahan Baku";
            $permintaanmaterial->no_dokumen = $gen_no_dokumen['nomor'];
            $permintaanmaterial->tanggal = date('Y-m-d');
            $permintaanmaterial->status = $pengaturan->nilai == 'Ya' ? $request->status : 'Approved';
            $permintaanmaterial->created_by = Auth::user()->id;
            $permintaanmaterial->save();
            foreach ($request->material_id as $key => $material_id) {
                $detail[] = [
                    'slug' => Controller::gen_slug(),
                    'permintaanmaterial_id' => $permintaanmaterial->id,
                    'material_id' => $material_id,
                    'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : 0,
                    'satuan' => $request->satuan[$key],
                    'keterangan' => $request->keterangan[$key],
                    'created_by' => Auth::user()->id
                ];
            }
            $permintaanmaterial->permintaanmaterialdetail()->createMany($detail);

            DB::commit();
            return redirect()->route('permintaanmaterial.index')->with([
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
    public function show(Permintaanmaterial $permintaanmaterial)
    {
        return view('permintaanmaterial.show', compact('permintaanmaterial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permintaanmaterial $permintaanmaterial)
    {
        $pengaturan = Pengaturan::where('keterangan', 'permintaanmaterial.butuh.approval')->first();
        return view('permintaanmaterial.edit', compact('permintaanmaterial', 'pengaturan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permintaanmaterial $permintaanmaterial)
    {
        DB::beginTransaction();
        try {
            $pengaturan = Pengaturan::where('keterangan', 'permintaanmaterial.butuh.approval')->first();
            $permintaanmaterial->status = $pengaturan->nilai == 'Ya' ? $request->status : 'Approved';
            $permintaanmaterial->updated_by = Auth::user()->id;
            $permintaanmaterial->save();
            if ($permintaanmaterial->status == 'Draft' || $permintaanmaterial->status == 'Submit') {
                foreach ($request->material_id as $key => $material_id) {
                    $detail[] = [
                        'slug' => Controller::gen_slug(),
                        'permintaanmaterial_id' => $permintaanmaterial->id,
                        'material_id' => $material_id,
                        'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : 0,
                        'satuan' => $request->satuan[$key],
                        'keterangan' => $request->keterangan[$key],
                        'created_by' => Auth::user()->id
                    ];
                }
                $permintaanmaterial->permintaanmaterialdetail()->delete();
                $permintaanmaterial->permintaanmaterialdetail()->createMany($detail);
            }
            DB::commit();
            return redirect()->route('permintaanmaterial.index')->with([
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
    public function destroy(Permintaanmaterial $permintaanmaterial)
    {
        DB::beginTransaction();
        try {
            $permintaanmaterial->permintaanmaterialdetail()->delete();
            $permintaanmaterial->delete();
            DB::commit();
            return redirect()->route('permintaanmaterial.index')->with([
                'status' => 'success',
                'message' => 'Data telah dihapus!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('error', compact('th'));
        }
    }

    public function get_material(Request $request)
    {
        if ($request->ajax()) {
            $term = trim($request->term);
            $material = Material::selectRaw("id, nama as text")
                ->where('nama', 'like', '%' . $term . '%')
                ->orWhere('jenis', '=', 'Raw Material')
                ->orWhere('jenis', '=', 'Semi Finished')
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

    public function cetak(Permintaanmaterial $permintaanmaterial)
    {
        $pdf = PDF::loadview('permintaanmaterial.cetak', compact(
            'permintaanmaterial'
        ));
        return $pdf->download('permintaanmaterial-' .  $permintaanmaterial->nomor . '.pdf');
    }
}
