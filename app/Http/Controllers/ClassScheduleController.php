<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClassScheduleRequest;
use App\Models\ClassSchedule;
use App\Models\Classes;
use Request;

class ClassScheduleController extends Controller
{
    public function index()
    {
        $classes = Classes::all();
        return view('class-schedule.index', compact('classes'));
    }

    public function loadSchedules(Request $request)
    {
        $schedules = ClassSchedule::with('class')->get();

        $data = $schedules->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'class_name' => $schedule->class->name ?? 'Unknown',
                'day' => \Carbon\Carbon::parse($schedule->day)->format('F j, Y'), // Format date
                'start_time' => \Carbon\Carbon::parse($schedule->start_time)->format('g:i A'), // Format time
                'end_time' => \Carbon\Carbon::parse($schedule->end_time)->format('g:i A'), // Format time
                'tutor' => $schedule->tutor,
                'mode' => ucfirst($schedule->mode),
                'link' => $schedule->link,
                'note' => $schedule->note,
            ];
        });

        return response()->json(['data' => $data]);
    }


    public function store(StoreClassScheduleRequest $request)
    {
        $data = $request->validated();

        ClassSchedule::create($data);

        return response()->json(['message' => 'Class schedule added successfully!']);
    }


    public function update(Request $request, $id)
    {
        $schedule = ClassSchedule::findOrFail($id);

        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'day' => 'required|date', // Validate as date
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'tutor' => 'required|string',
            'mode' => 'required|in:online,physical',
            'link' => 'nullable|string',
            'any_material_url' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        $schedule->update($request->all());

        return response()->json(['message' => 'Class schedule updated successfully!']);
    }

    public function destroy($id)
    {
        $schedule = ClassSchedule::findOrFail($id);
        $schedule->delete();

        return response()->json(['message' => 'Class schedule removed successfully!']);
    }
}
