<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function LoginProcess(Request $request)
    {

        $credentials = $request->validate([
            'nic' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            session()->put('token', $token);

            $roles = $user->getRoleNames();

            // Log the user action
            UserLog::create([
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'action' => 'login',
                'description' => 'Logged in to the system',
                'route' => 'auth.login',
                'method' => $request->method(),
                'status_code' => 200,
                'response_time' => '0.01s',
                'response_message' => 'Logged in successfully'
            ]);

            return redirect()->route('index');
        } else {
            return back()->with('error', 'Invalid Nic or Password');
        }
    }

    public function LogoutProcess()
    {

        // Log the user action

        UserLog::create([
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'action' => 'logout',
            'description' => 'Logged out from the system',
            'route' => 'auth.logout',
            'method' => request()->method(),
            'status_code' => 200,
            'response_time' => '0.01s',
            'response_message' => 'Logged out successfully'
        ]);
        Auth::logout();
        session()->forget('token');
        return redirect()->route('login');
    }
}
