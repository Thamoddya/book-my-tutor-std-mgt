<?php

namespace App\Http\Controllers;

use App\Http\Controllers\config\OneSignalController;
use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Student;
use App\Models\UserLog;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
    }


    public function store(StorePaymentRequest $request)
    {
        $student = Student::where('reg_no', $request->student_id)->first();

        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        DB::beginTransaction();

        try {
            $existingPayment = Payment::where('student_id', $student->id)
                ->where('paid_month', $request->paid_month)
                ->where('paid_year', $request->paid_year)
                ->first();

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
                'created_at' => $request->created_at,
                'class_id' => $request->class_id,
            ];

            if ($request->hasFile('receipt_picture')) {
                $file = $request->file('receipt_picture');
                $path = $file->store('receipts', 'public');
                $paymentData['receipt_picture'] = $path;
            }

            $payment = $existingPayment
                ? $existingPayment->update($paymentData)
                : Payment::create($paymentData);

            UserLog::create([
                'user_id' => Auth::id(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'action' => 'payment',
                'description' => 'Processed a payment for ' . $student->name,
                'route' => 'payments.store',
                'method' => $request->method(),
                'status_code' => $existingPayment ? 200 : 201,
                'response_time' => '0.01s',
                'response_message' => $existingPayment
                    ? 'Payment updated successfully'
                    : 'Payment created successfully',
            ]);

            DB::commit();

            return response()->json([
                'message' => $existingPayment
                    ? 'Payment updated successfully'
                    : 'Payment created successfully',
                'payment' => $payment,
            ], $existingPayment ? 200 : 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'An error occurred while processing the payment.',
                'details' => $e->getLine(),
            ], 500);
        }
    }


    public function show(Payment $payment)
    {
        if (Auth::id() !== $payment->processed_by) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }
        return response()->json([
            'payment' => $payment,
            'student' => $payment->student,
        ]);
    }

    public function destroy(Payment $payment)
    {
        if (Auth::id() !== $payment->processed_by) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }
        $payment->delete();

        return response()->json([
            'message' => 'Payment deleted successfully',
        ]);
    }

    public function viewReceipt($filename)
    {
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

    public function edit(Payment $payment)
    {
        return response()->json([
            'payment' => $payment,
        ]);
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:' . implode(',', Payment::paymentMethods()),
            'paid_month' => 'required|in:' . implode(',', Payment::months()),
            'paid_year' => 'required|in:' . implode(',', Payment::years()),
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:' . implode(',', Payment::statuses()),
            'created_at' => 'nullable|date', // Allow updating created_at
            'class_id' => 'required|exists:classes,id',
        ]);

        // Update the payment with the validated data
        $payment->update($validated);

        return response()->json([
            'message' => 'Payment updated successfully',
            'payment' => $payment,
        ]);
    }
}
