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
                            <a class="dropdown-item" href="' . route('peranpengguna.edit', $item->slug) . '")"> <i class="fas fa-pencil-alt"></i> Edit</a>
                            <button class="dropdown-item" onClick="hapus(\'' . $item->slug . '\')"><i class="fas fa-trash"></i> Hapus</button>
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
