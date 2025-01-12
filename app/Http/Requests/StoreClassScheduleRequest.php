<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'class_id' => 'required|exists:classes,id',
            'day' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'tutor' => 'required|string',
            'mode' => 'required|in:online,physical',
            'link' => 'nullable|string',
            'any_material_url' => 'nullable|string',
            'note' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'class_id.required' => 'The class selection is required.',
            'day.required' => 'The date of the schedule is required.',
            'start_time.required' => 'The start time is required.',
            'end_time.required' => 'The end time is required.',
            'end_time.after' => 'The end time must be after the start time.',
        ];
    }
}
