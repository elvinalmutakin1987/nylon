<?php

namespace App\Http\Controllers;

use App\Models\Penerimaanbarang;
use App\Models\Penerimaanbarangdetail;
use App\Models\Material;
use App\Models\Pengaturan;
use App\Models\Permintaanmaterial;
use App\Models\Satuan;
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


class PenerimaanbarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $tanggal_dari = request()->tanggal_dari ?? \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
            $tanggal_sampai = request()->tanggal_sampai ?? \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d');
            $penerimaanbarang = Penerimaanbarang::query();
            if (request()->supplier != 'null' && request()->supplier != '') {
                $penerimaanbarang->where('supplier', request()->supplier);
            }
            if (request()->status != 'null' && request()->status != '') {
                $penerimaanbarang->where('status', request()->status);
            }
            $penerimaanbarang->whereDate('tanggal', '>=', $tanggal_dari);
            $penerimaanbarang->whereDate('tanggal', '<=', $tanggal_sampai);
            $penerimaanbarang->get();
            return DataTables::of($penerimaanbarang)
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
                    if ($item->status == 'Approved') {
                        $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('penerimaanbarang.show', $item->slug) . '")"> <i class="fas fa-search"></i> Detail</a>
                            <a class="dropdown-item" href="' . route('penerimaanbarang.cetak', $item->slug) . '")"> <i class="fas fa-print"></i> Cetak</a>
                        </div>';
                    } else {
                        $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('penerimaanbarang.show', $item->slug) . '")"> <i class="fas fa-search"></i> Detail</a>
                            <a class="dropdown-item" href="' . route('penerimaanbarang.cetak', $item->slug) . '")"> <i class="fas fa-print"></i> Cetak</a>
                            <a class="dropdown-item" href="' . route('penerimaanbarang.edit', $item->slug) . '")"> <i class="fas fa-pencil-alt"></i> Edit</a>
                            <button class="dropdown-item" onClick="hapus(\'' . $item->slug . '\')"><i class="fas fa-trash"></i> Hapus</button>
                        </div>';
                    }

                    return $button;
                })
                ->make();
        }
        return view('gudangbahanbaku.penerimaanbarang.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $satuan = Satuan::all();
        $pengaturan = Pengaturan::where('keterangan', 'gudang.bahan-baku.penerimaanbarang.butuh.approval')->first();
        return view('gudangbahanbaku.penerimaanbarang.create', compact('pengaturan', 'satuan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.bahan-baku.barangmasuk.butuh.approval')->first();
            $gen_no_dokumen = Controller::gen_no_dokumen('bahanbaku.penerimaanbarang');
            $penerimaanbarang = new Penerimaanbarang();
            $penerimaanbarang->slug = Controller::gen_slug();
            $penerimaanbarang->supplier = $request->supplier;
            $penerimaanbarang->sj_supplier = $request->sj_supplier;
            $penerimaanbarang->no_dokumen = $gen_no_dokumen['nomor'];
            $penerimaanbarang->tanggal = date('Y-m-d');
            $penerimaanbarang->status = $pengaturan->nilai == 'Tidak' && $request->status == 'Submit' ? 'Approved' : $request->status;
            $penerimaanbarang->catatan = $request->catatan;
            $penerimaanbarang->created_by = Auth::user()->id;
            $penerimaanbarang->save();
            foreach ($request->material_id as $key => $material_id) {
                $detail[] = [
                    'slug' => Controller::gen_slug(),
                    'penerimaanbarang_id' => $penerimaanbarang->id,
                    'material_id' => $material_id,
                    'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : 0,
                    'satuan' => $request->satuan[$key],
                    'keterangan' => $request->keterangan[$key],
                    'created_by' => Auth::user()->id
                ];
            }
            $penerimaanbarang->penerimaanbarangdetail()->createMany($detail);
            if ($penerimaanbarang->status == 'Approved') {
                foreach ($penerimaanbarang->penerimaanbarangdetail as $d) {
                    Controller::update_stok("Masuk", "Gudang Bahan Baku", "Penerimaan Barang", $penerimaanbarang->id, $d->material_id, $d->jumlah, $d->satuan);
                }
            }
            DB::commit();
            return redirect()->route('penerimaanbarang.index')->with([
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
    public function show(Penerimaanbarang $penerimaanbarang)
    {
        return view('gudangbahanbaku.penerimaanbarang.show', compact('penerimaanbarang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penerimaanbarang $penerimaanbarang)
    {
        $satuan = Satuan::all();
        $pengaturan = Pengaturan::where('keterangan', 'gudang.barang-baku.penerimaanbarang.butuh.approval')->first();
        if ($penerimaanbarang->status == 'Approved') {
            return redirect()->route('penerimaanbarang.index')->with([
                'status' => 'error',
                'message' => 'Status dokumen sudah approved!'
            ]);
        }
        return view('gudangbahanbaku.penerimaanbarang.edit', compact('penerimaanbarang', 'pengaturan', 'satuan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penerimaanbarang $penerimaanbarang)
    {
        DB::beginTransaction();
        try {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.bahan-baku.penerimaanbarang.butuh.approval')->first();
            $penerimaanbarang->supplier = $request->supplier;
            $penerimaanbarang->sj_supplier = $request->sj_supplier;
            $penerimaanbarang->tanggal = date('Y-m-d');
            $penerimaanbarang->status = $pengaturan->nilai == 'Tidak' && $request->status == 'Submit' ? 'Approved' : $request->status;
            $penerimaanbarang->catatan = $request->catatan;
            $penerimaanbarang->created_by = Auth::user()->id;
            $penerimaanbarang->save();
            foreach ($request->material_id as $key => $material_id) {
                $detail[] = [
                    'slug' => Controller::gen_slug(),
                    'penerimaanbarang_id' => $penerimaanbarang->id,
                    'material_id' => $material_id,
                    'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : 0,
                    'satuan' => $request->satuan[$key],
                    'keterangan' => $request->keterangan[$key],
                    'created_by' => Auth::user()->id
                ];
            }
            $penerimaanbarang->penerimaanbarangdetail()->delete();
            $penerimaanbarang->penerimaanbarangdetail()->createMany($detail);
            if ($penerimaanbarang->status == 'Approved') {
                foreach ($penerimaanbarang->penerimaanbarangdetail as $d) {
                    Controller::update_stok("Masuk", "Barang Bahan Baku", "Penerimaan Barang", $penerimaanbarang->id, $d->material_id, $d->jumlah, $d->satuan);
                }
            }
            DB::commit();
            return redirect()->route('penerimaanbarang.index')->with([
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
    public function destroy(Penerimaanbarang $penerimaanbarang)
    {
        DB::beginTransaction();
        try {
            $penerimaanbarang->penerimaanbarangdetail()->delete();
            $penerimaanbarang->delete();
            DB::commit();
            return redirect()->route('penerimaanbarang.index')->with([
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

    public function get_penerimaanbarang_by_id(Request $request)
    {
        if ($request->ajax()) {
            $penerimaanbarang = Penerimaanbarang::find($request->id);
            $data = [
                'penerimaanbarang' => $penerimaanbarang,
            ];
            return response()->json($data);
        }
    }


    public function cetak(Penerimaanbarang $penerimaanbarang)
    {
        $pdf = PDF::loadview('penerimaanbarang.cetak', compact(
            'penerimaanbarang'
        ));
        return $pdf->download('penerimaanbarang-' . $penerimaanbarang->no_dokumen . '.pdf');
    }

    public function get_supplier(Request $request)
    {
        if ($request->ajax()) {
            $term = trim($request->term);
            // $material = Material::selectRaw("id, nama as text")
            //     ->where('nama', 'like', '%' . $term . '%')
            //     ->orderBy('nama')->simplePaginate(10);
            $supplier = Penerimaanbarang::selectRaw("supplier as id, supplier as text")
                ->where('supplier', 'like', '%' . $term . '%')
                ->groupBy('supplier')
                ->orderBy('supplier')->simplePaginate(10);
            $total_count = count($supplier);
            $morePages = true;
            $pagination_obj = json_encode($supplier);
            if (empty($supplier->nextPageUrl())) {
                $morePages = false;
            }
            $result = [
                "results" => $supplier->items(),
                "pagination" => [
                    "more" => $morePages
                ],
                "total_count" => $total_count
            ];
            return response()->json($result);
        }
    }
}
