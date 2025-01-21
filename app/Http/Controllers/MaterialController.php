<?php

namespace App\Http\Controllers;

use App\Exports\MaterialExport;
use App\Imports\MaterialImport;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $material = Material::query();
            return DataTables::of($material)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('material.edit', $item->slug) . '")"> <i class="fas fa-pencil-alt"></i> Edit</a>
                            <button class="dropdown-item" onClick="hapus(\'' . $item->slug . '\')"><i class="fas fa-trash"></i> Hapus</button>
                        </div>';
                    return $button;
                })
                ->make();
        }
        return view('material.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('material.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:materials,nama,NULL,id,deleted_at,NULL',
            'kode' => 'required|unique:materials,kode,NULL,id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $material = new Material();
            $material->slug = Controller::gen_slug();
            $material->kode = $request->kode;
            $material->nama = $request->nama;
            $material->jenis = $request->jenis;
            $material->group = $request->group;
            $material->created_by = Auth::user()->id;
            $material->save();
            DB::commit();
            return redirect()->route('material.index')->with([
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
    public function show(Material $material)
    {
        return view('material.edit', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Material $material)
    {
        return view('material.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Material $material)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:materials,nama,' . $material->id . ',id,deleted_at,NULL',
            'kode' => 'required|unique:materials,kode,' . $material->id . ',id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $material->kode = $request->kode;
            $material->nama = $request->nama;
            $material->jenis = $request->jenis;
            $material->group = $request->group;
            $material->created_by = Auth::user()->id;
            $material->save();
            DB::commit();
            return redirect()->route('material.index')->with([
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
    public function destroy(Material $material)
    {
        DB::beginTransaction();
        try {
            $material->delete();
            DB::commit();
            return redirect()->route('material.index')->with([
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
            $import = Excel::import(new MaterialImport(), storage_path('app/public/excel/' . $nama_file));
            Storage::delete($path);
            $status = "success";
            $message = "Data berhasil di import!";
            if (!$import) {
                $status = "error";
                $message = "Data gagal di import!";
            }
            return redirect()->route('material.index')->with([
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
        return Excel::download(new MaterialExport(), 'material.xlsx');
    }
}
