<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use Illuminate\Http\Request;

class ClassesController extends Controller
{

    public function loadData()
    {
        $classes = Classes::with('students')->get();

        $classesData = $classes->map(function ($class) {
            return [
                'id' => $class->id,
                'name' => $class->name,
                'code' => $class->code,
                'description' => $class->description,
                'teacher' => $class->teacher,
                'students' => $class->students->count(),
            ];
        });

        return response()->json([
            'draw' => request()->get('draw'),
            'recordsTotal' => $classes->count(),
            'recordsFiltered' => $classes->count(),
            'data' => $classesData
        ]);
    }

    public function storeAjax(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teacher' => 'required|string|max:255',
        ]);

        // Create the class entry without the code
        $class = Classes::create([
            'name' => $request->name,
            'description' => $request->description,
            'teacher' => $request->teacher,
        ]);

        // Generate the unique code
        $class->code = 'BMTC' . $class->id;
        $class->save();

        return response()->json([
            'success' => true,
            'message' => 'Class created successfully!',
            'class' => $class,
        ]);
    }

    public function updateAjax(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teacher' => 'required|string|max:255',
        ]);

        $class = Classes::findOrFail($id);
        $class->update([
            'name' => $request->name,
            'description' => $request->description,
            'teacher' => $request->teacher,
        ]);

        return response()->json(['message' => 'Class updated successfully!']);
    }

    public function index()
    {
        //
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show(Classes $classes)
    {
        //
    }

    public function edit(Classes $classes)
    {
        //
    }

    public function update(Request $request, Classes $classes)
    {
        //
    }


    public function destroy(Classes $classes)
    {
        //
    }
}
