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
            if ($request->gudang_avalan_cekstok) array_push($access, 'gudang.avalan.cekstok');
            if ($request->gudang_avalan_barangkeluar) array_push($access, 'gudang.avalan.barangkeluar');
            if ($request->gudang_avalan_barangmasuk) array_push($access, 'gudang.avalan.barangmasuk');
            if ($request->gudang_avalan_retur) array_push($access, 'gudang.avalan.retur');
            if ($request->gudang_packing_cekstok) array_push($access, 'gudang.packing.cekstok');
            if ($request->gudang_packing_barangkeluar) array_push($access, 'gudang.packing.barangkeluar');
            if ($request->gudang_packing_barangmasuk) array_push($access, 'gudang.packing.barangmasuk');
            if ($request->gudang_packing_retur) array_push($access, 'gudang.packing.retur');
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
                $request->gudang_bahanbaku_retur ||
                $request->gudang_avalan_cekstok ||
                $request->gudang_avalan_barangkeluar ||
                $request->gudang_avalan_barangmasuk ||
                $request->gudang_avalan_retur ||
                $request->gudang_packing_cekstok ||
                $request->gudang_packing_barangkeluar ||
                $request->gudang_packing_barangmasuk ||
                $request->gudang_packing_retur
            ) {
                array_push($access, 'gudang');
            }

            if ($request->gudang_benang_cekstok) array_push($access, 'gudang.benang.cekstok');
            if ($request->gudang_benang_barangkeluar) array_push($access, 'gudang.benang.barangkeluar');
            if ($request->gudang_benang_barangmasuk) array_push($access, 'gudang.benang.barangmasuk');
            if ($request->gudang_benang_retur) array_push($access, 'gudang.benang.retur');
            if ($request->gudang_benang_retur) array_push($access, 'gudang.benang.retur');
            if ($request->produksi_wjl) array_push($access, 'produksi.wjl');
            if ($request->produksi_wjl_operator) array_push($access, 'produksi.wjl.operator');
            if ($request->produksi_wjl_kepalaregu) array_push($access, 'produksi.wjl.kepalaregu');
            if ($request->produksi_wjl_rekap) array_push($access, 'produksi.wjl.rekap');
            if ($request->produksi_wjl_edit) array_push($access, 'produksi.wjl.edit');
            if ($request->produksi_wjl_panen) array_push($access, 'produksi.wjl.panen');
            if ($request->produksi_extruder_kontroldenier) array_push($access, 'produksi.extruder.kontrol-denier');
            if ($request->produksi_extruder_kontrolbarmag) array_push($access, 'produksi.extruder.kontrol-barmag');
            if ($request->produksi_extruder_kontrolreifen) array_push($access, 'produksi.extruder.kontrol-reifen');
            if ($request->produksi_extruder_laporansulzer) array_push($access, 'produksi.extruder.laporansulzer');
            if ($request->produksi_extruder_laporanrashel) array_push($access, 'produksi.extruder.laporanrashel');
            if ($request->produksi_extruder_laporanbeaming) array_push($access, 'produksi.extruder.laporanbeaming');
            if ($request->produksi_extruder_checklistbeaming) array_push($access, 'produksi.extruder.checklistbeaming');
            if ($request->produksi_extruder_beamatasmesin) array_push($access, 'produksi.extruder.beamatasmesin');
            if ($request->produksi_extruder_beambawahmesin) array_push($access, 'produksi.extruder.beambawahmesin');
            if ($request->produksi_extruder_stockbeaming) array_push($access, 'produksi.extruder.stockbeaming');
            if ($request->produksi_laminating) array_push($access, 'produksi.laminating');
            if ($request->produksi_laminating_pengeringankain) array_push($access, 'produksi.laminating.pengeringankain');
            if ($request->produksi_laminating_rekap) array_push($access, 'produksi.laminating.rekap');
            if ($request->produksi_laminating_edit) array_push($access, 'produksi.laminating.edit');
            if ($request->produksi_laminating_edit_kering) array_push($access, 'produksi.laminating.edit.kering');
            if ($request->produksi_laminating_panen) array_push($access, 'produksi.laminating.panen');
            if ($request->produksi_welding) array_push($access, 'produksi.welding');
            if ($request->produksi_welding_edit) array_push($access, 'produksi.welding.edit');
            if ($request->produksi_welding_panen) array_push($access, 'produksi.welding.panen');
            if ($request->produksi_welding_laporan) array_push($access, 'produksi.welding.laporan');
            if ($request->produksi_welding_laporan_edit) array_push($access, 'produksi.welding.laporan.edit');
            if ($request->produksi_welding_rekap) array_push($access, 'produksi.welding.rekap');
            if ($request->produksi_tarik) array_push($access, 'produksi.tarik');
            if ($request->produksi_tarik_edit) array_push($access, 'produksi.tarik.edit');
            if ($request->produksi_tarik_panen) array_push($access, 'produksi.tarik.panen');
            if ($request->produksi_tarik_laporan) array_push($access, 'produksi.tarik.laporan');
            if ($request->produksi_tarik_laporan_edit) array_push($access, 'produksi.tarik.laporan.edit');
            if ($request->produksi_tarik_rekap) array_push($access, 'produksi.tarik.rekap');
            if (
                $request->gudang_benang_cekstok ||
                $request->gudang_benang_barangkeluar ||
                $request->gudang_benang_barangmasuk ||
                $request->gudang_benang_retur ||
                $request->produksi_wjl ||
                $request->produksi_wjl_operator ||
                $request->produksi_wjl_kepalaregu ||
                $request->produksi_wjl_rekap ||
                $request->produksi_wjl_edit ||
                $request->produksi_wjl_panen ||
                $request->produksi_extruder_kontroldenier ||
                $request->produksi_extruder_kontrolbarmag ||
                $request->produksi_extruder_kontrolreifen ||
                $request->produksi_extruder_laporansulzer ||
                $request->produksi_extruder_laporanrashel ||
                $request->produksi_extruder_laporanbeaming ||
                $request->produksi_extruder_checklistbeaming ||
                $request->produksi_extruder_beamatasmesin ||
                $request->produksi_extruder_beambawahmesin ||
                $request->produksi_extruder_stockbeaming ||
                $request->produksi_laminating ||
                $request->produksi_laminating_pengeringankain ||
                $request->produksi_laminating_rekap ||
                $request->produksi_laminating_edit ||
                $request->produksi_laminating_edit_kering ||
                $request->produksi_laminating_pengeringankain ||
                $request->produksi_laminating_panen ||
                $request->produksi_welding ||
                $request->produksi_welding_edit ||
                $request->produksi_welding_panen ||
                $request->produksi_welding_laporan ||
                $request->produksi_welding_laporan_edit ||
                $request->produksi_welding_rekap ||
                $request->produksi_tarik ||
                $request->produksi_tarik_edit ||
                $request->produksi_tarik_panen ||
                $request->produksi_tarik_laporan ||
                $request->produksi_tarik_laporan_edit ||
                $request->produksi_tarik_rekap
            ) {
                array_push($access, 'produksi');
            }
            if ($request->laporan_gudang) array_push($access, 'laporan.gudang');
            if ($request->laporan_wjl_efisiensi) array_push($access, 'laporan.wjl.efisiensi');
            if (
                $request->laporan_gudang ||
                $request->laporan_wjl_efisiensi
            ) {
                array_push($access, 'laporan');
            }
            if ($request->material) array_push($access, 'material');
            if ($request->mesin) array_push($access, 'mesin');
            if ($request->lokasi) array_push($access, 'lokasi');
            if (
                $request->material ||
                $request->mesin ||
                $request->lokasi
            ) {
                array_push($access, 'masterdata');
            }
            if ($request->peranpengguna) array_push($access, 'peranpengguna');
            if ($request->pengguna) array_push($access, 'pengguna');
            if ($request->approval) array_push($access, 'approval');
            if (
                $request->peranpengguna ||
                $request->pengguna ||
                $request->approval
            ) {
                array_push($access, 'pengaturan');
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
            if ($request->gudang_avalan_cekstok) array_push($access, 'gudang.avalan.cekstok');
            if ($request->gudang_avalan_barangkeluar) array_push($access, 'gudang.avalan.barangkeluar');
            if ($request->gudang_avalan_barangmasuk) array_push($access, 'gudang.avalan.barangmasuk');
            if ($request->gudang_avalan_retur) array_push($access, 'gudang.avalan.retur');
            if ($request->gudang_packing_cekstok) array_push($access, 'gudang.packing.cekstok');
            if ($request->gudang_packing_barangkeluar) array_push($access, 'gudang.packing.barangkeluar');
            if ($request->gudang_packing_barangmasuk) array_push($access, 'gudang.packing.barangmasuk');
            if ($request->gudang_packing_retur) array_push($access, 'gudang.packing.retur');
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
                $request->gudang_bahanbaku_retur ||
                $request->gudang_avalan_cekstok ||
                $request->gudang_avalan_barangkeluar ||
                $request->gudang_avalan_barangmasuk ||
                $request->gudang_avalan_retur ||
                $request->gudang_packing_cekstok ||
                $request->gudang_packing_barangkeluar ||
                $request->gudang_packing_barangmasuk ||
                $request->gudang_packing_retur
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
            if ($request->produksi_wjl_panen) array_push($access, 'produksi.wjl.panen');
            if ($request->produksi_wjl) array_push($access, 'produksi.wjl');
            if ($request->produksi_extruder_kontroldenier) array_push($access, 'produksi.extruder.kontrol-denier');
            if ($request->produksi_extruder_kontrolbarmag) array_push($access, 'produksi.extruder.kontrol-barmag');
            if ($request->produksi_extruder_kontrolreifen) array_push($access, 'produksi.extruder.kontrol-reifen');
            if ($request->produksi_extruder_laporansulzer) array_push($access, 'produksi.extruder.laporansulzer');
            if ($request->produksi_extruder_laporanrashel) array_push($access, 'produksi.extruder.laporanrashel');
            if ($request->produksi_extruder_laporanbeaming) array_push($access, 'produksi.extruder.laporanbeaming');
            if ($request->produksi_extruder_checklistbeaming) array_push($access, 'produksi.extruder.checklistbeaming');
            if ($request->produksi_extruder_beamatasmesin) array_push($access, 'produksi.extruder.beamatasmesin');
            if ($request->produksi_extruder_beambawahmesin) array_push($access, 'produksi.extruder.beambawahmesin');
            if ($request->produksi_extruder_stockbeaming) array_push($access, 'produksi.extruder.stockbeaming');
            if ($request->produksi_laminating) array_push($access, 'produksi.laminating');
            if ($request->produksi_laminating_pengeringankain) array_push($access, 'produksi.laminating.pengeringankain');
            if ($request->produksi_laminating_rekap) array_push($access, 'produksi.laminating.rekap');
            if ($request->produksi_laminating_edit) array_push($access, 'produksi.laminating.edit');
            if ($request->produksi_laminating_edit_kering) array_push($access, 'produksi.laminating.edit.kering');
            if ($request->produksi_laminating_panen) array_push($access, 'produksi.laminating.panen');
            if ($request->produksi_welding) array_push($access, 'produksi.welding');
            if ($request->produksi_welding_edit) array_push($access, 'produksi.welding.edit');
            if ($request->produksi_welding_panen) array_push($access, 'produksi.welding.panen');
            if ($request->produksi_welding_laporan) array_push($access, 'produksi.welding.laporan');
            if ($request->produksi_welding_laporan_edit) array_push($access, 'produksi.welding.laporan.edit');
            if ($request->produksi_welding_rekap) array_push($access, 'produksi.welding.rekap');
            if ($request->produksi_tarik) array_push($access, 'produksi.tarik');
            if ($request->produksi_tarik_edit) array_push($access, 'produksi.tarik.edit');
            if ($request->produksi_tarik_panen) array_push($access, 'produksi.tarik.panen');
            if ($request->produksi_tarik_laporan) array_push($access, 'produksi.tarik.laporan');
            if ($request->produksi_tarik_laporan_edit) array_push($access, 'produksi.tarik.laporan.edit');
            if ($request->produksi_tarik_rekap) array_push($access, 'produksi.tarik.rekap');
            if (
                $request->gudang_benang_cekstok ||
                $request->gudang_benang_barangkeluar ||
                $request->gudang_benang_barangmasuk ||
                $request->gudang_benang_retur ||
                $request->produksi_wjl ||
                $request->produksi_wjl_operator ||
                $request->produksi_wjl_kepalaregu ||
                $request->produksi_wjl_rekap ||
                $request->produksi_wjl_edit ||
                $request->produksi_wjl_panen ||
                $request->produksi_extruder_kontroldenier ||
                $request->produksi_extruder_kontrolbarmag ||
                $request->produksi_extruder_kontrolreifen ||
                $request->produksi_extruder_laporansulzer ||
                $request->produksi_extruder_laporanrashel ||
                $request->produksi_extruder_laporanbeaming ||
                $request->produksi_extruder_checklistbeaming ||
                $request->produksi_extruder_beamatasmesin ||
                $request->produksi_extruder_beambawahmesin ||
                $request->produksi_extruder_stockbeaming ||
                $request->produksi_laminating ||
                $request->produksi_laminating_pengeringankain ||
                $request->produksi_laminating_rekap ||
                $request->produksi_laminating_edit ||
                $request->produksi_laminating_edit_kering ||
                $request->produksi_laminating_panen ||
                $request->produksi_welding ||
                $request->produksi_welding_edit ||
                $request->produksi_welding_panen ||
                $request->produksi_welding_laporan ||
                $request->produksi_welding_laporan_edit ||
                $request->produksi_welding_rekap ||
                $request->produksi_tarik ||
                $request->produksi_tarik_edit ||
                $request->produksi_tarik_panen ||
                $request->produksi_tarik_laporan ||
                $request->produksi_tarik_laporan_edit ||
                $request->produksi_tarik_rekap
            ) {
                array_push($access, 'produksi');
            }
            if ($request->laporan_gudang) array_push($access, 'laporan.gudang');
            if ($request->laporan_wjl_efisiensi) array_push($access, 'laporan.wjl.efisiensi');
            if (
                $request->laporan_gudang ||
                $request->laporan_wjl_efisiensi
            ) {
                array_push($access, 'laporan');
            }
            if ($request->material) array_push($access, 'material');
            if ($request->mesin) array_push($access, 'mesin');
            if ($request->lokasi) array_push($access, 'lokasi');
            if (
                $request->material ||
                $request->mesin ||
                $request->lokasi
            ) {
                array_push($access, 'masterdata');
            }
            if ($request->peranpengguna) array_push($access, 'peranpengguna');
            if ($request->pengguna) array_push($access, 'pengguna');
            if ($request->approval) array_push($access, 'approval');
            if (
                $request->peranpengguna ||
                $request->pengguna ||
                $request->approval
            ) {
                array_push($access, 'pengaturan');
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
