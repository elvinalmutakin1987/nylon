<?php

namespace App\Http\Controllers;

use App\Exports\KartustokExport;
use App\Models\Kartustok;
use App\Models\Material;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Number as SupportNumber;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class CekstokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $jenis = '';
            $gudang = '';
            if (request()->gudang == 'bahan-baku') {
                $jenis = "Bahan Baku";
                $gudang = "Gudang Bahan Baku";
            } elseif (request()->gudang == 'bahan-penolong') {
                $jenis = "Benang";
                $gudang = "Gudang Benang";
            } elseif (request()->gudang == 'benang') {
                $jenis = "Benang";
                $gudang = "Gudang Benang";
            } elseif (request()->gudang == 'barang-jadi') {
                $jenis = "Barang Jadi";
                $gudang = "Gudang Barang Jadi";
            } elseif (request()->gudang == 'wjl') {
                $jenis = "WJL";
                $gudang = "Gudang WJL";
            } elseif (request()->gudang == 'sulzer') {
                $jenis = "Sulzer";
                $gudang = "Gudang Sulzer";
            } elseif (request()->gudang == 'rashel') {
                $jenis = "Rashel";
                $gudang = "Gudang Rashel";
            } elseif (request()->gudang == 'extruder') {
                $jenis = "Extruder";
                $gudang = "Gudang Extruder";
            } elseif (request()->gudang == 'beaming') {
                $jenis = "Beaming";
                $gudang = "Gudang Beaming";
            } elseif (request()->gudang == 'packing') {
                $jenis = "Packing";
                $gudang = "Gudang Packing";
            } elseif (request()->gudang == 'avalan') {
                $jenis = "Avalan";
                $gudang = "Gudang Avalan";
            }
            $kartustok = Kartustok::query();
            $kartustok = $kartustok->select('material_id', 'satuan');
            $kartustok = $kartustok->where('gudang', '=', $gudang);
            $kartustok = $kartustok->groupBy('material_id', 'satuan');
            $kartustok = $kartustok->get();
            return DataTables::of($kartustok)
                ->addIndexColumn()
                ->addColumn('stok', function ($item) use ($gudang) {
                    $kartustok = Kartustok::where('material_id', $item->material_id)
                        ->where('gudang', $gudang)->where('satuan', $item->satuan)
                        ->orderBy('id', 'desc')
                        ->first();
                    return $kartustok ? SupportNumber::format((float) $kartustok->stok_akhir, precision: 1) : 0.0;
                })
                ->addColumn('satuan_2', function ($item) use ($gudang) {
                    return $item->satuan_2;
                })
                ->addColumn('stok_2', function ($item) use ($gudang) {
                    $kartustok = Kartustok::where('material_id', $item->material_id)
                        ->where('gudang', $gudang)->where('satuan', $item->satuan)
                        ->orderBy('id', 'desc')
                        ->first();
                    return $kartustok ? SupportNumber::format((float) $kartustok->stok_akhir_2, precision: 1) : 0.0;
                })
                ->addColumn('nama', function ($item) {
                    $material = Material::find($item->material_id);
                    return $material->nama;
                })
                ->addColumn('action', function ($item) {
                    $material = Material::find($item->material_id);
                    $button = '
                        <a type="button" class="btn btn-info" href="' . route('cekstok.show', $material->slug) . '?gudang=' . request()->gudang . '&satuan=' . $item->satuan . '")" target="_blank"><i
                                class="fa fa-exchange"></i> Kartu Stok</a>
                        ';
                    return $button;
                })
                ->make();
        }
        $gudang = request()->gudang;
        if (request()->gudang == 'bahan-baku') {
            return view('gudangbahanbaku.cekstok.index', compact('gudang'));
        } elseif (request()->gudang == 'bahan-penolong') {
            return view('gudangbahanbaku.cekstok.index', compact('gudang'));
        } elseif (request()->gudang == 'benang') {
            return view('gudangbenang.cekstok.index', compact('gudang'));
        } elseif (request()->gudang == 'barang-jadi') {
            return view('gudangbarangjadi.cekstok.index', compact('gudang'));
        } elseif (request()->gudang == 'wjl') {
            return view('gudangwjl.cekstok.index', compact('gudang'));
        } elseif (request()->gudang == 'sulzer') {
            return view('gudangsulzer.cekstok.index', compact('gudang'));
        } elseif (request()->gudang == 'rashel') {
            return view('gudangrashel.cekstok.index', compact('gudang'));
        } elseif (request()->gudang == 'extruder') {
            return view('gudangextruder.cekstok.index', compact('gudang'));
        } elseif (request()->gudang == 'beaming') {
            return view('gudangbeaming.cekstok.index', compact('gudang'));
        } elseif (request()->gudang == 'packing') {
            return view('gudangpacking.cekstok.index', compact('gudang'));
        } elseif (request()->gudang == 'avalan') {
            return view('gudangavalan.cekstok.index', compact('gudang'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tanggal_dari = request()->tanggal_dari ?? \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
        $tanggal_sampai = request()->tanggal_sampai ?? \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d');
        if (request()->gudang == 'bahan-baku') {
            $jenis = "Bahan Baku";
            $gudang = "Gudang Bahan Baku";
        } elseif (request()->gudang == 'bahan-penolong') {
            $jenis = "Bahan Baku";
            $gudang = "Gudang Bahan Baku";
        } elseif (request()->gudang == 'benang') {
            $jenis = "Benang";
            $gudang = "Gudang Benang";
        } elseif (request()->gudang == 'barang-jadi') {
            $jenis = "Barang Jadi";
            $gudang = "Gudang Barang Jadi";
        } elseif (request()->gudang == 'wjl') {
            $jenis = "WJL";
            $gudang = "Gudang WJL";
        } elseif (request()->gudang == 'sulzer') {
            $jenis = "Sulzer";
            $gudang = "Gudang Sulzer";
        } elseif (request()->gudang == 'rashel') {
            $jenis = "Rashel";
            $gudang = "Gudang Rashel";
        } elseif (request()->gudang == 'extruder') {
            $jenis = "Extruder";
            $gudang = "Gudang Extruder";
        } elseif (request()->gudang == 'beaming') {
            $jenis = "Beaming";
            $gudang = "Gudang Beaming";
        } elseif (request()->gudang == 'packing') {
            $jenis = "Packing";
            $gudang = "Gudang Packing";
        } elseif (request()->gudang == 'avalan') {
            $jenis = "Avalan";
            $gudang = "Gudang Avalan";
        }
        $satuan = request()->satuan;
        $material = Material::where('slug', $id)->first();
        $kartustok = Kartustok::where('material_id', $material->id)
            ->where('satuan', $satuan)
            ->where('gudang', $gudang)
            ->whereDate('created_at', '>=', $tanggal_dari)
            ->whereDate('created_at', '<=', $tanggal_sampai)
            ->get();
        $gudang = request()->gudang;
        if (request()->gudang == 'bahan-baku' || request()->gudang == 'bahan-penolong') {
            return view('gudangbahanbaku.cekstok.show', compact('kartustok', 'material', 'gudang', 'tanggal_dari', 'tanggal_sampai', 'satuan'));
        } elseif (request()->gudang == 'benang') {
            return view('gudangbenang.cekstok.show', compact('kartustok', 'material', 'gudang', 'tanggal_dari', 'tanggal_sampai', 'satuan'));
        } elseif (request()->gudang == 'barang-jadi') {
            return view('gudangbarangjadi.cekstok.show', compact('kartustok', 'material', 'gudang', 'tanggal_dari', 'tanggal_sampai', 'satuan'));
        } elseif (request()->gudang == 'extruder') {
            return view('gudangextruder.cekstok.show', compact('kartustok', 'material', 'gudang', 'tanggal_dari', 'tanggal_sampai', 'satuan'));
        } elseif (request()->gudang == 'wjl') {
            return view('gudangwjl.cekstok.show', compact('kartustok', 'material', 'gudang', 'tanggal_dari', 'tanggal_sampai', 'satuan'));
        } elseif (request()->gudang == 'sulzer') {
            return view('gudangsulzer.cekstok.show', compact('kartustok', 'material', 'gudang', 'tanggal_dari', 'tanggal_sampai', 'satuan'));
        } elseif (request()->gudang == 'rashel') {
            return view('gudangrashel.cekstok.show', compact('kartustok', 'material', 'gudang', 'tanggal_dari', 'tanggal_sampai', 'satuan'));
        } elseif (request()->gudang == 'beaming') {
            return view('gudangbeaming.cekstok.show', compact('kartustok', 'material', 'gudang', 'tanggal_dari', 'tanggal_sampai', 'satuan'));
        } elseif (request()->gudang == 'packing') {
            return view('gudangpacking.cekstok.show', compact('kartustok', 'material', 'gudang', 'tanggal_dari', 'tanggal_sampai', 'satuan'));
        } elseif (request()->gudang == 'avalan') {
            return view('gudangavalan.cekstok.show', compact('kartustok', 'material', 'gudang', 'tanggal_dari', 'tanggal_sampai', 'satuan'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function detail(Request $request, Material $material)
    {
        $view = '';
        $gudang = $request->gudang;
        $id = $material->id;
        $tanggal_dari = $request->tanggal_dari ?? \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d');
        $tanggal_sampai = $request->tanggal_sampai ?? \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d');
        if ($request->gudang == 'bahan-baku' || $request->gudang == 'bahan-penolong') {
            $jenis = "Bahan Baku";
            $gudang = "Gudang Bahan Baku";
        } elseif ($request->gudang == 'benang') {
            $jenis = "Benang";
            $gudang = "Gudang Benang";
        } elseif ($request->gudang == 'barang-jadi') {
            $jenis = "Barang Jadi";
            $gudang = "Gudang Barang Jadi";
        } elseif ($request->gudang == 'wjl') {
            $jenis = "WJL";
            $gudang = "Gudang WJL";
        } elseif ($request->gudang == 'sulzer') {
            $jenis = "Sulzer";
            $gudang = "Gudang Sulzer";
        } elseif ($request->gudang == 'rashel') {
            $jenis = "Rashel";
            $gudang = "Gudang Rashel";
        } elseif ($request->gudang == 'extruder') {
            $jenis = "Extruder";
            $gudang = "Gudang Extruder";
        } elseif ($request->gudang == 'beaming') {
            $jenis = "Beaming";
            $gudang = "Gudang Beaming";
        } elseif ($request->gudang == 'packing') {
            $jenis = "Packing";
            $gudang = "Gudang Packing";
        } elseif ($request->gudang == 'avalan') {
            $jenis = "Avalan";
            $gudang = "Gudang Avalan";
        }
        $satuan = $request->satuan;
        // $material = Material::where('slug', $material->id)->first();
        $kartustok = Kartustok::where('material_id', $material->id)
            ->where('satuan', $satuan)
            ->where('gudang', $gudang)
            ->whereDate('created_at', '>=', $tanggal_dari)
            ->whereDate('created_at', '<=', $tanggal_sampai)
            ->get();
        $gudang = $request->gudang;
        if ($request->gudang == 'bahan-baku' || $request->gudang == 'bahan-penolong') {
            $view = view('gudangbahanbaku.cekstok.detail', compact('kartustok', 'material', 'gudang', 'tanggal_dari', 'tanggal_sampai', 'satuan'))->render();
        } elseif ($request->gudang == 'benang') {
            $view = view('gudangbenang.cekstok.detail', compact('kartustok', 'material', 'gudang', 'tanggal_dari', 'tanggal_sampai', 'satuan'))->render();
        } elseif ($request->gudang == 'barang-jadi') {
            $view = view('gudangbarangjadi.cekstok.detail', compact('kartustok', 'material', 'gudang', 'tanggal_dari', 'tanggal_sampai', 'satuan'))->render();
        } elseif ($request->gudang == 'extruder') {
            $view = view('gudangextruder.cekstok.detail', compact('kartustok', 'material', 'gudang', 'tanggal_dari', 'tanggal_sampai', 'satuan'))->render();
        } elseif ($request->gudang == 'wjl') {
            $view = view('gudangwjl.cekstok.detail', compact('kartustok', 'material', 'gudang', 'tanggal_dari', 'tanggal_sampai', 'satuan'))->render();
        } elseif ($request->gudang == 'sulzer') {
            $view = view('gudangsulzer.cekstok.detail', compact('kartustok', 'material', 'gudang', 'tanggal_dari', 'tanggal_sampai', 'satuan'))->render();
        } elseif ($request->gudang == 'rashel') {
            $view = view('gudangrashel.cekstok.detail', compact('kartustok', 'material', 'gudang', 'tanggal_dari', 'tanggal_sampai', 'satuan'))->render();
        } elseif ($request->gudang == 'beaming') {
            $view = view('gudangbeaming.cekstok.detail', compact('kartustok', 'material', 'gudang', 'tanggal_dari', 'tanggal_sampai', 'satuan'))->render();
        } elseif ($request->gudang == 'packing') {
            $view = view('gudangpacking.cekstok.detail', compact('kartustok', 'material', 'gudang', 'tanggal_dari', 'tanggal_sampai', 'satuan'))->render();
        } elseif ($request->gudang == 'avalan') {
            $view = view('gudangavalan.cekstok.detail', compact('kartustok', 'material', 'gudang', 'tanggal_dari', 'tanggal_sampai', 'satuan'))->render();
        }
        return response()->json([
            'status' => 'success',
            'data' => $view,
            'message' => 'success'
        ]);
    }

    public function cetak(Request $request)
    {
        $gudang = $request->gudang;
        $jenis = '';
        $gudang_ = '';
        if ($gudang == 'bahan-baku') {
            $jenis = "gudangbahanbaku";
            $gudang_ = "Gudang Bahan Baku";
        } elseif ($gudang == 'bahan-penolong') {
            $jenis = "gudanbahanbaku";
            $gudang_ = "Gudang Bahan Baku";
        } elseif ($gudang == 'benang') {
            $jenis = "gudangbenang";
            $gudang_ = "Gudang Benang";
        } elseif ($gudang == 'barang-jadi') {
            $jenis = "gudangbarangjadi";
            $gudang_ = "Gudang Barang Jadi";
        } elseif ($gudang == 'wjl') {
            $jenis = "gudangwjl";
            $gudang_ = "Gudang WJL";
        } elseif ($gudang == 'sulzer') {
            $jenis = "gudangsulzer";
            $gudang_ = "Gudang Sulzer";
        } elseif ($gudang == 'rashel') {
            $jenis = "gudangrashel";
            $gudang_ = "Gudang Rashel";
        } elseif ($gudang == 'extruder') {
            $jenis = "gudangextruder";
            $gudang_ = "Gudang Extruder";
        } elseif ($gudang == 'beaming') {
            $jenis = "gudangbeaming";
            $gudang_ = "Gudang Beaming";
        } elseif ($gudang == 'packing') {
            $jenis = "gudangpacking";
            $gudang_ = "Gudang Packing";
        } elseif ($gudang == 'avalan') {
            $jenis = "gudangavalan";
            $gudang_ = "Gudang Avalan";
        }
        $kartustok = Kartustok::select(
            DB::raw('(select nama from materials where id=kartustoks.material_id) as material'),
            'satuan',
            DB::raw('(select k2.stok_akhir from kartustoks k2 where k2.gudang=kartustoks.gudang and k2.material_id=kartustoks.material_id and k2.satuan=kartustoks.satuan order by k2.id desc limit 1) as stok')
        )
            ->where('gudang', '=', $gudang_)
            ->groupBy('satuan', 'material', 'stok')
            ->get();
        $pdf = PDF::loadview($jenis . '.cekstok.cetak', compact(
            'kartustok'
        ));
        return $pdf->download('laporan-stok-' . $gudang . '-' . date('Ymd') . '.pdf');
    }

    public function export(Request $request)
    {
        $gudang = $request->gudang;
        return Excel::download(new KartustokExport($gudang), 'laporan_stok_gudang_' . $gudang . '_' . date('Ymd') . '.xlsx');
    }
}
