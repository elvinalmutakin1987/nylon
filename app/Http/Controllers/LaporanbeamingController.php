<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Mesin;
use App\Models\Laporanbeaming;
use App\Models\Stockbeaming;
use Carbon\Carbon;
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

class LaporanbeamingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produksiextruder.laporanbeaming.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $jenis_produksi = $request->jenis_produksi;
        $beam_number = $request->beam_number;
        $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d') ?? date('Y-m-d');
        $tanggal_sebelumnya = Carbon::parse($tanggal)->subDays(1)->format('Y-m-d');

        if ($tanggal == 'null' || $tanggal == '') {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Pilih tanggal!'
            ]);
        }

        if ($beam_number == 'null' || $beam_number == '') {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Beam Number tidak boleh kosong!'
            ]);
        }

        if ($jenis_produksi == 'null' || $jenis_produksi == '') {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Pilih jenis produksi!'
            ]);
        }

        $laporanbeaming = Laporanbeaming::where('tanggal', $tanggal)
            ->where('beam_number', $beam_number)
            ->where('jenis_produksi', $jenis_produksi)
            ->first();

        $laporanbeaming_sebelumnya = Laporanbeaming::where('tanggal', $tanggal_sebelumnya)
            ->where('beam_number', $beam_number)
            ->where('jenis_produksi', $jenis_produksi)
            ->first();

        $action = 'create';
        if (!$laporanbeaming) {
            $jenis_produksi = $request->jenis_produksi;
            $beam_number = $request->beam_number;
            $tanggal = $request->tanggal;
            $laporanbeaming = Laporanbeaming::where('beam_number', $beam_number)
                ->where('tanggal', $tanggal)
                ->where('jenis_produksi', $jenis_produksi)
                ->where('status', 'Draft')->first();
            if (!$laporanbeaming) {
                $laporanbeaming = new laporanbeaming();
                $laporanbeaming->slug = Controller::gen_slug();
                $laporanbeaming->jenis_produksi = $jenis_produksi;
                $laporanbeaming->beam_number = $beam_number;
                $laporanbeaming->tanggal = $tanggal;
                $laporanbeaming->status = 'Draft';
                $laporanbeaming->created_by = Auth::user()->id;
                $laporanbeaming->save();
            }
            $action = 'create';
            return view('produksiextruder.laporanbeaming.show', compact('beam_number', 'tanggal', 'jenis_produksi', 'action', 'laporanbeaming', 'laporanbeaming_sebelumnya'));
        }

        if ($laporanbeaming->status == 'Panen') {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Beam telah dipanen!'
            ]);
        }

        if ($laporanbeaming->status == 'Draft') {
            $action = 'edit';
            return view('produksiextruder.laporanbeaming.show', compact('beam_number', 'tanggal',  'jenis_produksi',  'action', 'laporanbeaming', 'laporanbeaming_sebelumnya'));
        }

        return redirect()->back()->with([
            'status' => 'error',
            'message' => 'Laporan sudah di konfirmasi!'
        ]);
    }

    public function create_laporan(Request $request)
    {
        $jenis_produksi = $request->jenis_produksi;
        $beam_number = $request->beam_number;
        $tanggal = $request->tanggal;
        return view('produksiextruder.laporanbeaming.create', compact('jenis_produksi', 'beam_number', 'tanggal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $laporanbeaming = Laporanbeaming::where('tanggal', Carbon::parse($request->tanggal)->format('Y-m-d'))
                ->where('jenis_produksi', $request->jenis_produksi)
                ->where('beam_number', $request->beam_number)
                ->where('status', 'Draft')
                ->first();
            if (!$laporanbeaming) {
                $laporanbeaming = new Laporanbeaming();
                $laporanbeaming->slug = Controller::gen_slug();
                $laporanbeaming->tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');
                $laporanbeaming->jenis_produksi = $request->jenis_produksi;
                $laporanbeaming->beam_number = $request->beam_number;
                $laporanbeaming->created_by = Auth::user()->id;
            }
            $laporanbeaming->nomor = $request->nomor;
            $laporanbeaming->jenis_bahan = $request->jenis_bahan;
            $laporanbeaming->denier = $request->denier;
            $laporanbeaming->lebar_benang = $request->lebar_benang;
            $laporanbeaming->warna_benang = $request->warna_benang;
            $laporanbeaming->jumlah_lungsi = $request->jumlah_lungsi;
            $laporanbeaming->lebar_beam = $request->lebar_beam;
            $laporanbeaming->front_reed = $request->front_reed;
            $laporanbeaming->rear_reed = $request->rear_reed;
            $laporanbeaming->traverse_reed = $request->traverse_reed;
            $laporanbeaming->benang_pinggiran_kiri = $request->benang_pinggiran_kiri;
            $laporanbeaming->benang_pinggiran_kanan = $request->benang_pinggiran_kanan;
            $laporanbeaming->benang_pinggiran_benang = $request->benang_pinggiran_benang;
            $laporanbeaming->lebar_traverse = $request->lebar_traverse;
            $laporanbeaming->kecepatan_beaming = $request->kecepatan_beaming;
            $laporanbeaming->cut_mark = $request->cut_mark;
            $laporanbeaming->panjang_press_roller = $request->panjang_press_roller;
            $laporanbeaming->tekanan_press_roller = $request->tekanan_press_roller;
            $laporanbeaming->tension_roller_no_1 = $request->tension_roller_no_1;
            $laporanbeaming->tension_roller_no_2 = $request->tension_roller_no_2;
            $laporanbeaming->traverse_reed_design = $request->traverse_reed_design;
            $laporanbeaming->nomor_sulzer = $request->nomor_sulzer;
            $laporanbeaming->tanggal_sulzer = Carbon::parse($request->tanggal_sulzer)->format('Y-m-d');
            $laporanbeaming->keterangan = $request->keterangan;
            $laporanbeaming->status = $request->status ?? "Panen";
            $laporanbeaming->updated_by = Auth::user()->id;
            $laporanbeaming->save();
            foreach ($request->tanggal_detail as $key => $tanggal_detail) {
                $detail[] = [
                    'laporanbeaming_id' => $laporanbeaming->id,
                    'slug' => Controller::gen_slug(),
                    'tanggal' => Carbon::parse($request->tanggal_detail[$key])->format('Y-m-d'),
                    'shift' => $request->shift_detail[$key],
                    'meter_awal' => $request->meter_awal[$key] ? Controller::unformat_angka($request->meter_awal[$key]) : null,
                    'meter_akhir' => $request->meter_akhir[$key] ? Controller::unformat_angka($request->meter_akhir[$key]) : null,
                    'meter_hasil' => $request->meter_hasil[$key] ? Controller::unformat_angka($request->meter_hasil[$key]) : null,
                ];
            }
            $laporanbeaming->laporanbeamingdetail()->delete();
            $laporanbeaming->laporanbeamingdetail()->createMany($detail);
            // foreach ($request->panen_ke as $key => $panen_ke) {
            //     $detail2[] = [
            //         'laporanbeaming_id  ' => $laporanbeaming->id,
            //         'slug' => Controller::gen_slug(),
            //         'panen_ke' => $request->panen_ke[$key] ? Controller::unformat_angka($request->panen_ke[$key]) : null,
            //         'meter' => $request->meter[$key] ? Controller::unformat_angka($request->meter[$key]) : null,
            //     ];
            // }
            // $laporanbeaming->laporanbeamingpanen()->delete();
            // $laporanbeaming->laporanbeamingpanen()->createMany($detail2);
            if ($laporanbeaming->status == "Panen") {
                $stockbeaming = new Stockbeaming();
                $stockbeaming->slug = Controller::gen_slug();
                $stockbeaming->laporanbeaming_id = $laporanbeaming->id;
                $stockbeaming->posisi = 'Bawah';
                $stockbeaming->meter_hasil = $laporanbeaming->laporanbeamingdetail->sum('meter_hasil');
                $stockbeaming->status = 'Aktif';
                $stockbeaming->updated_by = Auth::user()->id;
                $stockbeaming->save();
            }
            DB::commit();
            return redirect()->route('produksiextruder.laporanbeaming.index')->with([
                'status' => 'success',
                'message' => 'Data telah disimpan!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('error', compact('th'));
        }
    }

    public function store_laporan(Request $request)
    {
        $beam_number = $request->beam_number;
        $jenis_produksi = $request->jenis_produksi;
        $tanggal = $request->tanggal;
        $laporanbeaming = Laporanbeaming::find($request->laporanbeaming_id);
    }


    /**
     * Display the specified resource.
     */
    public function show(Laporanbeaming $laporanbeaming)
    {
        $beam_number = $laporanbeaming->beam_number;
        $jenis_produksi = $laporanbeaming->jenis_produksi;
        $tanggal = $laporanbeaming->tanggal;
        return view('produksiextruder.laporanbeaming.edit', compact('beam_number', 'jenis_produksi', 'tanggal', 'laporanbeaming'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laporanbeaming $laporanbeaming)
    {
        $jenis_produksi = $laporanbeaming->jenis_produksi;
        $beam_number = $laporanbeaming->beam_number;
        $tanggal = $laporanbeaming->tanggal;
        return view('produksiextruder.laporanbeaming.edit', compact('beam_number', 'jenis_produksi', 'tanggal', 'laporanbeaming'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Laporanbeaming $laporanbeaming)
    {
        DB::beginTransaction();
        try {
            $laporanbeaming->nomor = $request->nomor;
            $laporanbeaming->jenis_bahan = $request->jenis_bahan;
            $laporanbeaming->denier = $request->denier;
            $laporanbeaming->lebar_benang = $request->lebar_benang;
            $laporanbeaming->warna_benang = $request->warna_benang;
            $laporanbeaming->jumlah_lungsi = $request->jumlah_lungsi;
            $laporanbeaming->lebar_beam = $request->lebar_beam;
            $laporanbeaming->front_reed = $request->front_reed;
            $laporanbeaming->rear_reed = $request->rear_reed;
            $laporanbeaming->traverse_reed = $request->traverse_reed;
            $laporanbeaming->benang_pinggiran_kiri = $request->benang_pinggiran_kiri;
            $laporanbeaming->benang_pinggiran_kanan = $request->benang_pinggiran_kanan;
            $laporanbeaming->benang_pinggiran_benang = $request->benang_pinggiran_benang;
            $laporanbeaming->lebar_traverse = $request->lebar_traverse;
            $laporanbeaming->kecepatan_beaming = $request->kecepatan_beaming;
            $laporanbeaming->cut_mark = $request->cut_mark;
            $laporanbeaming->panjang_press_roller = $request->panjang_press_roller;
            $laporanbeaming->tekanan_press_roller = $request->tekanan_press_roller;
            $laporanbeaming->tension_roller_no_1 = $request->tension_roller_no_1;
            $laporanbeaming->tension_roller_no_2 = $request->tension_roller_no_2;
            $laporanbeaming->traverse_reed_design = $request->traverse_reed_design;
            $laporanbeaming->nomor_sulzer = $request->nomor_sulzer;
            $laporanbeaming->tanggal_sulzer = Carbon::parse($request->tanggal_sulzer)->format('Y-m-d');
            $laporanbeaming->keterangan = $request->keterangan;
            $laporanbeaming->status = $request->status ?? "Panen";
            $laporanbeaming->updated_by = Auth::user()->id;
            $laporanbeaming->save();
            foreach ($request->tanggal_detail as $key => $tanggal_detail) {
                $detail[] = [
                    'laporanbeaming_id' => $laporanbeaming->id,
                    'slug' => Controller::gen_slug(),
                    'tanggal' => Carbon::parse($request->tanggal_detail[$key])->format('Y-m-d'),
                    'shift' => $request->shift_detail[$key],
                    'meter_awal' => $request->meter_awal[$key] ? Controller::unformat_angka($request->meter_awal[$key]) : null,
                    'meter_akhir' => $request->meter_akhir[$key] ? Controller::unformat_angka($request->meter_akhir[$key]) : null,
                    'meter_hasil' => $request->meter_hasil[$key] ? Controller::unformat_angka($request->meter_hasil[$key]) : null,
                ];
            }
            $laporanbeaming->laporanbeamingdetail()->delete();
            $laporanbeaming->laporanbeamingdetail()->createMany($detail);
            // foreach ($request->panen_ke as $key => $panen_ke) {
            //     $detail2[] = [
            //         'laporanbeaming_id  ' => $laporanbeaming->id,
            //         'slug' => Controller::gen_slug(),
            //         'panen_ke' => $request->panen_ke[$key] ? Controller::unformat_angka($request->panen_ke[$key]) : null,
            //         'meter' => $request->meter[$key] ? Controller::unformat_angka($request->meter[$key]) : null,
            //     ];
            // }
            // $laporanbeaming->laporanbeamingpanen()->delete();
            // $laporanbeaming->laporanbeamingpanen()->createMany($detail2);
            if ($laporanbeaming->status == "Panen") {
                $stockbeaming = new Stockbeaming();
                $stockbeaming->slug = Controller::gen_slug();
                $stockbeaming->laporanbeaming_id = $laporanbeaming->id;
                $stockbeaming->posisi = 'Bawah';
                $stockbeaming->meter_hasil = $laporanbeaming->laporanbeamingdetail->sum('meter_hasil');
                $stockbeaming->status = 'Aktif';
                $stockbeaming->updated_by = Auth::user()->id;
                $stockbeaming->save();
            }
            DB::commit();
            return redirect()->route('produksiextruder.laporanbeaming.index')->with([
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
    public function destroy(Laporanbeaming $laporanbeaming)
    {
        //
    }

    public function cek_sebelumnya(Request $request)
    {
        $jenis_produksi = $request->jenis_produksi;
        $beam_number = $request->beam_number;
        $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d') ?? date('Y-m-d');
        $laporanbeaming = Laporanbeaming::where('tanggal', $tanggal)
            ->where('jenis_produksi', $jenis_produksi)
            ->where('beam_number', $beam_number)
            ->first();
        return response()->json([
            'status' => 'success',
            'data' => $laporanbeaming,
            'message' => 'success'
        ]);
    }

    public function confirm(Request $request, Laporanbeaming $laporanbeaming)
    {
        return view('produksiextruder.laporanbeaming.confirm');
    }

    public function get_mesin(Request $request)
    {
        if ($request->ajax()) {
            $term = trim($request->term);
            $mesin = Mesin::selectRaw("id, nama as text")
                ->where('nama', 'like', '%' . $term . '%')
                ->orderByRaw('CONVERT(nama, SIGNED) asc')->simplePaginate(10);
            $total_count = count($mesin);
            $morePages = true;
            $pagination_obj = json_encode($mesin);
            if (empty($mesin->nextPageUrl())) {
                $morePages = false;
            }
            $result = [
                "results" => $mesin->items(),
                "pagination" => [
                    "more" => $morePages
                ],
                "total_count" => $total_count
            ];
            return response()->json($result);
        }
    }
}
