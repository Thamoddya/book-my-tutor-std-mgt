<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Http\Requests\StoreScoolRequest;
use Illuminate\Http\Request;

class ScoolController extends Controller
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
    public function store(StoreScoolRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(School $scool)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $scool)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $scool)
    {
        //
    }

    public function searchSchools(Request $request)
    {
        $search = $request->input('search');
        $schools = School::where('name', 'LIKE', "%$search%")
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($schools);
    }
}
