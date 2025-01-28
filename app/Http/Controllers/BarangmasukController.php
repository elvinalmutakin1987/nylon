<?php

namespace App\Http\Controllers;

use App\Models\Barangkeluar;
use App\Models\Barangmasuk;
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

class BarangmasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $tanggal_dari = request()->tanggal_dari ?? \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
            $tanggal_sampai = request()->tanggal_sampai ?? \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d');
            $barangmasuk = Barangmasuk::query();
            $barangmasuk->where('gudang', request()->gudang);
            if (request()->asal != 'null' && request()->asal != '') {
                $barangmasuk->where('asal', request()->asal == '-' ? null : request()->asal);
            }
            if (request()->status != 'null' && request()->status != '') {
                $barangmasuk->where('status', request()->status);
            }
            $barangmasuk->whereDate('tanggal', '>=', $tanggal_dari);
            $barangmasuk->whereDate('tanggal', '<=', $tanggal_sampai);
            $barangmasuk->get();
            return DataTables::of($barangmasuk)
                ->addIndexColumn()
                ->addColumn('asalnya', function ($item) {
                    $asal = "";
                    if ($item->asal == 'barang-jadi') {
                        $asal = 'Barang Jadi';
                    } elseif ($item->asal == 'bahan-baku' || $item->asal == 'bahan-penolong') {
                        $asal = 'Bahan Baku';
                    } elseif ($item->asal == 'benang') {
                        $asal = 'Benang';
                    } elseif ($item->asal == 'wjl') {
                        $asal = 'WJL';
                    } elseif ($item->asal == 'sulzer') {
                        $asal = 'Sulzer';
                    } elseif ($item->asal == 'rashel') {
                        $asal = 'Rashel';
                    } elseif ($item->asal == 'extruder') {
                        $asal = 'Extruder';
                    } elseif ($item->asal == 'beaming') {
                        $asal = 'Beaming';
                    } elseif ($item->asal == 'packing') {
                        $asal = 'Packing';
                    }
                    return $asal;
                })
                ->addColumn('dibuat_oleh', function ($item) {
                    $user = User::find($item->created_by);
                    return $user ? $user->name : null;
                })
                ->addColumn('disetujui_oleh', function ($item) {
                    $user = User::find($item->approved_by);
                    return $user ? $user->name : null;
                })
                ->addColumn('barangkeluar', function ($item) {
                    $barangkeluar = Barangkeluar::find($item->barangkeluar_id);
                    return $barangkeluar ? $barangkeluar->no_dokumen : null;
                })
                ->addColumn('action', function ($item) {
                    if ($item->status == 'Approved') {
                        $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('barangmasuk.show', $item->slug) . '")"> <i class="fas fa-search"></i> Detail</a>
                            <a class="dropdown-item" href="' . route('barangmasuk.cetak', $item->slug) . '")"> <i class="fas fa-print"></i> Cetak</a>
                        </div>';
                    } else {
                        $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('barangmasuk.show', $item->slug) . '")"> <i class="fas fa-search"></i> Detail</a>
                            <a class="dropdown-item" href="' . route('barangmasuk.cetak', $item->slug) . '")"> <i class="fas fa-print"></i> Cetak</a>
                            <a class="dropdown-item" href="' . route('barangmasuk.edit', $item->slug) . '")"> <i class="fas fa-pencil-alt"></i> Edit</a>
                            <button class="dropdown-item" onClick="hapus(\'' . $item->slug . '\')"><i class="fas fa-trash"></i> Hapus</button>
                        </div>';
                    }

                    return $button;
                })
                ->make();
        }
        if (request()->gudang == 'bahan-baku' || request()->gudang == 'bahan-penolong') {
            return view('gudangbahanbaku.barangmasuk.index');
        } elseif (request()->gudang == 'benang') {
            return view('gudangbenang.barangmasuk.index');
        } elseif (request()->gudang == 'barang-jadi') {
            return view('gudangbarangjadi.barangmasuk.index');
        } elseif (request()->gudang == 'extruder') {
            return view('gudangextruder.barangmasuk.index');
        } elseif (request()->gudang == 'wjl') {
            return view('gudangwjl.barangmasuk.index');
        } elseif (request()->gudang == 'sulzer') {
            return view('gudangsulzer.barangmasuk.index');
        } elseif (request()->gudang == 'rashel') {
            return view('gudangrashel.barangmasuk.index');
        } elseif (request()->gudang == 'beaming') {
            return view('gudangbeaming.barangmasuk.index');
        } elseif (request()->gudang == 'packing') {
            return view('gudangpacking.barangmasuk.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gudang = request()->gudang;
        if ($gudang == 'bahan-baku' || $gudang == 'bahan-penolong') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.bahan-baku.barangmasuk.butuh.approval')->first();
            return view('gudangbahanbaku.barangmasuk.create', compact('pengaturan', 'gudang'));
        } elseif ($gudang == 'benang') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.benang.barangmasuk.butuh.approval')->first();
            return view('gudangbenang.barangmasuk.create', compact('pengaturan', 'gudang'));
        } elseif ($gudang == 'barang-jadi') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.barang-jadi.barangmasuk.butuh.approval')->first();
            return view('gudangbarangjadi.barangmasuk.create', compact('pengaturan', 'gudang'));
        } elseif ($gudang == 'extruder') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.extruder.barangmasuk.butuh.approval')->first();
            return view('gudangextruder.barangmasuk.create', compact('pengaturan', 'gudang'));
        } elseif ($gudang == 'wjl') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.wjl.barangmasuk.butuh.approval')->first();
            return view('gudangwjl.barangmasuk.create', compact('pengaturan', 'gudang'));
        } elseif ($gudang == 'sulzer') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.sulzer.barangmasuk.butuh.approval')->first();
            return view('gudangsulzer.barangmasuk.create', compact('pengaturan', 'gudang'));
        } elseif ($gudang == 'rashel') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.rashel.barangmasuk.butuh.approval')->first();
            return view('gudangrashel.barangmasuk.create', compact('pengaturan', 'gudang'));
        } elseif ($gudang == 'beaming') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.beaming.barangmasuk.butuh.approval')->first();
            return view('gudangbeaming.barangmasuk.create', compact('pengaturan', 'gudang'));
        } elseif ($gudang == 'packing') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.packing.barangmasuk.butuh.approval')->first();
            return view('gudangpacking.barangmasuk.create', compact('pengaturan', 'gudang'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.barang-jadi.barangmasuk.butuh.approval')->first();
            $gen_no_dokumen = Controller::gen_no_dokumen('barangjadi.barangmasuk');
            $barangmasuk = new Barangmasuk();
            $barangmasuk->slug = Controller::gen_slug();
            $barangmasuk->asal = $request->asal;
            $barangmasuk->barangkeluar_id = $request->barangkeluar_id;
            $barangmasuk->no_dokumen = $gen_no_dokumen['nomor'];
            $barangmasuk->gudang = $request->gudang;
            $barangmasuk->tanggal = date('Y-m-d');
            $barangmasuk->status = $pengaturan->nilai == 'Tidak' && $request->status == 'Submit' ? 'Approved' : $request->status;
            $barangmasuk->catatan = $request->catatan;
            $barangmasuk->created_by = Auth::user()->id;
            $barangmasuk->save();
            foreach ($request->material_id as $key => $material_id) {
                $detail[] = [
                    'slug' => Controller::gen_slug(),
                    'barangmasuk_id' => $barangmasuk->id,
                    'material_id' => $material_id,
                    'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : 0,
                    'satuan' => $request->satuan[$key],
                    'keterangan' => $request->keterangan[$key],
                    'created_by' => Auth::user()->id
                ];
            }
            $barangmasuk->barangmasukdetail()->createMany($detail);
            if ($barangmasuk->status == 'Approved') {
                foreach ($barangmasuk->barangmasukdetail as $d) {
                    Controller::update_stok("Masuk", "Gudang Barang Jadi", "Barang Masuk", $barangmasuk->id, $d->material_id, $d->jumlah, $d->satuan);
                }
            }
            DB::commit();
            return redirect()->route('barangmasuk.index', ['gudang' => $barangmasuk->gudang])->with([
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
    public function show(Barangmasuk $barangmasuk)
    {
        if ($barangmasuk->gudang == 'bahan-baku' || $barangmasuk->gudang == 'bahan-penolong') {
            return view('gudangbahanbaku.barangmasuk.show', compact('barangmasuk'));
        } elseif ($barangmasuk->gudang == 'benang') {
            return view('gudangbenang.barangmasuk.show', compact('barangmasuk'));
        } elseif ($barangmasuk->gudang == 'barang-jadi') {
            return view('gudangbarangjadi.barangmasuk.show', compact('barangmasuk'));
        } elseif ($barangmasuk->gudang == 'extruder') {
            return view('gudangextruder.barangmasuk.show', compact('barangmasuk'));
        } elseif ($barangmasuk->gudang == 'wjl') {
            return view('gudangwjl.barangmasuk.show', compact('barangmasuk'));
        } elseif ($barangmasuk->gudang == 'sulzer') {
            return view('gudangsulzer.barangmasuk.show', compact('barangmasuk'));
        } elseif ($barangmasuk->gudang == 'rashel') {
            return view('gudangrashel.barangmasuk.show', compact('barangmasuk'));
        } elseif ($barangmasuk->gudang == 'beaming') {
            return view('gudangbeaming.barangmasuk.show', compact('barangmasuk'));
        } elseif ($barangmasuk->gudang == 'packing') {
            return view('gudangpacking.barangmasuk.show', compact('barangmasuk'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barangmasuk $barangmasuk)
    {
        $pengaturan = Pengaturan::where('keterangan', 'gudang.barang-jadi.barangmasuk.butuh.approval')->first();
        if ($barangmasuk->status == 'Approved') {
            return redirect()->route('barangmasuk.index')->with([
                'status' => 'error',
                'message' => 'Status dokumen sudah approved!'
            ]);
        }
        $gudang = $barangmasuk->gudang;
        if ($gudang == 'bahan-baku' || $gudang == 'bahan-penolong') {
            return view('gudangbahanbaku.barangmasuk.edit', compact('barangmasuk', 'pengaturan', 'gudang'));
        } elseif ($gudang == 'benang') {
            return view('gudangbenang.barangmasuk.edit', compact('barangmasuk', 'pengaturan', 'gudang'));
        } elseif ($gudang == 'barang-jadi') {
            return view('gudangbarangjadi.barangmasuk.edit', compact('barangmasuk', 'pengaturan', 'gudang'));
        } elseif ($gudang == 'extruder') {
            return view('gudangextruder.barangmasuk.edit', compact('barangmasuk', 'pengaturan', 'gudang'));
        } elseif ($gudang == 'wjl') {
            return view('gudangwjl.barangmasuk.edit', compact('barangmasuk', 'pengaturan', 'gudang'));
        } elseif ($gudang == 'sulzer') {
            return view('gudangsulzer.barangmasuk.edit', compact('barangmasuk', 'pengaturan', 'gudang'));
        } elseif ($gudang == 'rashel') {
            return view('gudangrashel.barangmasuk.edit', compact('barangmasuk', 'pengaturan', 'gudang'));
        } elseif ($gudang == 'beaming') {
            return view('gudangbeaming.barangmasuk.edit', compact('barangmasuk', 'pengaturan', 'gudang'));
        } elseif ($gudang == 'packing') {
            return view('gudangpacking.barangmasuk.edit', compact('barangmasuk', 'pengaturan', 'gudang'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barangmasuk $barangmasuk)
    {
        DB::beginTransaction();
        try {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.barang-jadi.barangmasuk.butuh.approval')->first();
            $barangmasuk->asal = $request->asal;
            $barangmasuk->barangkeluar_id = $request->barangkeluar_id;
            $barangmasuk->gudang = $request->gudang;
            $barangmasuk->tanggal = date('Y-m-d');
            $barangmasuk->status = $pengaturan->nilai == 'Tidak' && $request->status == 'Submit' ? 'Approved' : $request->status;
            $barangmasuk->catatan = $request->catatan;
            $barangmasuk->created_by = Auth::user()->id;
            $barangmasuk->save();
            foreach ($request->material_id as $key => $material_id) {
                $detail[] = [
                    'slug' => Controller::gen_slug(),
                    'barangmasuk_id' => $barangmasuk->id,
                    'material_id' => $material_id,
                    'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : 0,
                    'satuan' => $request->satuan[$key],
                    'keterangan' => $request->keterangan[$key],
                    'created_by' => Auth::user()->id
                ];
            }
            $barangmasuk->barangmasukdetail()->delete();
            $barangmasuk->barangmasukdetail()->createMany($detail);
            if ($barangmasuk->status == 'Approved') {
                foreach ($barangmasuk->barangmasukdetail as $d) {
                    Controller::update_stok("Masuk", "Gudang Barang Jadi", "Barang Masuk", $barangmasuk->id, $d->material_id, $d->jumlah, $d->satuan);
                }
            }
            DB::commit();
            return redirect()->route('barangmasuk.index', ['gudang' => $barangmasuk->gudang])->with([
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
    public function destroy(Barangmasuk $barangmasuk)
    {
        DB::beginTransaction();
        try {
            $gudang = $barangmasuk->gudang;
            $barangmasuk->barangmasukdetail()->delete();
            $barangmasuk->delete();
            DB::commit();
            return redirect()->route('barangmasuk.index', ['gudang' => $gudang])->with([
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

    public function get_barangkeluar(Request $request)
    {
        if ($request->ajax()) {
            $term = trim($request->term);
            $barangkeluar = Barangkeluar::selectRaw("id, no_dokumen as text")
                ->where('no_dokumen', 'like', '%' . $term . '%');
            $barangkeluar = $barangkeluar->where('gudang', '=', $request->gudang);
            // $barangkeluar = $barangkeluar->where('status', 'Approved');
            $barangkeluar = $barangkeluar->orderBy('no_dokumen')->simplePaginate(10);
            $total_count = count($barangkeluar);
            $morePages = true;
            $pagination_obj = json_encode($barangkeluar);
            if (empty($barangkeluar->nextPageUrl())) {
                $morePages = false;
            }
            $result = [
                "results" => $barangkeluar->items(),
                "pagination" => [
                    "more" => $morePages
                ],
                "total_count" => $total_count
            ];
            return response()->json($result);
        }
    }

    public function get_barangkeluar_by_id(Request $request)
    {
        if ($request->ajax()) {
            $barangkeluar = Barangkeluar::find($request->id);
            $data = [
                'barangkeluar' => $barangkeluar,
            ];
            return response()->json($data);
        }
    }


    public function cetak(Barangmasuk $barangmasuk)
    {
        $pdf = PDF::loadview('gudangbarangjadi.barangmasuk.cetak', compact(
            'barangmasuk'
        ));
        return $pdf->download('barangmasuk-' .  $barangmasuk->no_dokumen . '.pdf');
    }
}
