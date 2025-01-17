<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StudentTodayClassesResponse;
use App\Models\ClassSchedule;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class ApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Welcome to the API',
        ]);
    }

    public function getStudent()
    {

        $student = auth()->user();

        $responseData = [
            'student' => $student->with('batch', 'school')->first(),
        ];

        return response()->json([
            'data' => $responseData,
        ], 200);
    }

    public function uploadImage(Request $request)
    {
        // Validate the request
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max size: 2MB
        ]);

        // Store the image in the "public/uploads" directory
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');

            // Generate the public URL with the full domain
            $url = asset('storage/' . $path);

            return response()->json([
                'success' => true,
                'url' => URL::to('/') . '/storage/' . $path,
                'message' => 'Image uploaded successfully.',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No image was uploaded.',
        ], 400);
    }

    public function updateStudentProfilePic(Request $request)
    {
        // Validate the request
        $request->validate([
            'image_url' => 'required|url',
        ]);

        // Get the image URL from the request
        $imageUrl = $request->input('image_url');

        // Update the student's profile picture
        $student = auth()->user();
        $student->profile_pic = $imageUrl;
        $student->save();

        return response()->json([
            'success' => true,
            'url' => $imageUrl,
            'message' => 'Profile picture updated successfully.',
        ], 200);
    }

    public function getStudentPayments()
    {
        $student = auth()->user();

        $responseData = [
            'payments' => Payment::where('student_id', $student->id)->get(),
        ];

        return response()->json([
            'data' => $responseData,
        ]);
    }

    public function getStudentTodayClasses()
    {
        // Get the authenticated student
        $student = auth()->user();


        // Get previous month and year
        $lastMonth = now()->subMonth();
        $previousMonth = $lastMonth->format('F');
        $previousYear = $lastMonth->format('Y');

        // Check payment for the current month
        $currentMonthPayment = Payment::where('student_id', $student->id)
            ->where('paid_month', now()->format('F'))
            ->where('paid_year', now()->format('Y'))
            ->first();

        if ($currentMonthPayment) {
            if ($currentMonthPayment->status === 'paid' || $currentMonthPayment->status === 'pending') {
                // Access granted for current month classes
                return $this->getTodayClassesForStudent($student);
            }
        } else {
            // Check payment for the previous month
            $previousMonthPayment = Payment::where('student_id', $student->id)
                ->where('paid_month', $previousMonth)
                ->where('paid_year', $previousYear)
                ->first();

            if ($previousMonthPayment && $previousMonthPayment->status === 'paid') {
                // Check if the current date is within the first week of the month
                if (date('d') <= 7) {
                    // Access granted for the first week of the current month
                    return $this->getTodayClassesForStudent($student);
                } else {
                    // Access denied after the first week of the current month
                    return response()->json([
                        'message' => 'Classes can only be accessed during the first week of the month. Please make a payment to access classes.',
                    ], 403);
                }
            }
        }

        // Neither current month nor previous month payment found
        return response()->json([
            'message' => 'Payment not found for the current or previous month. Please make a payment to access classes.',
        ], 403);
    }

    private function getTodayClassesForStudent($student)
    {

        $today = now()->format('Y-m-d');
        // Fetch class schedules for today where the student is enrolled in the corresponding class
        $classes = ClassSchedule::where('day', $today)
            ->whereHas('class.students', function ($query) use ($student) {
                $query->where('students.id', $student->id); // Filter by the student ID
            })
            ->with(['class.students']) // Optionally eager load related data
            ->get();

        return StudentTodayClassesResponse::collection($classes);
    }


    public static function getClassSchedule($id)
    {
        $schedule = ClassSchedule::with(['class'])->findOrFail($id);
        $schedule->start_time = \Carbon\Carbon::parse($schedule->start_time)->format('g:i A');
        $schedule->end_time = \Carbon\Carbon::parse($schedule->end_time)->format('g:i A');
        return response()->json($schedule);
    }

    public static function getStudentEnrolledClasses()
    {
        $student = auth()->user();
        $classes = $student->classes()->get();

        // Access 'getScheduleCountAttribute' for each class
        $classes->each(function ($class) {
            $class->schedule_count = $class->scheduleCount; // Call the accessor
        });

        return response()->json($classes);
    }

}
