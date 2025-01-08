<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\StudentLoginRequest;
use App\Models\Student;


class ApiAuthController extends Controller
{
    public function login(StudentLoginRequest $request)
    {
        $validated = $request->validated();

        $student = Student::where('reg_no', $validated['reg_no'])->first();

        if (!$student || $validated['call_no'] !== $student->call_no) {
            return response()->json([
                'message' => 'Invalid credentials. Please check your registration number and call number.',
            ], 401);
        }

        $token = $student->createToken('student-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'student' => $student,
        ]);
    }
}
