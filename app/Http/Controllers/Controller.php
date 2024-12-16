<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function update(Request $request)
    {
        $user = auth()->user();

        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_image' => 'nullable|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        // Handle password update
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Debugging: Check if file is detected
            $imageFile = $request->file('profile_image');

            // Delete the old profile image if exists
            if ($user->profile_image && file_exists(public_path('profile/' . $user->profile_image))) {
                unlink(public_path('profile/' . $user->profile_image));
            }

            // Save the new profile image
            $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('profile'), $imageName);
            $data['profile_image'] = $imageName;
        }

        // Update user details
        $user->update($data);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
