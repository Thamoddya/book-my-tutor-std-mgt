<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ScoolController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $schools = School::query();

            return DataTables::of($schools)
                ->addColumn('actions', function ($school) {
                    return '
                        <button class="btn btn-sm btn-warning edit-school-btn" data-id="' . $school->id . '" data-name="' . $school->name . '">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteSchool(' . $school->id . ')">Delete</button>
                    ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('pages.protected.schools');
    }

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

    public function destroy($id)
    {
        try {
            $school = School::findOrFail($id);
            $school->delete();
            return response()->json(['success' => 'School deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
