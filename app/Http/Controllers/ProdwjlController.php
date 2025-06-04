<?php

namespace App\Http\Controllers;

use App\Models\Prodwjl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Symfony\Component\Console\Input\Input;
use Intervention\Image\ImageManager;
use Intervention\Image\Facades\Image;
use Intervention\Image\Drivers\Gd\Driver;

class ProdwjlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $prodwjl = Prodwjl::query();
            return DataTables::of($prodwjl)
                ->addIndexColumn()
                ->addColumn('mesin', function ($item) {
                    $mesin = Mesin::find($item->mesin_id);
                    return $mesin ? $mesin->nama : null;
                })
                ->addColumn('action', function ($item) {
                    if ($item->status == 'Draft') {
                        $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('prodwjl.show', $item->slug) . '")"> <i class="fas fa-eye"></i> Detail</a>
                            <a class="dropdown-item" href="' . route('prodwjl.edit', $item->slug) . '")"> <i class="fas fa-pencil-alt"></i> Edit</a>
                            <button class="dropdown-item" onClick="hapus(\'' . $item->slug . '\')"><i class="fas fa-trash"></i> Hapus</button>
                        </div>';
                    } else {
                        $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('prodwjl.show', $item->slug) . '")"> <i class="fas fa-eye"></i> Detail</a>
                        </div>';
                    }

                    return $button;
                })
                ->make();
        }
        return view('produksibelakang.wjl.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produksibelakang.wjl.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_so' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $prodwjl = new Prodwjl();
            $prodwjl->mesin_id = $request->mesin_id;
            $prodwjl->nomor_so = $request->nomor_so;
            $prodwjl->slug = Str::slug($request->nomor_so . '-' . time());
            $prodwjl->status = 'Draft';
            $prodwjl->shift = $request->shift;
            $prodwjl->operator = $request->operator;
            $prodwjl->tanggal = $request->tanggal;
            $prodwjl->keterangan = $request->keterangan;
            $prodwjl->created_by = Auth::user()->id;
            $prodwjl->save();
            DB::commit();
            return redirect()->route('prodwjl.index')->with([
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
    public function show(Prodwjl $prodwjl)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prodwjl $prodwjl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prodwjl $prodwjl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prodwjl $prodwjl)
    {
        //
    }
}
