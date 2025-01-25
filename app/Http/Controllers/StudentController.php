<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Models\UserLog;
use Illuminate\Http\Request;

class StudentController extends Controller
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
    public function store(StoreStudentRequest $request)
    {
        // Get the last student with the highest reg_no
        $lastStudent = Student::orderBy('id', 'desc')->first();

        // Generate the new reg_no
        $lastRegNo = $lastStudent ? intval(substr($lastStudent->reg_no, 3)) : 0;
        $newRegNo = 'BMT' . str_pad($lastRegNo + 1, 6, '0', STR_PAD_LEFT);

        // Add the new reg_no to the validated data
        $studentData = $request->validated();
        $studentData['reg_no'] = $newRegNo;
        $studentData['created_by'] = auth()->id();

        // Create the student record
        $student = Student::create($studentData);

        // Log the user action
        UserLog::create([
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'action' => 'create',
            'description' => 'Created a new student record',
            'route' => 'students.store',
            'method' => $request->method(),
            'status_code' => 201,
            'response_time' => '0.01s',
            'response_size' => '0.1kb',
            'response_message' => 'Student created successfully!'
        ]);

        try {
            $smsController = new SMSController();
            $smsController->sendSms(
                [$request->call_no],
                "Hi $request->name, welcome to BookMyTutor! \nYour reg no: $newRegNo.\nDownload our app and log in using your reg no and call no."
            );
        }catch (\Exception $e){
            return response()->json(['message' => 'Student created successfully! But failed to send SMS'], 201);
        }

        // Return success response
        return response()->json(['message' => 'Student created successfully!', 'student' => $student], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //  Return the student record
        return response()->json(['student' => $student], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'call_no' => 'required|digits:10|unique:students,call_no,' . $student->id,
            'wtp_no' => 'required|digits:10',
            'school_id' => 'required|exists:schools,id',
            'batch_id' => 'nullable|exists:batches,id',
            'email' => 'nullable|email|unique:students,email,' . $student->id,
            'address' => 'nullable|string|max:255',
            'created_at' => 'nullable|date',
        ]);

        $student->update($data);

        // Log the user action
        UserLog::create([
            'user_id' => auth()->id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'action' => 'update',
            'description' => 'Updated student record',
            'route' => 'students.update',
            'method' => $request->method(),
            'status_code' => 200,
            'response_time' => '0.01s',
            'response_size' => '0.1kb',
            'response_message' => 'Student updated successfully!'
        ]);

        return response()->json(['message' => 'Student updated successfully!', 'student' => $student], 200);
    }

    public function activate(Student $student)
    {
        $student->update(['is_active' => true]);

        return response()->json(['message' => 'Student activated successfully!'], 200);
    }

    public function deactivate(Student $student)
    {
        $student->update(['is_active' => false]);

        return response()->json(['message' => 'Student deactivated successfully!'], 200);
    }

    public function destroy(Student $student)
    {
        //
    }
}
