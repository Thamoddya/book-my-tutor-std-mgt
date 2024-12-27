<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'call_no' => 'required|digits:10|unique:students,call_no',
            'wtp_no' => 'required|digits:10',
            'school_id' => 'required|exists:schools,id',
            'batch_id' => 'sometimes|nullable|exists:batches,id',
            'email' => 'sometimes|nullable|email|unique:students,email',
            'address' => 'sometimes|nullable|string|max:255',
            'created_at' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Full Name is required.',
            'call_no.required' => 'Call No is required.',
            'call_no.digits' => 'Call No must be 10 digits.',
            'call_no.unique' => 'Call No already exists.',
            'wtp_no.required' => 'WhatsApp No is required.',
            'wtp_no.digits' => 'WhatsApp No must be 10 digits.',
            'school_id.required' => 'School selection is required.',
            'school_id.exists' => 'The selected school is invalid.',
            'batch_id.required' => 'Batch selection is required.',
            'batch_id.exists' => 'The selected batch is invalid.',
            'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
            'email.unique' => 'Email already exists.',
            'address.required' => 'Address is required.',
        ];
    }
}
