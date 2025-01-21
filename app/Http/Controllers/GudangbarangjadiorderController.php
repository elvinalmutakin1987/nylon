<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Orderdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class GudangbarangjadiorderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = Order::whereIn('status', ['Open', 'On Progress'])->get();
        return view('gudangbarangjadi.order.index', compact('order'));
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
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function store_progress(Request $request, Order $order)
    {
        DB::beginTransaction();
        try {
            $orderdetail = new Orderdetail();
            $orderdetail->slug = Controller::gen_slug();
            $orderdetail->order_id = $order->id;
            $orderdetail->catatan = $request->catatan;
            $orderdetail->created_by = Auth::user()->id;
            $orderdetail->save();
            DB::commit();
            $order_id = $order->id;
            $view = view('gudangbarangjadi.order.list-progress', compact('order_id'))->render();
            return response()->json([
                'status' => 'success',
                'data' => $view,
                'message' => 'success'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ]);
        }
    }
}
