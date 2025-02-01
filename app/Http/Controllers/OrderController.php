<?php

namespace App\Http\Controllers;

use App\Models\Histori;
use App\Models\Material;
use App\Models\Order;
use App\Models\Ordercatatan;
use App\Models\Orderdetail;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $order = Order::query();
            if (request()->status != 'null' && request()->status != '') {
                $order->where('status', request()->status);
            }
            return DataTables::of($order)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('order.show', $item->slug) . '")"> <i class="fas fa-search"></i> Detail</a>
                            <a class="dropdown-item" href="' . route('order.edit', $item->slug) . '")"> <i class="fas fa-pencil-alt"></i> Edit</a>
                            <button class="dropdown-item" onClick="hapus(\'' . $item->slug . '\')"><i class="fas fa-trash"></i> Hapus</button>
                        </div>';
                    return $button;
                })
                ->make();
        }
        return view('order.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $satuan = Satuan::all();
        return view('order.create', compact('satuan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_order' => 'required|unique:orders,no_order,NULL,id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $order = new Order();
            $order->slug = Controller::gen_slug();
            $order->no_order = $request->no_order;
            $order->nama_pemesan = $request->nama_pemesan;
            $order->tanggal = $request->tanggal;
            $order->kode = $request->kode;
            $order->jenis_barang = $request->jenis_barang;
            $order->keterangan = $request->keterangan;
            $order->tanggal_kirim = $request->tanggal_kirim;
            $order->status = "Open";
            $order->created_by = Auth::user()->id;
            $order->save();
            foreach ($request->material_id as $key => $material_id) {
                $detail[] = [
                    'slug' => Controller::gen_slug(),
                    'order_id' => $order->id,
                    'material_id' => $material_id,
                    'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : 0,
                    'satuan' => $request->satuan[$key],
                    'keterangan' => $request->keterangan_[$key],
                    'created_by' => Auth::user()->id
                ];
            }
            $order->orderdetail()->createMany($detail);
            Controller::simpan_histori("Order", $order->id, Auth::user()->name . " menyimpan data order.");
            DB::commit();
            return redirect()->route('order.index')->with([
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
    public function show(Order $order)
    {
        $histori = Histori::where('dokumen', 'Order')->where('dokumen_id', $order->id)->get();
        return view('order.show', compact('order', 'histori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $satuan = Satuan::all();
        $histori = Histori::where('dokumen', 'Order')->where('dokumen_id', $order->id)->get();
        return view('order.edit', compact('order', 'histori', 'satuan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'no_order' => 'required|unique:orders,no_order,' . $order->id . ',id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $order->no_order = $request->no_order;
            $order->nama_pemesan = $request->nama_pemesan;
            $order->tanggal = $request->tanggal;
            $order->kode = $request->kode;
            $order->jenis_barang = $request->jenis_barang;
            $order->status = $request->status;
            $order->created_by = Auth::user()->id;
            $order->save();
            foreach ($request->material_id as $key => $material_id) {
                $detail[] = [
                    'slug' => Controller::gen_slug(),
                    'order_id' => $order->id,
                    'material_id' => $material_id,
                    'jumlah' => $request->jumlah[$key] ? Controller::unformat_angka($request->jumlah[$key]) : 0,
                    'satuan' => $request->satuan[$key],
                    'keterangan' => $request->keterangan_[$key],
                    'created_by' => Auth::user()->id
                ];
            }
            $order->orderdetail()->delete();
            $order->orderdetail()->createMany($detail);
            Controller::simpan_histori("Order", $order->id, Auth::user()->name . " mengubah data order.");
            DB::commit();
            return redirect()->route('order.index')->with([
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
    public function destroy(Order $order)
    {
        DB::beginTransaction();
        try {
            $order->delete();
            DB::commit();
            return redirect()->route('order.index')->with([
                'status' => 'success',
                'message' => 'Data telah dihapus!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('error', compact('th'));
        }
    }

    public function store_progress(Request $request, Order $order)
    {
        DB::beginTransaction();
        try {
            $ordercatatan = new Ordercatatan();
            $ordercatatan->slug = Controller::gen_slug();
            $ordercatatan->order_id = $order->id;
            $ordercatatan->catatan = $request->catatan;
            $ordercatatan->created_by = Auth::user()->id;
            $ordercatatan->save();
            DB::commit();
            $view = view('order.list-progress', compact('order'))->render();
            return response()->json([
                'status' => 'success',
                'data' => $view,
                'message' => 'success'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }

    public function destroy_progress(Request $request, Order $order) {}

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
}
