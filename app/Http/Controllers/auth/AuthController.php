<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function LoginProcess(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            session()->put('token', $token);

            $roles = $user->getRoleNames();

            if ($roles[0] == "Super_Admin") {
                return redirect()->route('SuperAdmin.Home');
            }
        } else {
            return back()->with('error', 'Invalid Email or Password');
        }
    }
}
