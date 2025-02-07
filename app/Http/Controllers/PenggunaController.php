<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $user = User::query();
            // $user = $user->where('email', '!=', 'elvinalmutakin@gmail.id');
            $user = $user->where('email', '=', null);
            $user = $user->get();
            return DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    $button = '
                        <button type="button" class="btn btn-info" data-toggle="dropdown"><i
                                class="fa fa-wrench"></i>
                            Aksi</button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('pengguna.edit', $item->id) . '")"> <i class="fas fa-pencil-alt"></i> Edit</a>
                            <button class="dropdown-item" onClick="hapus(\'' . $item->id . '\')"><i class="fas fa-trash"></i> Hapus</button>
                        </div>';
                    return $button;
                })
                ->make();
        }
        return view('pengguna.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengguna.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,username',
            'name' => 'required',
            'password' => 'required|string|max:255|confirmed',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $pengguna = new User();
            $pengguna->slug = Controller::gen_slug();
            $pengguna->username = $request->username;
            $pengguna->name = $request->name;
            $pengguna->password = bcrypt($request->password);
            $pengguna->save();
            $role = Role::find($request->role_id);
            $pengguna->assignRole($role);
            DB::commit();
            return redirect()->route('pengguna.index')->with([
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
    public function show(User $user)
    {
        return view('pengguna.edit', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('pengguna.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        if ($request->password) {
            $validator = Validator::make($request->all(), [
                'username' => 'required|unique:users,username,' . $user->id . ',id',
                'name' => 'required',
                'password' => 'required|string|max:255|confirmed',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'username' => 'required|unique:users,username,' . $user->id . ',id',
            ]);
        }
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->getMessageBag())->withInput();
        }
        DB::beginTransaction();
        try {
            $user->username = $request->username;
            $user->name = $request->name;
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->save();
            $role = Role::find($request->role_id);
            $user->assignRole($role);
            DB::commit();
            return redirect()->route('pengguna.index')->with([
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
    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();
            return redirect()->route('pengguna.index')->with([
                'status' => 'success',
                'message' => 'Data telah dihapus!'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('error', compact('th'));
        }
    }

    public function get_peranpengguna(Request $request)
    {
        if ($request->ajax()) {
            $term = trim($request->term);
            $role = Role::selectRaw("id, name as text")
                ->whereNot('name', 'superadmin')
                ->where('name', 'like', '%' . $term . '%')
                ->orderBy('name')->simplePaginate(10);
            $total_count = count($role);
            $morePages = true;
            $pagination_obj = json_encode($role);
            if (empty($role->nextPageUrl())) {
                $morePages = false;
            }
            $result = [
                "results" => $role->items(),
                "pagination" => [
                    "more" => $morePages
                ],
                "total_count" => $total_count
            ];
            return response()->json($result);
        }
    }
}
