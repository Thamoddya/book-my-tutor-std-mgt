<?php

namespace App\Http\Controllers\config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OneSignalController extends Controller
{
    public function updatePlayerID(Request $request)
    {
        $request->validate([
            'onesignal_player_id' => 'required|string',
        ]);

        $student = auth()->user();
        $student->onesignal_player_id = $request->onesignal_player_id;
        $student->save();

        return response()->json(['message' => 'Player ID updated successfully.'], 200);
    }

    public function sendNotification() {}
}
