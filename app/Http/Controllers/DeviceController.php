<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDevice;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'player_id' => 'required|string|unique:user_devices,player_id',
        ]);

        UserDevice::create([
            'user_id' => Auth::id(),
            'player_id' => $request->player_id,
        ]);

        return response()->json(['success' => true]);
    }
}
