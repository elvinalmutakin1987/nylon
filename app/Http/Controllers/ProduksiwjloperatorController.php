<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Mesin;
use App\Models\Pengaturan;
use App\Models\Produksiwjl;
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

class ProduksiwjloperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('produksiwjl.operator.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $mesin_id = $request->mesin_id;
        $mesin = Mesin::find($mesin_id);
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

        if ($mesin_id == 'null' || $mesin_id == '') {
            return redirect()->back()->with([
                'status' => 'error',
                'message' => 'Pilih mesin!'
            ]);
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

        $produksiwjl = Produksiwjl::where('mesin_id', $mesin_id)
            ->where('tanggal', $tanggal)
            ->where('shift', $shift)
            ->first();

        $produksiwjl_sebelumnya = Produksiwjl::where('mesin_id', $mesin_id)
            ->where('tanggal', $tanggal_sebelumnya)
            ->where('shift', $shift_sebelumnya)
            ->first();

        $action = 'create';
        if (!$produksiwjl) {
            $action = 'create';
            return view('produksiwjl.operator.show', compact('shift', 'tanggal', 'mesin_id', 'mesin', 'action', 'produksiwjl_sebelumnya'));
        }

        if ($produksiwjl->status == 'Submit') {
            $action = 'edit';
            return view('produksiwjl.operator.show', compact('shift', 'tanggal', 'mesin_id', 'mesin', 'action', 'produksiwjl', 'produksiwjl_sebelumnya'));
        }

        return redirect()->back()->with([
            'status' => 'error',
            'message' => 'Laporan sudah di konfirmasi kepala regu / pengawas!'
        ]);
    }

    public function create_laporan(Request $request)
    {
        $shift = $request->shift;
        $tanggal = $request->tanggal;
        $mesin_id = $request->mesin_id;
        $mesin = Mesin::find($mesin_id);
        return view('produksiwjl.operator.create', compact('shift', 'tanggal', 'mesin_id', 'mesin'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'operator' => 'required',
            'mesin_id' => 'required',
            'jenis_kain' => 'required',
            'shift' => 'required',
            'meter_awal' => 'required',
            'meter_akhir' => 'required',
            'hasil' => 'required',
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
            //$pengaturan = Pengaturan::where('keterangan', 'produksiwjl.operator.butuh.approval')->first();
            $gen_no_dokumen = Controller::gen_no_dokumen('produksiwjl');
            $produksiwjl = new Produksiwjl();
            $produksiwjl->slug = Controller::gen_slug();
            $produksiwjl->tanggal = $request->tanggal;
            $produksiwjl->operator = $request->operator;
            $produksiwjl->shift = $request->shift;
            $produksiwjl->mesin_id = $request->mesin_id;
            $produksiwjl->jenis_kain = $request->jenis_kain;
            $produksiwjl->meter_awal = Controller::unformat_angka($request->meter_awal ?? '0');
            $produksiwjl->meter_akhir = Controller::unformat_angka($request->meter_akhir ?? '0');
            $produksiwjl->hasil = Controller::unformat_angka($request->hasil ?? '0');
            $produksiwjl->keterangan = $request->keterangan;
            $produksiwjl->lungsi = Controller::unformat_angka($request->lungsi ?? '0');
            $produksiwjl->pakan = Controller::unformat_angka($request->pakan ?? '0');
            $produksiwjl->lubang = $request->lubang;
            $produksiwjl->pgr = $request->pgr;
            $produksiwjl->lebar = Controller::unformat_angka($request->lebar ?? '0');
            $produksiwjl->mesin = $request->mesin;
            $produksiwjl->teknisi = $request->teknisi;
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

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Produksiwjl $produksiwjl) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produksiwjl $produksiwjl)
    {
        return view('produksiwjl.operator.edit', compact('produksiwjl'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produksiwjl $produksiwjl)
    {
        $validator = Validator::make($request->all(), [
            'operator' => 'required',
            'mesin_id' => 'required',
            'jenis_kain' => 'required',
            'shift' => 'required',
            'meter_awal' => 'required',
            'meter_akhir' => 'required',
            'hasil' => 'required',
            'keterangan' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            //$pengaturan = Pengaturan::where('keterangan', 'produksiwjl.operator.butuh.approval')->first();
            $produksiwjl->tanggal = $request->tanggal;
            $produksiwjl->operator = $request->operator;
            $produksiwjl->shift = $request->shift;
            $produksiwjl->mesin_id = $request->mesin_id;
            $produksiwjl->jenis_kain = $request->jenis_kain;
            $produksiwjl->meter_awal = Controller::unformat_angka($request->meter_awal ?? '0');
            $produksiwjl->meter_akhir = Controller::unformat_angka($request->meter_akhir ?? '0');
            $produksiwjl->hasil = Controller::unformat_angka($request->hasil ?? '0');
            $produksiwjl->keterangan = $request->keterangan;
            $produksiwjl->lungsi = Controller::unformat_angka($request->lungsi ?? '0');
            $produksiwjl->pakan = Controller::unformat_angka($request->pakan ?? '0');
            $produksiwjl->lubang = $request->lubang;
            $produksiwjl->pgr = $request->pgr;
            $produksiwjl->lebar = Controller::unformat_angka($request->lebar ?? '0');
            $produksiwjl->mesin = $request->mesin;
            $produksiwjl->teknisi = $request->teknisi;
            $produksiwjl->updated_by = Auth::user()->id;
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produksiwjl $produksiwjl)
    {
        //
    }

    public function get_mesin(Request $request)
    {
        if ($request->ajax()) {
            $term = trim($request->term);
            $mesin = Mesin::selectRaw("id, nama as text")
                ->where('nama', 'like', '%' . $term . '%')
                ->orderBy('nama')->simplePaginate(10);
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

    public function get_detail(Request $request)
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
        $view =  view('produksiwjl.operator.show', compact('produksiwjl'))->render();
        return response()->json([
            'status' => 'success',
            'data' => $view,
            'message' => 'success'
        ]);
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

    public function confirm(Request $request, Produksiwjl $produksiwjl)
    {
        return view('produksiwjl.operator.confirm');
    }
}
