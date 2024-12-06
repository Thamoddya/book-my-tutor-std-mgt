<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouterController extends Controller
{
    public function login()
    {
        return view('pages.auth.login');
    }

    public function index()
    {
        return view('pages.protected.index');
    }
}
