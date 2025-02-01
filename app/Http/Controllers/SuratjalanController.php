<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Order;
use App\Models\Pengaturan;
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

class SuratjalanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $tanggal_dari = request()->tanggal_dari ?? \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
            $tanggal_sampai = request()->tanggal_sampai ?? \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d');
            $suratjalan = Suratjalan::query();
            if (request()->nama_toko != 'null' && request()->nama_toko != '') {
                $suratjalan->where('nama_toko', request()->nama_toko);
            }
            if (request()->status != 'null' && request()->status != '') {
                $suratjalan->where('status', request()->status);
            }
            $suratjalan->whereDate('tanggal', '>=', $tanggal_dari);
            $suratjalan->whereDate('tanggal', '<=', $tanggal_sampai);
            $suratjalan->get();
            return DataTables::of($suratjalan)
                ->addIndexColumn()
                ->addColumn('dibuat_oleh', function ($item) {
                    $user = User::find($item->created_by);
                    return $user ? $user->name : null;
                })
                ->addColumn('disetujui_oleh', function ($item) {
                    $user = User::find($item->approved_by);
                    return $user ? $user->name : null;
                })
                ->addColumn('no_order', function ($item) {
                    $order = Order::find($item->order_id);
                    return $order ? $order->no_order : null;
                })
                ->addColumn('action', function ($item) {
                    if ($item->status == 'Approved') {
                        $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('suratjalan.show', $item->slug) . '")"> <i class="fas fa-search"></i> Detail</a>
                            <a class="dropdown-item" href="' . route('suratjalan.cetak', $item->slug) . '")"> <i class="fas fa-print"></i> Cetak</a>
                        </div>';
                    } else {
                        $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('suratjalan.show', $item->slug) . '")"> <i class="fas fa-search"></i> Detail</a>
                            <a class="dropdown-item" href="' . route('suratjalan.cetak', $item->slug) . '")"> <i class="fas fa-print"></i> Cetak</a>
                            <a class="dropdown-item" href="' . route('suratjalan.edit', $item->slug) . '")"> <i class="fas fa-pencil-alt"></i> Edit</a>
                            <button class="dropdown-item" onClick="hapus(\'' . $item->slug . '\')"><i class="fas fa-trash"></i> Hapus</button>
                        </div>';
                    }
                    return $button;
                })
                ->make();
        }
        return view('gudangbarangjadi.suratjalan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $satuan = Satuan::all();
        $pengaturan = Pengaturan::where('keterangan', 'gudang.barang-jadi.suratjalan.butuh.approval')->first();
        if (request()->order) {
            $order = Order::where('slug', request()->order)->first();
            return view('gudangbarangjadi.suratjalan.create', compact('order', 'pengaturan', 'satuan'));
        }
        return view('gudangbarangjadi.suratjalan.create', compact('pengaturan', 'satuan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.barang-jadi.suratjalan.butuh.approval')->first();
            $gen_no_dokumen = Controller::gen_no_dokumen('suratjalan');
            $suratjalan = new Suratjalan();
            $suratjalan->slug = Controller::gen_slug();
            $suratjalan->order_id = $request->order_id;
            $suratjalan->no_dokumen = $gen_no_dokumen['nomor'];
            $suratjalan->tanggal = date('Y-m-d');
            $suratjalan->nama_toko = $request->nama_toko;
            $suratjalan->nopol = $request->nopol;
            $suratjalan->sopir = $request->sopir;
            $suratjalan->status = $pengaturan->nilai == 'Tidak' && $request->status == 'Submit' ? 'Approved' : $request->status;
            $suratjalan->catatan = $request->catatan;
            $suratjalan->created_by = Auth::user()->id;
            $suratjalan->save();
            foreach ($request->material_id as $key => $material_id) {
                $detail[] = [
                    'slug' => Controller::gen_slug(),
                    'suratjalan_id' => $suratjalan->id,
                    'material_id' => $material_id,
                    'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : 0,
                    'satuan' => $request->satuan[$key],
                    'keterangan' => $request->keterangan[$key],
                    'created_by' => Auth::user()->id
                ];
            }
            $suratjalan->suratjalandetail()->createMany($detail);
            if ($suratjalan->status == 'Approved') {
                foreach ($suratjalan->suratjalandetail as $d) {
                    Controller::update_stok("Keluar", "Gudang Barang Jadi", "Surat Jalan", $suratjalan->id, $d->material_id, $d->jumlah, $d->satuan);
                }
            }
            DB::commit();
            return redirect()->route('suratjalan.index')->with([
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
    public function show(Suratjalan $suratjalan)
    {
        return view('gudangbarangjadi.suratjalan.show', compact('suratjalan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Suratjalan $suratjalan)
    {
        $satuan = Satuan::all();
        $pengaturan = Pengaturan::where('keterangan', 'gudang.barang-jadi.suratjalan.butuh.approval')->first();
        if ($suratjalan->status == 'Approved') {
            return redirect()->route('suratjalan.index')->with([
                'status' => 'error',
                'message' => 'Status dokumen sudah approved!'
            ]);
        }
        return view('gudangbarangjadi.suratjalan.edit', compact('suratjalan', 'pengaturan', 'satuan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Suratjalan $suratjalan)
    {
        DB::beginTransaction();
        try {
            $pengaturan = Pengaturan::where('keterangan', 'gudang.barang-jadi.suratjalan.butuh.approval')->first();
            $suratjalan->order_id = $request->order_id;
            $suratjalan->tanggal = date('Y-m-d');
            $suratjalan->nama_toko = $request->nama_toko;
            $suratjalan->nopol = $request->nopol;
            $suratjalan->sopir = $request->sopir;
            $suratjalan->status = $pengaturan->nilai == 'Tidak' && $request->status == 'Submit' ? 'Approved' : $request->status;
            $suratjalan->catatan = $request->catatan;
            $suratjalan->created_by = Auth::user()->id;
            $suratjalan->save();
            foreach ($request->material_id as $key => $material_id) {
                $detail[] = [
                    'slug' => Controller::gen_slug(),
                    'suratjalan_id' => $suratjalan->id,
                    'material_id' => $material_id,
                    'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : 0,
                    'satuan' => $request->satuan[$key],
                    'keterangan' => $request->keterangan[$key],
                    'created_by' => Auth::user()->id
                ];
            }
            $suratjalan->suratjalandetail()->delete();
            $suratjalan->suratjalandetail()->createMany($detail);
            if ($suratjalan->status == 'Approved') {
                foreach ($suratjalan->suratjalandetail as $d) {
                    Controller::update_stok("Keluar", "Gudang Barang Jadi", "Surat Jalan", $suratjalan->id, $d->material_id, $d->jumlah, $d->satuan);
                }
            }
            DB::commit();
            return redirect()->route('suratjalan.index')->with([
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
    public function destroy(Suratjalan $suratjalan)
    {
        DB::beginTransaction();
        try {
            $suratjalan->suratjalandetail()->delete();
            $suratjalan->delete();
            DB::commit();
            return redirect()->route('suratjalan.index')->with([
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
                ->where('jenis', 'Barang Jadi')
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

    public function get_toko(Request $request)
    {
        if ($request->ajax()) {
            $term = trim($request->term);
            $suratjalan = Suratjalan::selectRaw("nama_toko as id, nama_toko as text")
                ->where('nama_toko', 'like', '%' . $term . '%')
                ->groupBy('nama_toko')
                ->orderBy('nama_toko')
                ->simplePaginate(10);
            $total_count = count($suratjalan);
            $morePages = true;
            $pagination_obj = json_encode($suratjalan);
            if (empty($suratjalan->nextPageUrl())) {
                $morePages = false;
            }
            $result = [
                "results" => $suratjalan->items(),
                "pagination" => [
                    "more" => $morePages
                ],
                "total_count" => $total_count
            ];
            return response()->json($result);
        }
    }

    public function get_order(Request $request)
    {
        if ($request->ajax()) {
            $term = trim($request->term);
            $order = Order::selectRaw("id, no_order as text")
                ->where('no_order', 'like', '%' . $term . '%')
                ->whereIn('status', ['Open', 'On Progress'])
                ->orderBy('no_order')->simplePaginate(10);
            $total_count = count($order);
            $morePages = true;
            $pagination_obj = json_encode($order);
            if (empty($order->nextPageUrl())) {
                $morePages = false;
            }
            $result = [
                "results" => $order->items(),
                "pagination" => [
                    "more" => $morePages
                ],
                "total_count" => $total_count
            ];
            return response()->json($result);
        }
    }

    public function get_order_by_id(Request $request)
    {
        if ($request->ajax()) {
            $order = Order::find($request->id);
            $data = [
                'order' => $order,
            ];
            return response()->json($data);
        }
    }

    public function cetak(Suratjalan $suratjalan)
    {
        $pdf = PDF::loadview('gudangbarangjadi.suratjalan.cetak', compact(
            'suratjalan'
        ));
        return $pdf->download('suratjalan-' .  $suratjalan->no_dokumen . '.pdf');
    }
}
