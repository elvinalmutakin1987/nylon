<?php

namespace App\Http\Controllers;

use App\Exports\MesinExport;
use App\Imports\MesinImport;
use App\Models\Lokasi;
use App\Models\Mesin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class MesinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $mesin = Mesin::query();
            return DataTables::of($mesin)
                ->addIndexColumn()
                ->addColumn('lokasi', function ($item) {
                    $lokasi = Lokasi::find($item->lokasi_id);
                    return $lokasi ? $lokasi->nama : null;
                })
                ->addColumn('action', function ($item) {
                    $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('mesin.edit', $item->slug) . '")"> <i class="fas fa-pencil-alt"></i> Edit</a>
                            <button class="dropdown-item" onClick="hapus(\'' . $item->slug . '\')"><i class="fas fa-trash"></i> Hapus</button>
                        </div>';
                    return $button;
                })
                ->make();
        }
        return view('mesin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mesin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:mesins,nama,NULL,id,deleted_at,NULL',
            // 'lokasi_id' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $mesin = new Mesin();
            $mesin->slug = Controller::gen_slug();
            $mesin->nama = $request->nama;
            $mesin->bagian = $request->bagian;
            $mesin->lokasi_id = $request->lokasi_id;
            $mesin->target_produksi = Controller::unformat_angka($request->target_produksi);
            $mesin->keterangan = $request->keterangan;
            $mesin->b_plus_top = $mesin->b_plus_top ? Controller::unformat_angka($request->b_plus_top) : '0';
            $mesin->b_plus_bottom = $mesin->b_plus_top ? Controller::unformat_angka($request->b_plus_bottom) : '0';
            $mesin->b_top =  $mesin->b_plus_top ? Controller::unformat_angka($request->b_top) : '0';
            $mesin->b_bottom = $mesin->b_plus_top ? Controller::unformat_angka($request->b_bottom) : '0';
            $mesin->n_top = $mesin->b_plus_top ? Controller::unformat_angka($request->n_top) : '0';
            $mesin->n_bottom = $mesin->b_plus_top ? Controller::unformat_angka($request->n_bottom) : '0';
            $mesin->k_top = $mesin->b_plus_top ? Controller::unformat_angka($request->k_top) : '0';
            $mesin->k_bottom = $mesin->b_plus_top ? Controller::unformat_angka($request->k_bottom) : '0';
            $mesin->k_min_top = $mesin->b_plus_top ? Controller::unformat_angka($request->k_min_top) : '0';
            $mesin->k_min_bottom = $mesin->b_plus_top ? Controller::unformat_angka($request->k_min_bottom) : '0';
            $mesin->created_by = Auth::user()->id;
            $mesin->save();
            DB::commit();
            return redirect()->route('mesin.index')->with([
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
    public function show(Mesin $mesin)
    {
        return view('mesin.edit', compact('mesin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mesin $mesin)
    {
        return view('mesin.edit', compact('mesin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mesin $mesin)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:mesins,nama,' . $mesin->id . ',id,deleted_at,NULL',
            // 'lokasi_id' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $mesin->nama = $request->nama;
            $mesin->lokasi_id = $request->lokasi_id;
            $mesin->bagian = $request->bagian;
            $mesin->target_produksi = Controller::unformat_angka($request->target_produksi);
            $mesin->keterangan = $request->keterangan;
            $mesin->b_plus_top = $mesin->b_plus_top ? Controller::unformat_angka($request->b_plus_top) : '0';
            $mesin->b_plus_bottom = $mesin->b_plus_top ? Controller::unformat_angka($request->b_plus_bottom) : '0';
            $mesin->b_top =  $mesin->b_plus_top ? Controller::unformat_angka($request->b_top) : '0';
            $mesin->b_bottom = $mesin->b_plus_top ? Controller::unformat_angka($request->b_bottom) : '0';
            $mesin->n_top = $mesin->b_plus_top ? Controller::unformat_angka($request->n_top) : '0';
            $mesin->n_bottom = $mesin->b_plus_top ? Controller::unformat_angka($request->n_bottom) : '0';
            $mesin->k_top = $mesin->b_plus_top ? Controller::unformat_angka($request->k_top) : '0';
            $mesin->k_bottom = $mesin->b_plus_top ? Controller::unformat_angka($request->k_bottom) : '0';
            $mesin->k_min_top = $mesin->b_plus_top ? Controller::unformat_angka($request->k_min_top) : '0';
            $mesin->k_min_bottom = $mesin->b_plus_top ? Controller::unformat_angka($request->k_min_bottom) : '0';
            $mesin->created_by = Auth::user()->id;
            $mesin->save();
            DB::commit();
            return redirect()->route('mesin.index')->with([
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
    public function destroy(Mesin $mesin)
    {
        DB::beginTransaction();
        try {
            $mesin->delete();
            DB::commit();
            return redirect()->route('mesin.index')->with([
                'status' => 'success',
                'message' => 'Data telah dihapus!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('error', compact('th'));
        }
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_import' => 'required|mimes:csv,xls,xlsx'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        try {
            $file = $request->file('file_import');
            $nama_file = $file->hashName();
            $path = $file->storeAs('excel', $nama_file);
            $import = Excel::import(new MesinImport(), storage_path('app/public/excel/' . $nama_file));
            Storage::delete($path);
            $status = "success";
            $message = "Data berhasil di import!";
            if (!$import) {
                $status = "error";
                $message = "Data gagal di import!";
            }
            return redirect()->route('mesin.index')->with([
                'status' => $status,
                'message' => $message
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('error', compact('th'));
        }
    }

    public function export(Request $request)
    {
        return Excel::download(new MesinExport(), 'mesin.xlsx');
    }

    public function get_lokasi(Request $request)
    {
        if ($request->ajax()) {
            $term = trim($request->term);
            $lokasi = Lokasi::selectRaw("id, nama as text")
                ->where('nama', 'like', '%' . $term . '%')
                ->orderBy('nama')->simplePaginate(10);
            $total_count = count($lokasi);
            $morePages = true;
            $pagination_obj = json_encode($lokasi);
            if (empty($lokasi->nextPageUrl())) {
                $morePages = false;
            }
            $result = [
                "results" => $lokasi->items(),
                "pagination" => [
                    "more" => $morePages
                ],
                "total_count" => $total_count
            ];
            return response()->json($result);
        }
    }
}
