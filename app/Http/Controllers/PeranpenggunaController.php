<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Varian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class PeranpenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $role = Role::query();
            $role = $role->whereNot('name', 'superadmin')->get();
            return DataTables::of($role)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('peranpengguna.edit', $item->id) . '")"> <i class="fas fa-pencil-alt"></i> Edit</a>
                            <button class="dropdown-item" onClick="hapus(\'' . $item->id . '\')"><i class="fas fa-trash"></i> Hapus</button>
                        </div>';
                    return $button;
                })
                ->make();
        }
        return view('peranpengguna.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('peranpengguna.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:roles,name,NULL,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $role = new Role();
            $role->name = $request->nama;
            $role->save();
            $access = array();
            if ($request->order) array_push($access, 'order');

            if ($request->gudang_barangjadi_order) array_push($access, 'gudang.barangjadi.order');
            if ($request->gudang_barangjadi_cekstok) array_push($access, 'gudang.barangjadi.cekstok');
            if ($request->gudang_barangjadi_suratjalan) array_push($access, 'gudang.barangjadi.suratjalan');
            if ($request->gudang_barangjadi_barangkeluar) array_push($access, 'gudang.barangjadi.barangkeluar');
            if ($request->gudang_barangjadi_barangmasuk) array_push($access, 'gudang.barangjadi.barangmasuk');
            if ($request->gudang_barangjadi_retur) array_push($access, 'gudang.barangjadi.retur');
            if ($request->gudang_bahanbaku_cekstok) array_push($access, 'gudang.bahanbaku.cekstok');
            if ($request->gudang_bahanbaku_barangkeluar) array_push($access, 'gudang.bahanbaku.barangkeluar');
            if ($request->gudang_bahanbaku_barangmasuk) array_push($access, 'gudang.bahanbaku.barangmasuk');
            if ($request->gudang_bahanbaku_retur) array_push($access, 'gudang.bahanbaku.retur');
            if (
                $request->gudang_barangjadi_order ||
                $request->gudang_barangjadi_cekstok ||
                $request->gudang_barangjadi_suratjalan ||
                $request->gudang_barangjadi_barangkeluar ||
                $request->gudang_barangjadi_barangmasuk ||
                $request->gudang_barangjadi_retur ||
                $request->gudang_bahanbaku_cekstok ||
                $request->gudang_bahanbaku_barangkeluar ||
                $request->gudang_bahanbaku_barangmasuk ||
                $request->gudang_bahanbaku_retur
            ) {
                array_push($access, 'gudang');
            }

            if ($request->gudang_benang_cekstok) array_push($access, 'gudang.benang.cekstok');
            if ($request->gudang_benang_barangkeluar) array_push($access, 'gudang.benang.barangkeluar');
            if ($request->gudang_benang_barangmasuk) array_push($access, 'gudang.benang.barangmasuk');
            if ($request->gudang_benang_retur) array_push($access, 'gudang.benang.retur');
            if ($request->gudang_benang_retur) array_push($access, 'gudang.benang.retur');
            if ($request->produksi_wjl_operator) array_push($access, 'produksi.wjl.operator');
            if ($request->produksi_wjl_kepalaregu) array_push($access, 'produksi.wjl.kepalaregu');
            if ($request->produksi_wjl_rekap) array_push($access, 'produksi.wjl.rekap');
            if ($request->produksi_wjl_edit) array_push($access, 'produksi.wjl.edit');
            if ($request->produksi_extruder_kontroldenier) array_push($access, 'produksi.extruder.kontrol-denier');
            if ($request->produksi_extruder_kontrolbarmag) array_push($access, 'produksi.extruder.kontrol-barmag');
            if (
                $request->gudang_benang_cekstok ||
                $request->gudang_benang_barangkeluar ||
                $request->gudang_benang_barangmasuk ||
                $request->gudang_benang_retur ||
                $request->produksi_wjl_operator ||
                $request->produksi_wjl_kepalaregu ||
                $request->produksi_wjl_rekap ||
                $request->produksi_wjl_edit ||
                $request->produksi_extruder_kontroldenier ||
                $request->produksi_extruder_kontrolbarmag
            ) {
                array_push($access, 'produksi');
            }
            $role->givePermissionTo($access);
            DB::commit();
            return redirect()->route('peranpengguna.index')->with([
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
    public function show(string $id)
    {
        $role = Role::find($id);
        return view('peranpengguna.edit', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::find($id);
        return view('peranpengguna.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::find($id);
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:roles,name,' . $role->id . ',id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {

            $role = Role::find($id);
            $role->name = $request->nama;
            $role->save();
            $access = array();
            if ($request->order) array_push($access, 'order');

            if ($request->gudang_barangjadi_order) array_push($access, 'gudang.barangjadi.order');
            if ($request->gudang_barangjadi_cekstok) array_push($access, 'gudang.barangjadi.cekstok');
            if ($request->gudang_barangjadi_suratjalan) array_push($access, 'gudang.barangjadi.suratjalan');
            if ($request->gudang_barangjadi_barangkeluar) array_push($access, 'gudang.barangjadi.barangkeluar');
            if ($request->gudang_barangjadi_barangmasuk) array_push($access, 'gudang.barangjadi.barangmasuk');
            if ($request->gudang_barangjadi_retur) array_push($access, 'gudang.barangjadi.retur');
            if ($request->gudang_bahanbaku_cekstok) array_push($access, 'gudang.bahanbaku.cekstok');
            if ($request->gudang_bahanbaku_barangkeluar) array_push($access, 'gudang.bahanbaku.barangkeluar');
            if ($request->gudang_bahanbaku_barangmasuk) array_push($access, 'gudang.bahanbaku.barangmasuk');
            if ($request->gudang_bahanbaku_retur) array_push($access, 'gudang.bahanbaku.retur');
            if (
                $request->gudang_barangjadi_order ||
                $request->gudang_barangjadi_cekstok ||
                $request->gudang_barangjadi_suratjalan ||
                $request->gudang_barangjadi_barangkeluar ||
                $request->gudang_barangjadi_barangmasuk ||
                $request->gudang_barangjadi_retur ||
                $request->gudang_bahanbaku_cekstok ||
                $request->gudang_bahanbaku_barangkeluar ||
                $request->gudang_bahanbaku_barangmasuk ||
                $request->gudang_bahanbaku_retur
            ) {
                array_push($access, 'gudang');
            }

            if ($request->gudang_benang_cekstok) array_push($access, 'gudang.benang.cekstok');
            if ($request->gudang_benang_barangkeluar) array_push($access, 'gudang.benang.barangkeluar');
            if ($request->gudang_benang_barangmasuk) array_push($access, 'gudang.benang.barangmasuk');
            if ($request->gudang_benang_retur) array_push($access, 'gudang.benang.retur');
            if ($request->gudang_benang_retur) array_push($access, 'gudang.benang.retur');
            if ($request->produksi_wjl_operator) array_push($access, 'produksi.wjl.operator');
            if ($request->produksi_wjl_kepalaregu) array_push($access, 'produksi.wjl.kepalaregu');
            if ($request->produksi_wjl_rekap) array_push($access, 'produksi.wjl.rekap');
            if ($request->produksi_wjl_edit) array_push($access, 'produksi.wjl.edit');
            if ($request->produksi_extruder_kontroldenier) array_push($access, 'produksi.extruder.kontrol-denier');
            if ($request->produksi_extruder_kontrolbarmag) array_push($access, 'produksi.extruder.kontrol-barmag');
            if (
                $request->gudang_benang_cekstok ||
                $request->gudang_benang_barangkeluar ||
                $request->gudang_benang_barangmasuk ||
                $request->gudang_benang_retur ||
                $request->produksi_wjl_operator ||
                $request->produksi_wjl_kepalaregu ||
                $request->produksi_wjl_rekap ||
                $request->produksi_wjl_edit ||
                $request->produksi_extruder_kontroldenier ||
                $request->produksi_extruder_kontrolbarmag
            ) {
                array_push($access, 'produksi');
            }
            $role->syncPermissions($access);
            DB::commit();
            return redirect()->route('peranpengguna.index')->with([
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
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $role = Role::find($id);
            $role->syncPermissions();
            $role->delete();
            DB::commit();
            return redirect()->route('peranpengguna.index')->with([
                'status' => 'success',
                'message' => 'Data telah dihapus!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('error', compact('th'));
        }
    }
}
