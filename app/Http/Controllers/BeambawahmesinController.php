<?php

namespace App\Http\Controllers;

use App\Models\Laporanbeaming;
use App\Models\Laporanbeamingdetail;
use App\Models\Laporanbeamingpanen;
use App\Models\Beambawahmesin;
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

class BeambawahmesinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Beambawahmesin $beambawahmesin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Beambawahmesin $beambawahmesin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Beambawahmesin $beambawahmesin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Beambawahmesin $beambawahmesin)
    {
        //
    }
}
