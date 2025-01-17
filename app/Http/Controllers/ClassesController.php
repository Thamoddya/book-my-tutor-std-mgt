<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Student;
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

    public function getClassStudents($id)
    {
        $class = Classes::with('students')->findOrFail($id);
        $students = $class->students->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->name,
                'email' => $student->email,
            ];
        });

        return response()->json(['data' => $students]);
    }

    public function addStudentToClass(Request $request, $id)
    {
        $request->validate([
            'reg_no' => 'required|exists:students,reg_no'
        ]);

        $class = Classes::findOrFail($id);
        $student = Student::where('reg_no', $request->reg_no)->firstOrFail();

        $class->students()->syncWithoutDetaching($student->id);

        return response()->json(['message' => 'Student added to class successfully!']);
    }

    public function removeStudentFromClass($class_id, $student_id)
    {
        $class = Classes::findOrFail($class_id);
        $student = Student::findOrFail($student_id);

        // Detach the student from the class
        $class->students()->detach($student_id);

        return response()->json(['message' => 'Student removed from class successfully!']);
    }

    public function destroy($id)
    {
        $class = Classes::findOrFail($id);
        $class->delete();

        return response()->json(['message' => 'Class deleted successfully!']);
    }
}
