<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class StudentLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'call_no' => 'required|string',
            'reg_no' => 'required|string',
        ];
    }
}