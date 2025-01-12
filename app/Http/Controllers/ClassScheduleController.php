<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClassScheduleRequest;
use App\Http\Requests\UpdateClassScheduleRequest;
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

    public function show($id)
    {
        $schedule = ClassSchedule::findOrFail($id);
        return response()->json($schedule);
    }

    public function loadSchedules(Request $request)
    {
        $schedules = ClassSchedule::with('class')->get();

        $data = $schedules->map(function ($schedule) {
            return [
                'id' => $schedule->id,
                'class_name' => $schedule->class->name ?? 'Unknown',
                'day' => \Carbon\Carbon::parse($schedule->day)->format('F j, Y'),
                'start_time' => \Carbon\Carbon::parse($schedule->start_time)->format('g:i A'),
                'end_time' => \Carbon\Carbon::parse($schedule->end_time)->format('g:i A'),
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


    public function update(UpdateClassScheduleRequest $request, $id)
    {
        $schedule = ClassSchedule::findOrFail($id);

        $schedule->update($request->validated());

        return response()->json(['message' => 'Schedule updated successfully!']);
    }

    public function destroy($id)
    {
        $schedule = ClassSchedule::findOrFail($id);
        $schedule->delete();

        return response()->json(['message' => 'Class schedule removed successfully!']);
    }
}
