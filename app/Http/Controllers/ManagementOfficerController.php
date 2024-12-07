<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ManagementOfficerController extends Controller
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'nic' => 'required|string|unique:users,nic',
            'phone' => 'required|string',
            'address' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        try {
            // Save the management officer data
            $managementOfficer = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'nic' => $validatedData['nic'],
                'phone' => $validatedData['phone'],
                'address' => $validatedData['address'],
                'password' => bcrypt($validatedData['password']),
            ]);

            // Assign the management officer role
            $managementOfficer->assignRole('management_officer');

            return response()->json([
                'message' => 'Management Officer created successfully',
                'managementOfficer' => $managementOfficer,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create Management Officer',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id, // Exclude current user's email
            'nic' => 'required|string|unique:users,nic,' . $id,    // Exclude current user's NIC
            'phone' => 'required|string',
            'address' => 'required|string',
            'password' => 'nullable|string|min:6',
        ]);

        $manager = User::findOrFail($id);

        // Update user fields
        $manager->name = $validatedData['name'];
        $manager->email = $validatedData['email'];
        $manager->nic = $validatedData['nic'];
        $manager->phone = $validatedData['phone'];
        $manager->address = $validatedData['address'];

        // Update password if provided
        if (!empty($validatedData['password'])) {
            $manager->password = bcrypt($validatedData['password']);
        }

        $manager->save();

        return response()->json(['message' => 'Management Officer updated successfully.']);
    }


    public function deactivate($id)
    {
        $manager = User::findOrFail($id);
        $manager->update(['status' => 0]);

        return response()->json(['message' => 'Management Officer deactivated successfully.']);
    }

    public function activate($id)
    {
        $manager = User::findOrFail($id);
        $manager->update(['status' => 1]);

        return response()->json(['message' => 'Management Officer activated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
