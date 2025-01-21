<?php

namespace App\Http\Controllers;

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
            $barangmasuk = Barangmasuk::query();
            $barangmasuk->where('gudang', request()->gudang)->get();
            return DataTables::of($barangmasuk)
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
        if (request()->gudang == 'bahan-baku') {
            return view('gudangbahanbaku.barangmasuk.index');
        } elseif (request()->gudang == 'benang') {
            return view('gudangbenang.barangmasuk.index');
        } elseif (request()->gudang == 'barang-jadi') {
            return view('gudangbarangjadi.barangmasuk.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gudang = request()->gudang;
        if ($gudang == 'bahan-baku') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.bahan-baku.barangmasuk.butuh.approval')->first();
            return view('gudangbahanbaku.barangmasuk.create', compact('pengaturan', 'gudang'));
        } elseif ($gudang == 'benang') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.benang.barangmasuk.butuh.approval')->first();
            return view('gudangbenang.barangmasuk.create', compact('pengaturan', 'gudang'));
        } elseif ($gudang == 'barang-jadi') {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.barang-jadi.barangmasuk.butuh.approval')->first();
            return view('gudangbarangjadi.barangmasuk.create', compact('pengaturan', 'gudang'));
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
            $barangmasuk->referensi = $request->referensi;
            $barangmasuk->referensi_id = $request->referensi_id;
            $barangmasuk->no_dokumen = $gen_no_dokumen['nomor'];
            $barangmasuk->gudang = $request->gudang;
            $barangmasuk->tanggal = date('Y-m-d');
            $barangmasuk->status = $pengaturan->nilai == 'Ya' ? $request->status : 'Approved';
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
                    Controller::update_stok("Keluar", "Gudang Barang Jadi", "Barang Masuk", $barangmasuk->id, $d->material_id, $d->jumlah);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barangmasuk $barangmasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barangmasuk $barangmasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barangmasuk $barangmasuk)
    {
        //
    }
}
