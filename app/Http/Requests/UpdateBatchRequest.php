<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:batches,name,' . $this->batch->id . '|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The batch name is required.',
            'name.string' => 'The batch name must be a valid string.',
            'name.unique' => 'This batch name is already taken.',
            'name.max' => 'The batch name must not exceed 255 characters.',
        ];
    }
}
