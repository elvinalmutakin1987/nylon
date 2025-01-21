<?php

namespace App\Http\Controllers;

use App\Exports\VarianExport;
use App\Imports\VarianImport;
use App\Models\Varian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class VarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $varian = Varian::query();
            return DataTables::of($varian)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('varian.edit', $item->slug) . '")"> <i class="fas fa-pencil-alt"></i> Edit</a>
                            <button class="dropdown-item" onClick="hapus(\'' . $item->slug . '\')"><i class="fas fa-trash"></i> Hapus</button>
                        </div>';
                    return $button;
                })
                ->make();
        }
        return view('varian.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('varian.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:varians,nama,NULL,id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $varian = new Varian();
            $varian->slug = Controller::gen_slug();
            $varian->nama = $request->nama;
            $varian->keterangan = $request->keterangan;
            $varian->created_by = Auth::user()->id;
            $varian->save();
            DB::commit();
            return redirect()->route('varian.index')->with([
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
    public function show(Varian $varian)
    {
        return view('varian.edit', compact('varian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Varian $varian)
    {
        return view('varian.edit', compact('varian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Varian $varian)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:varians,nama,' . $varian->id . ',id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $varian->nama = $request->nama;
            $varian->keterangan = $request->keterangan;
            $varian->created_by = Auth::user()->id;
            $varian->save();
            DB::commit();
            return redirect()->route('varian.index')->with([
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
    public function destroy(Varian $varian)
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
            $import = Excel::import(new VarianImport(), storage_path('app/public/excel/' . $nama_file));
            Storage::delete($path);
            $status = "success";
            $message = "Data berhasil di import!";
            if (!$import) {
                $status = "error";
                $message = "Data gagal di import!";
            }
            return redirect()->route('varian.index')->with([
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
        return Excel::download(new VarianExport(), 'varian.xlsx');
    }
}
