<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClassScheduleRequest extends FormRequest
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
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'tutor' => 'required|string',
            'mode' => 'required|in:online,physical',
            'link' => 'nullable|string',
            'any_material_url' => 'nullable|string',
            'note' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'class_id.required' => 'The class is required.',
            'class_id.exists' => 'The selected class does not exist.',
            'day.required' => 'The date is required.',
            'day.date' => 'The date must be a valid date.',
            'start_time.required' => 'The start time is required.',
            'end_time.required' => 'The end time is required.',
            'end_time.after' => 'The end time must be after the start time.',
            'tutor.required' => 'The tutor name is required.',
            'tutor.max' => 'The tutor name must not exceed 255 characters.',
            'mode.required' => 'The mode is required.',
            'mode.in' => 'The mode must be either online or physical.',
            'link.max' => 'The link must not exceed 255 characters.',
            'any_material_url.max' => 'The material URL must not exceed 255 characters.',
        ];
    }
}
