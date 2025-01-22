<?php

namespace App\Http\Controllers;

use App\Models\Barangkeluar;
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

class BarangkeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $tanggal_dari = request()->tanggal_dari ?? \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
            $tanggal_sampai = request()->tanggal_sampai ?? \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d');
            $barangkeluar = Barangkeluar::query();
            $barangkeluar->where('gudang', request()->gudang);
            if (request()->status != 'null' && request()->status != '') {
                $barangkeluar->where('status', request()->status);
            }
            $barangkeluar->whereDate('tanggal', '>=', $tanggal_dari);
            $barangkeluar->whereDate('tanggal', '<=', $tanggal_sampai);
            $barangkeluar->get();
            return DataTables::of($barangkeluar)
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
                            <a class="dropdown-item" href="' . route('barangkeluar.show', $item->slug) . '")"> <i class="fas fa-search"></i> Detail</a>
                            <a class="dropdown-item" href="' . route('barangkeluar.cetak', $item->slug) . '")"> <i class="fas fa-print"></i> Cetak</a>
                        </div>';
                    } else {
                        $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('barangkeluar.show', $item->slug) . '")"> <i class="fas fa-search"></i> Detail</a>
                            <a class="dropdown-item" href="' . route('barangkeluar.cetak', $item->slug) . '")"> <i class="fas fa-print"></i> Cetak</a>
                            <a class="dropdown-item" href="' . route('barangkeluar.edit', $item->slug) . '")"> <i class="fas fa-pencil-alt"></i> Edit</a>
                            <button class="dropdown-item" onClick="hapus(\'' . $item->slug . '\')"><i class="fas fa-trash"></i> Hapus</button>
                        </div>';
                    }

                    return $button;
                })
                ->make();
        }
        if (request()->gudang == 'bahan-baku') {
            return view('gudangbahanbaku.barangkeluar.index');
        } elseif (request()->gudang == 'benang') {
            return view('gudangbenang.barangkeluar.index');
        } elseif (request()->gudang == 'barang-jadi') {
            return view('gudangbarangjadi.barangkeluar.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gudang = request()->gudang;
        if ($gudang == 'bahan-baku') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.bahan-baku.barangkeluar.butuh.approval')->first();
            return view('gudangbahanbaku.barangkeluar.create', compact('pengaturan', 'gudang'));
        } elseif ($gudang == 'benang') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.benang.barangkeluar.butuh.approval')->first();
            return view('gudangbenang.barangkeluar.create', compact('pengaturan', 'gudang'));
        } elseif ($gudang == 'barang-jadi') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.barang-jadi.barangkeluar.butuh.approval')->first();
            return view('gudangbarangjadi.barangkeluar.create', compact('pengaturan', 'gudang'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.barang-jadi.barangkeluar.butuh.approval')->first();
            $gen_no_dokumen = Controller::gen_no_dokumen('barangjadi.barangkeluar');
            $barangkeluar = new Barangkeluar();
            $barangkeluar->slug = Controller::gen_slug();
            $barangkeluar->permintaanmaterial_id = $request->permintaanmaterial_id;
            $barangkeluar->no_dokumen = $gen_no_dokumen['nomor'];
            $barangkeluar->gudang = $request->gudang;
            $barangkeluar->tanggal = date('Y-m-d');
            $barangkeluar->status = $pengaturan->nilai == 'Tidak' && $request->status == 'Submit' ? 'Approved' : $request->status;
            $barangkeluar->catatan = $request->catatan;
            $barangkeluar->created_by = Auth::user()->id;
            $barangkeluar->save();
            foreach ($request->material_id as $key => $material_id) {
                $detail[] = [
                    'slug' => Controller::gen_slug(),
                    'barangkeluar_id' => $barangkeluar->id,
                    'material_id' => $material_id,
                    'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : 0,
                    'satuan' => $request->satuan[$key],
                    'keterangan' => $request->keterangan[$key],
                    'created_by' => Auth::user()->id
                ];
            }
            $barangkeluar->barangkeluardetail()->createMany($detail);
            if ($barangkeluar->status == 'Approved') {
                foreach ($barangkeluar->barangkeluardetail as $d) {
                    Controller::update_stok("Keluar", "Gudang Barang Jadi", "Barang Keluar", $barangkeluar->id, $d->material_id, $d->jumlah, $d->satuan);
                }
            }
            DB::commit();
            return redirect()->route('barangkeluar.index', ['gudang' => $barangkeluar->gudang])->with([
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
    public function show(Barangkeluar $barangkeluar)
    {
        return view('gudangbarangjadi.barangkeluar.show', compact('barangkeluar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barangkeluar $barangkeluar)
    {
        $pengaturan = Pengaturan::where('keterangan', 'gudang.barang-jadi.barangkeluar.butuh.approval')->first();
        if ($barangkeluar->status == 'Approved') {
            return redirect()->route('barangkeluar.index')->with([
                'status' => 'error',
                'message' => 'Status dokumen sudah approved!'
            ]);
        }
        $gudang = $barangkeluar->gudang;
        return view('gudangbarangjadi.barangkeluar.edit', compact('barangkeluar', 'pengaturan', 'gudang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barangkeluar $barangkeluar)
    {
        DB::beginTransaction();
        try {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.barang-jadi.barangkeluar.butuh.approval')->first();
            $barangkeluar->permintaanmaterial_id = $request->permintaanmaterial_id;
            $barangkeluar->tanggal = date('Y-m-d');
            $barangkeluar->status = $pengaturan->nilai == 'Tidak' && $request->status == 'Submit' ? 'Approved' : $request->status;
            $barangkeluar->catatan = $request->catatan;
            $barangkeluar->created_by = Auth::user()->id;
            $barangkeluar->save();
            foreach ($request->material_id as $key => $material_id) {
                $detail[] = [
                    'slug' => Controller::gen_slug(),
                    'barangkeluar_id' => $barangkeluar->id,
                    'material_id' => $material_id,
                    'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : 0,
                    'satuan' => $request->satuan[$key],
                    'keterangan' => $request->keterangan[$key],
                    'created_by' => Auth::user()->id
                ];
            }
            $barangkeluar->barangkeluardetail()->delete();
            $barangkeluar->barangkeluardetail()->createMany($detail);
            if ($barangkeluar->status == 'Approved') {
                foreach ($barangkeluar->barangkeluardetail as $d) {
                    Controller::update_stok("Keluar", "Gudang Barang Jadi", "Barang Keluar", $barangkeluar->id, $d->material_id, $d->jumlah, $d->satuan);
                }
            }
            DB::commit();
            return redirect()->route('barangkeluar.index', ['gudang' => $barangkeluar->gudang])->with([
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
    public function destroy(Barangkeluar $barangkeluar)
    {
        DB::beginTransaction();
        try {
            $gudang = $barangkeluar->gudang;
            $barangkeluar->barangkeluardetail()->delete();
            $barangkeluar->delete();
            DB::commit();
            return redirect()->route('barangkeluar.index', ['gudang' => $gudang])->with([
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
                ->where('jenis', '=', 'Barang Jadi')
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

    public function get_referensi(Request $request)
    {
        if ($request->ajax()) {
            $term = trim($request->term);
            $permintaanmaterial = Permintaanmaterial::selectRaw("id, no_dokumen as text")
                ->where('no_dokumen', 'like', '%' . $term . '%')
                ->orderBy('no_dokumen')->simplePaginate(10);
            $total_count = count($permintaanmaterial);
            $morePages = true;
            $pagination_obj = json_encode($permintaanmaterial);
            if (empty($permintaanmaterial->nextPageUrl())) {
                $morePages = false;
            }
            $result = [
                "results" => $permintaanmaterial->items(),
                "pagination" => [
                    "more" => $morePages
                ],
                "total_count" => $total_count
            ];
            return response()->json($result);
        }
    }

    public function get_permintaanmaterial(Request $request)
    {
        if ($request->ajax()) {
            $term = trim($request->term);
            $permintaanmaterial = Permintaanmaterial::selectRaw("id, no_dokumen as text")
                ->where('no_dokumen', 'like', '%' . $term . '%')
                ->orderBy('no_dokumen')->simplePaginate(10);
            $total_count = count($permintaanmaterial);
            $morePages = true;
            $pagination_obj = json_encode($permintaanmaterial);
            if (empty($permintaanmaterial->nextPageUrl())) {
                $morePages = false;
            }
            $result = [
                "results" => $permintaanmaterial->items(),
                "pagination" => [
                    "more" => $morePages
                ],
                "total_count" => $total_count
            ];
            return response()->json($result);
        }
    }

    public function get_permintaanmaterial_by_id(Request $request)
    {
        if ($request->ajax()) {
            $permintaanmaterial = Permintaanmaterial::find($request->id);
            $data = [
                'permintaanmaterial' => $permintaanmaterial,
            ];
            return response()->json($data);
        }
    }


    public function cetak(Barangkeluar $barangkeluar)
    {
        $pdf = PDF::loadview('gudangbarangjadi.barangkeluar.cetak', compact(
            'barangkeluar'
        ));
        return $pdf->download('barangkeluar-' .  $barangkeluar->no_dokumen . '.pdf');
    }
}
