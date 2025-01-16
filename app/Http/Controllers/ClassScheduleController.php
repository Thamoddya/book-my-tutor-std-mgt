<?php

namespace App\Http\Controllers;

use App\Http\Controllers\config\OneSignalController;
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


    public function store(StoreClassScheduleRequest $request, OneSignalController $oneSignalController)
    {
        $data = $request->validated();

        // Create the class schedule
        $classSchedule = ClassSchedule::create($data);

        // Fetch students in the related class
        $students = $classSchedule->class->students;

        // Extract registration IDs (reg_no) of students
        $studentRegIds = $students->pluck('reg_no')->toArray();

        // Message to notify students
        $message = "A new class schedule has been added for your class: {$classSchedule->class->name} on {$classSchedule->day} from {$classSchedule->start_time } to {$classSchedule->end_time}.";

        // Use the injected OneSignalController to send notifications
        $oneSignalController->sendNotificationBulk($studentRegIds, $message);

        return response()->json(['message' => 'Class schedule added successfully, and students notified!']);
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
