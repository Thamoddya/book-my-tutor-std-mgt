<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
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
}
