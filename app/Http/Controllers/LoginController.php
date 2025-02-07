<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use IvanoMatteo\LaravelDeviceTracking\Facades\DeviceTracker;
use IvanoMatteo\LaravelDeviceTracking\Traits\UseDevices;


class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login');
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
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $device = DeviceTracker::detectFindAndUpdate();
            $device_uuid = $device->device_uuid;
            $user_id = Auth::user()->id;
            DeviceTracker::flagAsVerifiedByUuid($device_uuid, $user_id);
            return redirect()->intended()->with([
                'status' => 'success',
                'message' => 'Selamat datang di HR - Etam!'
            ]);
        }

        return redirect()->route('login')->with([
            'status' => 'failed',
            'message' => 'Username atau password anda salah!'
        ]);
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
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
