<?php

namespace App\Http\Controllers;

use App\Models\Barangkeluar;
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
        } elseif (request()->gudang == 'bahan-penolong') {
            return view('gudangbahanbaku.barangkeluar.index');
        } elseif (request()->gudang == 'benang') {
            return view('gudangbenang.barangkeluar.index');
        } elseif (request()->gudang == 'barang-jadi') {
            return view('gudangbarangjadi.barangkeluar.index');
        } elseif (request()->gudang == 'extruder') {
            return view('gudangextruder.barangkeluar.index');
        } elseif (request()->gudang == 'wjl') {
            return view('gudangwjl.barangkeluar.index');
        } elseif (request()->gudang == 'sulzer') {
            return view('gudangsulzer.barangkeluar.index');
        } elseif (request()->gudang == 'rashel') {
            return view('gudangrashel.barangkeluar.index');
        } elseif (request()->gudang == 'beaming') {
            return view('gudangbeaming.barangkeluar.index');
        } elseif (request()->gudang == 'packing') {
            return view('gudangpacking.barangkeluar.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $satuan = Satuan::all();
        $gudang = request()->gudang;
        if ($gudang == 'bahan-baku' || $gudang == 'bahan-penolong') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.bahan-baku.barangkeluar.butuh.approval')->first();
            return view('gudangbahanbaku.barangkeluar.create', compact('pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'benang') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.benang.barangkeluar.butuh.approval')->first();
            return view('gudangbenang.barangkeluar.create', compact('pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'barang-jadi') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.barang-jadi.barangkeluar.butuh.approval')->first();
            return view('gudangbarangjadi.barangkeluar.create', compact('pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'extruder') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.extruder.barangkeluar.butuh.approval')->first();
            return view('gudangextruder.barangkeluar.create', compact('pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'wjl') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.wjl.barangkeluar.butuh.approval')->first();
            return view('gudangwjl.barangkeluar.create', compact('pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'sulzer') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.sulzer.barangkeluar.butuh.approval')->first();
            return view('gudangsulzer.barangkeluar.create', compact('pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'rashel') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.rashel.barangkeluar.butuh.approval')->first();
            return view('gudangrashel.barangkeluar.create', compact('pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'beaming') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.beaming.barangkeluar.butuh.approval')->first();
            return view('gudangbeaming.barangkeluar.create', compact('pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'packing') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.packing.barangkeluar.butuh.approval')->first();
            return view('gudangpacking.barangkeluar.create', compact('pengaturan', 'gudang', 'satuan'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.' . $request->gudang . '.barangkeluar.butuh.approval')->first();
            if ($request->gudang == 'barang-jadi') {
                $jenis_gudang = 'barangjadi';
                $kartustok_gudang = 'Gudang Barang Jadi';
            } elseif ($request->gudang == 'bahan-baku') {
                $jenis_gudang = 'bahanbaku';
                $kartustok_gudang = 'Gudang Bahan Baku';
            } elseif ($request->gudang == 'bahan-penolong') {
                $jenis_gudang = 'bahanbaku';
                $kartustok_gudang = 'Gudang Bahan Baku';
            } elseif ($request->gudang == 'extruder') {
                $jenis_gudang = 'extruder';
                $kartustok_gudang = 'Gudang Extruder';
            } elseif ($request->gudang == 'wjl') {
                $jenis_gudang = 'wjl';
                $kartustok_gudang = 'Gudang WJL';
            } elseif ($request->gudang == 'sulzer') {
                $jenis_gudang = 'sulzer';
                $kartustok_gudang = 'Gudang Sulzer';
            } elseif ($request->gudang == 'rashel') {
                $jenis_gudang = 'rashel';
                $kartustok_gudang = 'Gudang Rashel';
            } elseif ($request->gudang == 'beaming') {
                $jenis_gudang = 'beaming';
                $kartustok_gudang = 'Gudang Beaming';
            } elseif ($request->gudang == 'packing') {
                $jenis_gudang = 'packing';
                $kartustok_gudang = 'Gudang Packing';
            }
            $gen_no_dokumen = Controller::gen_no_dokumen($jenis_gudang . '.barangkeluar');
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
                    Controller::update_stok("Keluar", $kartustok_gudang, "Barang Keluar", $barangkeluar->id, $d->material_id, $d->jumlah, $d->satuan);
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
        if ($barangkeluar->gudang == 'bahan-baku') {
            return view('gudangbahanbaku.barangkeluar.show', compact('barangkeluar'));
        } elseif ($barangkeluar->gudang == 'bahan-penolong') {
            return view('gudangbahanbaku.barangkeluar.show', compact('barangkeluar'));
        } elseif ($barangkeluar->gudang == 'benang') {
            return view('gudangbenang.barangkeluar.show', compact('barangkeluar'));
        } elseif ($barangkeluar->gudang == 'barang-jadi') {
            return view('gudangbarangjadi.barangkeluar.show', compact('barangkeluar'));
        } elseif ($barangkeluar->gudang == 'extruder') {
            return view('gudangextruder.barangkeluar.show', compact('barangkeluar'));
        } elseif ($barangkeluar->gudang == 'wjl') {
            return view('gudangwjl.barangkeluar.show', compact('barangkeluar'));
        } elseif ($barangkeluar->gudang == 'sulzer') {
            return view('gudangsulzer.barangkeluar.show', compact('barangkeluar'));
        } elseif ($barangkeluar->gudang == 'rashel') {
            return view('gudangrashel.barangkeluar.show', compact('barangkeluar'));
        } elseif ($barangkeluar->gudang == 'beaming') {
            return view('gudangbeaming.barangkeluar.show', compact('barangkeluar'));
        } elseif ($barangkeluar->gudang == 'packing') {
            return view('gudangpacking.barangkeluar.show', compact('barangkeluar'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barangkeluar $barangkeluar)
    {
        $satuan = Satuan::all();
        $pengaturan = Pengaturan::where('keterangan', 'gudang.barang-jadi.barangkeluar.butuh.approval')->first();
        if ($barangkeluar->status == 'Approved') {
            return redirect()->route('barangkeluar.index')->with([
                'status' => 'error',
                'message' => 'Status dokumen sudah approved!'
            ]);
        }
        $gudang = $barangkeluar->gudang;
        if ($gudang == 'bahan-baku') {
            return view('gudangbahanbaku.barangkeluar.edit', compact('barangkeluar', 'pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'bahan-penolong') {
            return view('gudangbahanbaku.barangkeluar.edit', compact('barangkeluar', 'pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'benang') {
            return view('gudangbenang.barangkeluar.edit', compact('barangkeluar', 'pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'barang-jadi') {
            return view('gudangbarangjadi.barangkeluar.edit', compact('barangkeluar', 'pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'extruder') {
            return view('gudangextruder.barangkeluar.edit', compact('barangkeluar', 'pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'wjl') {
            return view('gudangwjl.barangkeluar.edit', compact('barangkeluar', 'pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'sulzer') {
            return view('gudangsulzer.barangkeluar.edit', compact('barangkeluar', 'pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'rashel') {
            return view('gudangrashel.barangkeluar.edit', compact('barangkeluar', 'pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'beaming') {
            return view('gudangbeaming.barangkeluar.edit', compact('barangkeluar', 'pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'packing') {
            return view('gudangpacking.barangkeluar.edit', compact('barangkeluar', 'pengaturan', 'gudang', 'satuan'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barangkeluar $barangkeluar)
    {
        DB::beginTransaction();
        try {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.' . $request->gudang . '.barangkeluar.butuh.approval')->first();
            if ($request->gudang == 'barang-jadi') {
                $jenis_gudang = 'barangjadi';
                $kartustok_gudang = 'Gudang Barang Jadi';
            } elseif ($request->gudang == 'bahan-baku') {
                $jenis_gudang = 'bahanbaku';
                $kartustok_gudang = 'Gudang Bahan Baku';
            } elseif ($request->gudang == 'bahan-penolong') {
                $jenis_gudang = 'bahanbaku';
                $kartustok_gudang = 'Gudang Bahan Baku';
            } elseif ($request->gudang == 'extruder') {
                $jenis_gudang = 'extruder';
                $kartustok_gudang = 'Gudang Extruder';
            } elseif ($request->gudang == 'wjl') {
                $jenis_gudang = 'wjl';
                $kartustok_gudang = 'Gudang WJL';
            } elseif ($request->gudang == 'sulzer') {
                $jenis_gudang = 'sulzer';
                $kartustok_gudang = 'Gudang Sulzer';
            } elseif ($request->gudang == 'rashel') {
                $jenis_gudang = 'rashel';
                $kartustok_gudang = 'Gudang Rashel';
            } elseif ($request->gudang == 'beaming') {
                $jenis_gudang = 'beaming';
                $kartustok_gudang = 'Gudang Beaming';
            } elseif ($request->gudang == 'packing') {
                $jenis_gudang = 'packing';
                $kartustok_gudang = 'Gudang Packing';
            }
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
                    Controller::update_stok("Keluar", $kartustok_gudang, "Barang Keluar", $barangkeluar->id, $d->material_id, $d->jumlah, $d->satuan);
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
            $jenis = "";
            if ($request->gudang == 'bahan-baku') {
                $jenis = 'Bahan Baku';
            } elseif ($request->gudang == 'bahan-penolong') {
                $jenis = 'Bahan Penolong';
            } elseif ($request->gudang == 'benang') {
                $jenis = 'Work In Progress';
            } elseif ($request->gudang == 'barang-jadi') {
                $jenis = 'Barang Jadi';
            } elseif ($request->gudang == 'extruder') {
                $jenis = 'Work In Progress';
            } elseif ($request->gudang == 'wjl') {
                $jenis = 'Work In Progress';
            } elseif ($request->gudang == 'sulzer') {
                $jenis = 'Work In Progress';
            } elseif ($request->gudang == 'rashel') {
                $jenis = 'Work In Progress';
            } elseif ($request->gudang == 'beaming') {
                $jenis = 'Work In Progress';
            } elseif ($request->gudang == 'packing') {
                $jenis = 'Work In Progress';
            }
            $material = Material::selectRaw("id, nama as text")
                ->where('nama', 'like', '%' . $term . '%')
                ->where('jenis', '=', $jenis)
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
        if ($barangkeluar->gudang == 'bahan-baku') {
            $gudang = 'gudangbahanbaku';
        } elseif ($barangkeluar->gudang == 'bahan-penolong') {
            $gudang = 'gudangbahanbaku';
        } elseif ($barangkeluar->gudang == 'benang') {
            $gudang = 'gudangbenang';
        } elseif ($barangkeluar->gudang == 'barang-jadi') {
            $gudang = 'gudangbarangjadi';
        } elseif ($barangkeluar->gudang == 'extruder') {
            $gudang = 'gudangextruder';
        } elseif ($barangkeluar->gudang == 'wjl') {
            $gudang = 'gudangwjl';
        } elseif ($barangkeluar->gudang == 'sulzer') {
            $gudang = 'gudangsulzer';
        } elseif ($barangkeluar->gudang == 'rashel') {
            $gudang = 'gudangrashel';
        } elseif ($barangkeluar->gudang == 'beaming') {
            $gudang = 'gudangbeaming';
        } elseif ($barangkeluar->gudang == 'packing') {
            $gudang = 'gudangpacking';
        }
        $pdf = PDF::loadview($gudang . '.barangkeluar.cetak', compact(
            'barangkeluar'
        ));
        return $pdf->download('barangkeluar-' . $gudang . '-' . $barangkeluar->no_dokumen . '.pdf');
    }
}
