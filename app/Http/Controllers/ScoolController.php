<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;

class ScoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schools = School::all();
        return view('pages.protected.schools', compact([
            'schools'
        ]));
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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            School::create([
                'name' => $request->input('name'),
            ]);

            return response()->json(['success' => 'School added successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
    public function edit(School $scool) {}

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $school = School::findOrFail($id);
        $school->update([
            'name' => $request->input('name'),
        ]);

        return response()->json(['success' => 'School updated successfully']);
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
