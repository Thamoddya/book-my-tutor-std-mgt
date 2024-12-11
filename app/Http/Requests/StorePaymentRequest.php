<?php

namespace App\Http\Requests;

use App\Models\Payment;
use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method' => 'required|in:' . implode(',', Payment::paymentMethods()),
            'payment_status' => 'required|in:' . implode(',', Payment::statuses()),
            'paid_month' => 'required|in:' . implode(',', Payment::months()),
            'paid_year' => 'required|in:' . implode(',', Payment::years()),
            'amount' => 'required|integer|min:0',
            'student_id' => 'required|exists:students,reg_no',
            'receipt_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method.required' => 'The payment method is required.',
            'payment_method.in' => 'Invalid payment method selected.',
            'payment_status.required' => 'The status is required.',
            'payment_status.in' => 'Invalid status selected.',
            'paid_month.required' => 'The paid month is required.',
            'paid_month.in' => 'Invalid paid month selected.',
            'paid_year.required' => 'The paid year is required.',
            'paid_year.in' => 'Invalid paid year selected.',
            'amount.required' => 'The amount is required.',
            'amount.integer' => 'The amount must be a valid number.',
            'student_id.required' => 'The student registration number is required.',
            'student_id.exists' => 'The student registration number does not exist.',
            'receipt_picture.image' => 'The receipt must be an image.',
            'receipt_picture.mimes' => 'The receipt must be a JPEG, PNG, JPG, or GIF file.',
            'receipt_picture.max' => 'The receipt must not exceed 2MB.',
        ];
    }
}
