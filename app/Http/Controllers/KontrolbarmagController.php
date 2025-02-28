<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Carbon\Carbon;
use App\Models\Kontrolbarmag;
use App\Models\Kontrolbarmagdetail;
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


class KontrolbarmagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produksiextruder.kontrolbarmag.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $shift = $request->shift;
        $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d') ?? date('Y-m-d');
        $shift_sebelumnya = '';
        if ($shift == 'Pagi') {
            $shift_sebelumnya = 'Malam';
            $tanggal_sebelumnya = Carbon::parse($tanggal)->subDays(1)->format('Y-m-d');
        } elseif ($shift == 'Sore') {
            $shift_sebelumnya = 'Pagi';
            $tanggal_sebelumnya = $tanggal;
        } elseif ($shift == 'Malam') {
            $shift_sebelumnya = 'Sore';
            $tanggal_sebelumnya = $tanggal;
        }

        if ($tanggal == 'null' || $tanggal == '') {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Pilih tanggal!'
            ]);
        }

        if ($shift == 'null' || $shift == '') {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Pilih shift!'
            ]);
        }

        $kontrolbarmag = Kontrolbarmag::where('tanggal', $tanggal)
            ->where('shift', $shift)
            ->first();

        $kontrolbarmag_sebelumnya = Kontrolbarmag::where('tanggal', $tanggal_sebelumnya)
            ->where('shift', $shift_sebelumnya)
            ->first();

        $action = 'create';
        if (!$kontrolbarmag) {
            $shift = $request->shift;
            $tanggal = $request->tanggal;
            $kontrolbarmag = Kontrolbarmag::where('shift', $shift)->where('tanggal', $tanggal)->where('status', 'Draft')->first();
            if (!$kontrolbarmag) {
                $kontrolbarmag = new Kontrolbarmag();
                $kontrolbarmag->slug = Controller::gen_slug();
                $kontrolbarmag->shift = $shift;
                $kontrolbarmag->tanggal = $tanggal;
                $kontrolbarmag->status = 'Draft';
                $kontrolbarmag->save();
            }
            $action = 'create';
            return view('produksiextruder.kontrolbarmag.show', compact('shift', 'tanggal', 'action', 'kontrolbarmag', 'kontrolbarmag_sebelumnya'));
        }

        if ($kontrolbarmag->status == 'Draft') {
            $action = 'edit';
            return view('produksiextruder.kontrolbarmag.show', compact('shift', 'tanggal', 'action', 'kontrolbarmag', 'kontrolbarmag_sebelumnya'));
        }

        return redirect()->back()->with([
            'status' => 'error',
            'message' => 'Laporan sudah di konfirmasi!'
        ]);
    }

    public function create_laporan(Request $request)
    {
        $shift = $request->shift;
        $tanggal = $request->tanggal;
        $kontrolbarmag = Kontrolbarmag::where('shift', $shift)->where('tanggal', $tanggal)->where('status', 'Draft')->first();
        if (!$kontrolbarmag) {
            $kontrolbarmag = new Kontrolbarmag();
            $kontrolbarmag->slug = Controller::gen_slug();
            $kontrolbarmag->shift = $shift;
            $kontrolbarmag->tanggal = $tanggal;
            $kontrolbarmag->status = 'Draft';
            $kontrolbarmag->save();
        }
        return view('produksiextruder.kontrolbarmag.create', compact('shift', 'tanggal', 'kontrolbarmag'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'operator' => 'required',
            'shift' => 'required',
            'tanggal' => 'required',
            'keterangan' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $order_shift = '';
            if ($request->shift == 'Pagi') {
                $order_shift = '1';
            } elseif ($request->shift == 'Sore') {
                $order_shift = '2';
            } elseif ($request->shift == 'Malam') {
                $order_shift = '3';
            }
            $gen_no_dokumen = Controller::gen_no_dokumen('produksiwjl');
            $produksiwjl = new Produksiwjl();
            $produksiwjl->slug = Controller::gen_slug();
            $produksiwjl->tanggal = $request->tanggal;

            $produksiwjl->created_by = Auth::user()->id;
            $produksiwjl->status = 'Submit'; //$pengaturan->nilai == 'Ya' ? 'Submit' : 'Confirmed';
            $produksiwjl->order_shift = $order_shift;
            $produksiwjl->save();

            if ($request->hasFile('foto')) {
                $files = $request->file('foto');
                foreach ($files as $file) {
                    $realname = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $directory = "produksiwjl";
                    $filename = Str::random(24) . "." . $extension;
                    $file->storeAs($directory, $filename);

                    // $manager = new ImageManager(new Driver());
                    // $image = ImageManager::imagick()->read('storage/' . $directory . '/' . $filename);
                    // $image->resizeDown(height: 100);
                    // $image->scaleDown(height: 100);

                    $foto_db = new Foto();
                    $foto_db->slug = Controller::gen_slug();
                    $foto_db->dokumen = 'produksiwjl';
                    $foto_db->dokumen_id = $produksiwjl->id;
                    $foto_db->fulltext = 'storage/' . $directory . '/' . $filename;
                    $foto_db->directory = $directory;
                    $foto_db->filename = $filename;
                    $foto_db->realname = $realname;
                    $foto_db->extension = $extension;
                    $foto_db->created_by = Auth::user()->id;
                    $foto_db->save();
                }
            }

            DB::commit();
            return redirect()->route('produksiwjl.operator.index')->with([
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
        $shift = $request->shift;
        $tanggal = $request->tanggal;
        $kontrolbarmag = Kontrolbarmag::find($requet->kontrolbarmag_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kontrolbarmag $kontrolbarmag)
    {
        $shift = $kontrolbarmag->shift;
        $tanggal = $kontrolbarmag->tanggal;
        return view('produksiextruder.kontrolbarmag.edit', compact('shift', 'tanggal', 'kontrolbarmag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kontrolbarmag $kontrolbarmag)
    {
        $shift = $kontrolbarmag->shift;
        $tanggal = $kontrolbarmag->tanggal;
        return view('produksiextruder.kontrolbarmag.edit', compact('shift', 'tanggal', 'kontrolbarmag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kontrolbarmag $kontrolbarmag)
    {
        DB::beginTransaction();
        try {
            $kontrolbarmag->pengawas = $request->pengawas;
            $kontrolbarmag->jenis = $request->jenis;
            $kontrolbarmag->melt_flow = $request->melt_flow;
            $kontrolbarmag->jenis_produksi = $request->jenis_produksi;
            $kontrolbarmag->bahan_campuran = $request->bahan_campuran;
            $kontrolbarmag->pengetesan_mesin = $request->pengetesan_mesin;
            $kontrolbarmag->lebar_spacer = $request->lebar_spacer;
            $kontrolbarmag->lebar_benang_jadi = $request->lebar_benang_jadi;
            $kontrolbarmag->jumlah_benang_jadi = $request->jumlah_benang_jadi;
            $kontrolbarmag->denier = $request->denier;
            $kontrolbarmag->srt = $request->srt;
            $kontrolbarmag->tebal_film = $request->tebal_film;
            $kontrolbarmag->screw_rpm = $request->screw_rpm;
            $kontrolbarmag->take_of_speed = $request->take_of_speed;
            $kontrolbarmag->godet_1_rpm = $request->godet_1_rpm;
            $kontrolbarmag->godet_2_rpm = $request->godet_2_rpm;
            $kontrolbarmag->godet_3_rpm = $request->godet_3_rpm;
            $kontrolbarmag->cylinder_1 = $request->cylinder_1;
            $kontrolbarmag->cylinder_2 = $request->cylinder_2;
            $kontrolbarmag->cylinder_3 = $request->cylinder_3;
            $kontrolbarmag->adaptor_1 = $request->adaptor_1;
            $kontrolbarmag->long_life_filter = $request->long_life_filter;
            $kontrolbarmag->dies_1 = $request->dies_1;
            $kontrolbarmag->dies_2 = $request->dies_2;
            $kontrolbarmag->dies_3 = $request->dies_3;
            $kontrolbarmag->olie_g2roll_45 = $request->olie_g2roll_45;
            $kontrolbarmag->olie_g2roll_67 = $request->olie_g2roll_67;
            $kontrolbarmag->temp_oven_1 = $request->temp_oven_1;
            $kontrolbarmag->temp_oven_2 = $request->temp_oven_2;
            $kontrolbarmag->temp_pendingin_film = $request->temp_pendingin_film;
            $kontrolbarmag->bak_air = $request->bak_air;
            $kontrolbarmag->cyller = $request->cyller;
            $kontrolbarmag->keterangan = $request->keterangan;
            $kontrolbarmag->updated_by = Auth::user()->id;
            $kontrolbarmag->save();
            DB::commit();
            return redirect()->route('produksiextruder-kontrol-barmag.index')->with([
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
    public function destroy(Kontrolbarmag $kontrolbarmag)
    {
        //
    }

    public function cek_sebelumnya(Request $request)
    {
        $mesin_id = $request->mesin_id;
        $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d') ?? date('Y-m-d');
        $shift = $request->shift;
        if ($shift == 'Pagi') {
            $shift = "Malam";
            $tanggal = Carbon::parse($tanggal)->subDays(1)->format('Y-m-d');
        } elseif ($shift == 'Sore') {
            $shift = "Pagi";
        } elseif ($shitf == 'Malam') {
            $shift = "Sore";
        }
        $produksiwjl = Produksiwjl::where('tanggal', $tanggal)->where('shift', $shift)->where('mesin_id', $mesin_id)->first();
        return response()->json([
            'status' => 'success',
            'data' => $produksiwjl,
            'message' => 'success'
        ]);
    }

    public function confirm(Request $request, Kontrolbarmag $kontrolbarmag)
    {
        return view('produksiextruder.kontrolbarmag.confirm');
    }
}
