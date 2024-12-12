<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StorePaymentRequest $request)
    {
        // Find student by registration number
        $student = Student::where('reg_no', $request->student_id)->first();

        // If student not found, return an error
        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        // Check if a payment record exists for this student with the same month and year
        $existingPayment = Payment::where('student_id', $student->id)
            ->where('paid_month', $request->paid_month)
            ->where('paid_year', $request->paid_year)
            ->first();

        // If a record exists, update it, otherwise create a new one
        $paymentData = [
            'invoice_number' => 'BMTIN' . str_pad(Payment::count() + 1, 6, '0', STR_PAD_LEFT),
            'payment_method' => $request->payment_method,
            'amount' => $request->amount,
            'student_id' => $student->id,
            'status' => $request->payment_status,
            'paid_at' => now(),
            'paid_month' => $request->paid_month,
            'paid_year' => $request->paid_year,
            'processed_by' => Auth::id(),
        ];

        // Handle receipt picture
        if ($request->hasFile('receipt_picture')) {
            $file = $request->file('receipt_picture');
            $path = $file->store('receipts', 'public');
            $paymentData['receipt_picture'] = $path;
        }

        // If payment exists, update the record, else create a new one
        if ($existingPayment) {
            // Update the existing record
            $existingPayment->update($paymentData);
            return response()->json([
                'message' => 'Payment updated successfully',
                'payment' => $existingPayment,
            ], 200);
        } else {
            // Create a new payment record
            $payment = Payment::create($paymentData);
            return response()->json([
                'message' => 'Payment created successfully',
                'payment' => $payment,
            ], 201);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        // Check if the user is authorized to view the payment
        if (Auth::id() !== $payment->processed_by) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }

        // Return the payment record with the student details
        return response()->json([
            'payment' => $payment,
            'student' => $payment->student,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }

    public function viewReceipt($filename)
    {
        // Check if the user is authorized to view the receipt
        $payment = Payment::where('receipt_picture', 'receipts/' . $filename)->first();

        if (!$payment || Auth::id() !== $payment->processed_by) {
            abort(403, 'Unauthorized access');
        }

        // Serve the file securely
        $path = storage_path('app/secure/receipts/' . $filename);

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        return response()->file($path);
    }
}
