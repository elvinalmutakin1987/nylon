<?php

namespace App\Http\Controllers;

use App\Models\Barangkeluar;
use App\Models\Barangmasuk;
use App\Models\Material;
use App\Models\Pengaturan;
use App\Models\Retur;
use App\Models\Satuan;
use App\Models\Suratjalan;
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

class ReturController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $tanggal_dari = request()->tanggal_dari ?? \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
            $tanggal_sampai = request()->tanggal_sampai ?? \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d');
            $retur = Retur::query();
            $retur->where('gudang', request()->gudang);
            if (request()->status != 'null' && request()->status != '') {
                $retur->where('status', request()->status);
            }
            $retur->whereDate('tanggal', '>=', $tanggal_dari);
            $retur->whereDate('tanggal', '<=', $tanggal_sampai);
            $retur->get();
            return DataTables::of($retur)
                ->addIndexColumn()
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
                ->addColumn('suratjalan', function ($item) {
                    $suratjalan = Suratjalan::find($item->suratjalan_id);
                    return $suratjalan ? $suratjalan->no_dokumen : null;
                })
                ->addColumn('action', function ($item) {
                    if ($item->status == 'Approved') {
                        $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('retur.show', $item->slug) . '")"> <i class="fas fa-search"></i> Detail</a>
                            <a class="dropdown-item" href="' . route('retur.cetak', $item->slug) . '")"> <i class="fas fa-print"></i> Cetak</a>
                        </div>';
                    } else {
                        $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('retur.show', $item->slug) . '")"> <i class="fas fa-search"></i> Detail</a>
                            <a class="dropdown-item" href="' . route('retur.cetak', $item->slug) . '")"> <i class="fas fa-print"></i> Cetak</a>
                            <a class="dropdown-item" href="' . route('retur.edit', $item->slug) . '")"> <i class="fas fa-pencil-alt"></i> Edit</a>
                            <button class="dropdown-item" onClick="hapus(\'' . $item->slug . '\')"><i class="fas fa-trash"></i> Hapus</button>
                        </div>';
                    }

                    return $button;
                })
                ->make();
        }
        if (request()->gudang == 'bahan-baku') {
            return view('gudangbahanbaku.retur.index');
        } elseif (request()->gudang == 'bahan-penolong') {
            return view('gudangbahanbaku.retur.index');
        } elseif (request()->gudang == 'benang') {
            return view('gudangbenang.retur.index');
        } elseif (request()->gudang == 'barang-jadi') {
            return view('gudangbarangjadi.retur.index');
        } elseif (request()->gudang == 'extruder') {
            return view('gudangextruder.retur.index');
        } elseif (request()->gudang == 'wjl') {
            return view('gudangwjl.retur.index');
        } elseif (request()->gudang == 'sulzer') {
            return view('gudangsulzer.retur.index');
        } elseif (request()->gudang == 'rashel') {
            return view('gudangrashel.retur.index');
        } elseif (request()->gudang == 'beaming') {
            return view('gudangbeaming.retur.index');
        } elseif (request()->gudang == 'packing') {
            return view('gudangpacking.retur.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $satuan = Satuan::all();
        $gudang = request()->gudang;
        if ($gudang == 'bahan-baku') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.bahan-baku.retur.butuh.approval')->first();
            return view('gudangbahanbaku.retur.create', compact('pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'bahan-penolong') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.bahan-baku.retur.butuh.approval')->first();
            return view('gudangbahanbaku.retur.create', compact('pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'benang') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.benang.retur.butuh.approval')->first();
            return view('gudangbenang.retur.create', compact('pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'barang-jadi') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.barang-jadi.retur.butuh.approval')->first();
            return view('gudangbarangjadi.retur.create', compact('pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'extruder') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.extruder.retur.butuh.approval')->first();
            return view('gudangextruder.retur.create', compact('pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'wjl') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.wjl.retur.butuh.approval')->first();
            return view('gudangwjl.retur.create', compact('pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'sulzer') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.sulzer.retur.butuh.approval')->first();
            return view('gudangsulzer.retur.create', compact('pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'rashel') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.rashel.retur.butuh.approval')->first();
            return view('gudangrashel.retur.create', compact('pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'beaming') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.beaming.retur.butuh.approval')->first();
            return view('gudangbeaming.retur.create', compact('pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'packing') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.packing.retur.butuh.approval')->first();
            return view('gudangpacking.retur.create', compact('pengaturan', 'gudang', 'satuan'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dokumen_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.' . $request->gudang . '.retur.butuh.approval')->first();
            $jenis_gudang = '';
            $kartustok_gudang = '';
            if ($request->gudang == 'barang-jadi') {
                $jenis_gudang = 'barangjadi.retur';
                $kartustok_gudang = 'Gudang Barang Jadi';
            } elseif ($request->gudang == 'bahan-baku') {
                $jenis_gudang = 'bahanbaku.retur';
                $kartustok_gudang = 'Gudang Bahan Baku';
            } elseif ($request->gudang == 'bahan-penolong') {
                $jenis_gudang = 'bahanbaku.retur';
                $kartustok_gudang = 'Gudang Bahan Baku';
            } elseif ($request->gudang == 'extruder') {
                $jenis_gudang = 'extruder.retur';
                $kartustok_gudang = 'Gudang Extruder';
            } elseif ($request->gudang == 'wjl') {
                $jenis_gudang = 'wjl.retur';
                $kartustok_gudang = 'Gudang WJL';
            } elseif ($request->gudang == 'sulzer') {
                $jenis_gudang = 'sulzer.retur';
                $kartustok_gudang = 'Gudang Sulzer';
            } elseif ($request->gudang == 'rashel') {
                $jenis_gudang = 'rashel.retur';
                $kartustok_gudang = 'Gudang Rashel';
            } elseif ($request->gudang == 'beaming') {
                $jenis_gudang = 'beaming.retur';
                $kartustok_gudang = 'Gudang Beaming';
            } elseif ($request->gudang == 'packing') {
                $jenis_gudang = 'packing.retur';
                $kartustok_gudang = 'Gudang Packing';
            }
            $gen_no_dokumen = Controller::gen_no_dokumen($jenis_gudang);
            $retur = new Retur();
            $retur->slug = Controller::gen_slug();
            $retur->no_dokumen = $gen_no_dokumen['nomor'];
            $retur->referensi = $request->dokumen;
            if ($request->dokumen == 'suratjalan') {
                $retur->suratjalan_id  = $request->dokumen_id;
            } elseif ($request->dokumen == 'barangkeluar') {
                $retur->barangkeluar_id = $request->dokumen_id;
            }
            $retur->gudang = $request->gudang;
            $retur->tanggal = date('Y-m-d');
            $retur->status = $pengaturan->nilai == 'Tidak' && $request->status == 'Submit' ? 'Approved' : $request->status;
            $retur->catatan = $request->catatan;
            $retur->created_by = Auth::user()->id;
            $retur->save();
            foreach ($request->material_id as $key => $material_id) {
                $detail[] = [
                    'slug' => Controller::gen_slug(),
                    'retur_id' => $retur->id,
                    'material_id' => $material_id,
                    'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : 0,
                    'satuan' => $request->satuan[$key],
                    'keterangan' => $request->keterangan[$key],
                    'created_by' => Auth::user()->id
                ];
            }
            $retur->returdetail()->createMany($detail);
            if ($retur->status == 'Approved') {
                foreach ($retur->returdetail as $d) {
                    Controller::update_stok("Masuk", $kartustok_gudang, "Retur", $retur->id, $d->material_id, $d->jumlah, $d->satuan);
                }
            }
            DB::commit();
            return redirect()->route('retur.index', ['gudang' => $retur->gudang])->with([
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
    public function show(Retur $retur)
    {
        if ($retur->gudang == 'bahan-baku') {
            return view('gudangbahanbaku.retur.show', compact('retur'));
        } elseif ($retur->gudang == 'bahan-penolong') {
            return view('gudangbahanbaku.retur.show', compact('retur'));
        } elseif ($retur->gudang == 'benang') {
            return view('gudangbenang.retur.show', compact('retur'));
        } elseif ($retur->gudang == 'barang-jadi') {
            return view('gudangbarangjadi.retur.show', compact('retur'));
        } elseif ($retur->gudang == 'extruder') {
            return view('gudangextruder.retur.show', compact('retur'));
        } elseif ($retur->gudang == 'wjl') {
            return view('gudangwjl.retur.show', compact('retur'));
        } elseif ($retur->gudang == 'sulzer') {
            return view('gudangsulzer.retur.show', compact('retur'));
        } elseif ($retur->gudang == 'rashel') {
            return view('gudangrashel.retur.show', compact('retur'));
        } elseif ($retur->gudang == 'beaming') {
            return view('gudangbeaming.retur.show', compact('retur'));
        } elseif ($retur->gudang == 'packing') {
            return view('gudangpacking.retur.show', compact('retur'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Retur $retur)
    {
        $satuan = Satuan::all();
        $pengaturan = Pengaturan::where('keterangan', 'gudang.barang-jadi.retur.butuh.approval')->first();
        if ($retur->status == 'Approved') {
            return redirect()->route('retur.index')->with([
                'status' => 'error',
                'message' => 'Status dokumen sudah approved!'
            ]);
        }
        $gudang = $retur->gudang;
        if ($gudang == 'bahan-baku') {
            return view('gudangbahanbaku.retur.edit', compact('retur', 'pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'bahan-penolong') {
            return view('gudangbahanbaku.retur.edit', compact('retur', 'pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'benang') {
            return view('gudangbenang.retur.edit', compact('retur', 'pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'barang-jadi') {
            return view('gudangbarangjadi.retur.edit', compact('retur', 'pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'extruder') {
            return view('gudangextruder.retur.edit', compact('retur', 'pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'wjl') {
            return view('gudangwjl.retur.edit', compact('retur', 'pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'sulzer') {
            return view('gudangsulzer.retur.edit', compact('retur', 'pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'rashel') {
            return view('gudangrashel.retur.edit', compact('retur', 'pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'beaming') {
            return view('gudangbeaming.retur.edit', compact('retur', 'pengaturan', 'gudang', 'satuan'));
        } elseif ($gudang == 'packing') {
            return view('gudangpacking.retur.edit', compact('retur', 'pengaturan', 'gudang', 'satuan'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Retur $retur)
    {
        $validator = Validator::make($request->all(), [
            'dokumen_id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.' . $request->gudang . '.retur.butuh.approval')->first();
            $jenis_gudang = '';
            $kartustok_gudang = '';
            if ($request->gudang == 'barang-jadi') {
                $jenis_gudang = 'barangjadi.retur';
                $kartustok_gudang = 'Gudang Barang Jadi';
            } elseif ($request->gudang == 'bahan-baku') {
                $jenis_gudang = 'bahanbaku.retur';
                $kartustok_gudang = 'Gudang Bahan Baku';
            } elseif ($request->gudang == 'bahan-penolong') {
                $jenis_gudang = 'bahanbaku.retur';
                $kartustok_gudang = 'Gudang Bahan Baku';
            } elseif ($request->gudang == 'extruder') {
                $jenis_gudang = 'extruder.retur';
                $kartustok_gudang = 'Gudang Extruder';
            } elseif ($request->gudang == 'wjl') {
                $jenis_gudang = 'wjl.retur';
                $kartustok_gudang = 'Gudang WJL';
            } elseif ($request->gudang == 'sulzer') {
                $jenis_gudang = 'sulzer.retur';
                $kartustok_gudang = 'Gudang Sulzer';
            } elseif ($request->gudang == 'rashel') {
                $jenis_gudang = 'rashel.retur';
                $kartustok_gudang = 'Gudang Rashel';
            } elseif ($request->gudang == 'beaming') {
                $jenis_gudang = 'beaming.retur';
                $kartustok_gudang = 'Gudang Beaming';
            } elseif ($request->gudang == 'packing') {
                $jenis_gudang = 'packing.retur';
                $kartustok_gudang = 'Gudang Packing';
            }
            $retur->referensi = $request->dokumen;
            if ($request->dokumen == 'suratjalan') {
                $retur->suratjalan_id  = $request->dokumen_id;
            } elseif ($request->dokumen == 'barangkeluar') {
                $retur->barangkeluar_id = $request->dokumen_id;
            }
            $retur->gudang = $request->gudang;
            $retur->tanggal = date('Y-m-d');
            $retur->status = $pengaturan->nilai == 'Tidak' && $request->status == 'Submit' ? 'Approved' : $request->status;
            $retur->catatan = $request->catatan;
            $retur->created_by = Auth::user()->id;
            $retur->save();
            foreach ($request->material_id as $key => $material_id) {
                $detail[] = [
                    'slug' => Controller::gen_slug(),
                    'retur_id' => $retur->id,
                    'material_id' => $material_id,
                    'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : 0,
                    'satuan' => $request->satuan[$key],
                    'keterangan' => $request->keterangan[$key],
                    'created_by' => Auth::user()->id
                ];
            }
            $retur->returdetail()->delete();
            $retur->returdetail()->createMany($detail);
            if ($retur->status == 'Approved') {
                foreach ($retur->returdetail as $d) {
                    Controller::update_stok("Masuk", $kartustok_gudang, "Retur", $retur->id, $d->material_id, $d->jumlah, $d->satuan);
                }
            }
            DB::commit();
            return redirect()->route('retur.index', ['gudang' => $retur->gudang])->with([
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
    public function destroy(Retur $retur)
    {
        DB::beginTransaction();
        try {
            $gudang = $retur->gudang;
            $retur->returdetail()->delete();
            $retur->delete();
            DB::commit();
            return redirect()->route('retur.index', ['gudang' => $gudang])->with([
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

    public function get_barangkeluar(Request $request)
    {
        if ($request->ajax()) {
            $term = trim($request->term);
            $barangkeluar = Barangkeluar::selectRaw("id, no_dokumen as text")
                ->where('no_dokumen', 'like', '%' . $term . '%');
            $barangkeluar = $barangkeluar->where('gudang', '=', $request->gudang);
            $barangkeluar = $barangkeluar->where('status', 'Approved');
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

    public function get_dokumen(Request $request)
    {
        if ($request->ajax()) {
            $term = trim($request->term);
            $dokumen = '';
            if ($request->dokumen == 'suratjalan') {
                $dokumen = Suratjalan::selectRaw("id, no_dokumen as text")
                    // ->where('status', '=', 'Approved')
                    ->where('gudang', '=', $request->gudang)
                    ->where('no_dokumen', 'like', '%' . $term . '%')
                    ->orderBy('no_dokumen')->simplePaginate(10);
            } elseif ($request->dokumen == 'barangkeluar') {
                $dokumen = Barangkeluar::selectRaw("id, no_dokumen as text")
                    // ->where('status', '=', 'Approved')
                    ->where('gudang', '=', $request->gudang)
                    ->where('no_dokumen', 'like', '%' . $term . '%')
                    ->orderBy('no_dokumen')->simplePaginate(10);
            }
            $total_count = count($dokumen);
            $morePages = true;
            $pagination_obj = json_encode($dokumen);
            if (empty($dokumen->nextPageUrl())) {
                $morePages = false;
            }
            $result = [
                "results" => $dokumen->items(),
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


    public function cetak(Retur $retur)
    {
        if ($retur->gudang == 'bahan-baku') {
            $gudang = 'gudangbahanbaku';
        } elseif ($retur->gudang == 'bahan-penolong') {
            $gudang = 'gudangbahanbaku';
        } elseif ($retur->gudang == 'benang') {
            $gudang = 'gudangbenang';
        } elseif ($retur->gudang == 'barang-jadi') {
            $gudang = 'gudangbarangjadi';
        } elseif ($retur->gudang == 'extruder') {
            $gudang = 'gudangextruder';
        } elseif ($retur->gudang == 'wjl') {
            $gudang = 'gudangwjl';
        } elseif ($retur->gudang == 'sulzer') {
            $gudang = 'gudangsulzer';
        } elseif ($retur->gudang == 'rashel') {
            $gudang = 'gudangrashel';
        } elseif ($retur->gudang == 'beaming') {
            $gudang = 'gudangbeaming';
        } elseif ($retur->gudang == 'packing') {
            $gudang = 'gudangpacking';
        }
        $pdf = PDF::loadview($gudang . '.retur.cetak', compact(
            'retur'
        ));
        return $pdf->download('retur-' .  $retur->no_dokumen . '.pdf');
    }
}
