<?php

namespace App\Http\Controllers;

use App\Exports\LokasiExport;
use App\Imports\LokasiImport;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $lokasi = Lokasi::query();
            return DataTables::of($lokasi)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('lokasi.edit', $item->slug) . '")"> <i class="fas fa-pencil-alt"></i> Edit</a>
                            <button class="dropdown-item" onClick="hapus(\'' . $item->slug . '\')"><i class="fas fa-trash"></i> Hapus</button>
                        </div>';
                    return $button;
                })
                ->make();
        }
        return view('lokasi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lokasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:lokasis,nama,NULL,id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $lokasi = new Lokasi();
            $lokasi->slug = Controller::gen_slug();
            $lokasi->nama = $request->nama;
            $lokasi->keterangan = $request->keterangan;
            $lokasi->created_by = Auth::user()->id;
            $lokasi->save();
            DB::commit();
            return redirect()->route('lokasi.index')->with([
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
    public function show(Lokasi $lokasi)
    {
        return view('lokasi.edit', compact('lokasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lokasi $lokasi)
    {
        return view('lokasi.edit', compact('lokasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lokasi $lokasi)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:lokasis,nama,' . $lokasi->id . ',id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $lokasi->nama = $request->nama;
            $lokasi->keterangan = $request->keterangan;
            $lokasi->updated_by = Auth::user()->id;
            $lokasi->save();
            DB::commit();
            return redirect()->route('lokasi.index')->with([
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
    public function destroy(Lokasi $lokasi)
    {
        DB::beginTransaction();
        try {
            $lokasi->delete();
            DB::commit();
            return redirect()->route('lokasi.index')->with([
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
            $import = Excel::import(new LokasiImport(), storage_path('app/public/excel/' . $nama_file));
            Storage::delete($path);
            $status = "success";
            $message = "Data berhasil di import!";
            if (!$import) {
                $status = "error";
                $message = "Data gagal di import!";
            }
            return redirect()->route('lokasi.index')->with([
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
        return Excel::download(new LokasiExport(), 'lokasi.xlsx');
    }
}
