<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;

class RouterController extends Controller
{
    public function login()
    {
        //If the user is logged in, redirect to the index page

        if (auth()->check()) {
            return $this->index();
        }

        return view('pages.auth.login');
    }

    public function index()
    {
        return view('pages.protected.index');
    }

    public function batchManagement()
    {
        $batches = Batch::all();
        return view('pages.protected.batch', compact([
            'batches'
        ]));
    }
}
