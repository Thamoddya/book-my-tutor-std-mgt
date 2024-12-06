<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Http\Requests\StoreBatchRequest;
use App\Http\Requests\UpdateBatchRequest;
use Illuminate\Http\JsonResponse;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batches = Batch::all();
        return response()->json([
            'batches' => $batches
        ]);
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
    public function store(StoreBatchRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $batch = Batch::create($data);
            return response()->json([
                'message' => 'Batch created successfully',
                'batch' => $batch
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Batch creation failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Batch $batch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Batch $batch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBatchRequest $request, Batch $batch): JsonResponse
    {
        $data = $request->validated();

        try {
            $batch->update($data);
            return response()->json([
                'message' => 'Batch updated successfully',
                'batch' => $batch
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Batch update failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Batch $batch)
    {
        //
    }

    public function deactivate($id)
    {
        try {
            // Find the batch by ID
            $batch = Batch::findOrFail($id);

            // Update status to 0
            $batch->status = 0;
            $batch->save();

            return response()->json([
                'message' => 'Batch deactivated successfully.',
                'batch' => $batch
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to deactivate batch.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function activate($id)
    {
        try {
            // Find the batch by ID
            $batch = Batch::findOrFail($id);

            // Update status to 1
            $batch->status = 1;
            $batch->save();

            return response()->json([
                'message' => 'Batch activated successfully.',
                'batch' => $batch
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to activate batch.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
