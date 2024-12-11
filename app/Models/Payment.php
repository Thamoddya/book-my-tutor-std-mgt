<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'payment_method',
        'amount',
        'student_id',
        'status',
        'paid_at',
        'paid_month',
        'paid_year',
        'receipt_picture',
        'processed_by',
    ];
    protected $dates = ['paid_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            $latestInvoice = Payment::latest('id')->first();
            $lastNumber = $latestInvoice ? (int)Str::after($latestInvoice->invoice_number, 'BMTIN') : 0;

            $payment->invoice_number = 'BMTIN' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        });
    }

    // Enum options for payment_method
    public static function paymentMethods()
    {
        return ['online', 'cash', 'wp_receipt'];
    }

    // Enum options for status
    public static function statuses()
    {
        return ['pending', 'paid', 'due'];
    }


    // Enum options for paid_month
    public static function months()
    {
        return [
            'january', 'february', 'march', 'april', 'may', 'june',
            'july', 'august', 'september', 'october', 'november', 'december'
        ];
    }

    // Enum options for paid_year
    public static function years()
    {
        return ['2024', '2025', '2026', '2027', '2028', '2029', '2030'];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getProcessedUser()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public static function getNowMonthTotal()
    {
        return Payment::where('paid_month', now()->format('F'))
            ->where('status', 'paid')
            ->sum('amount');
    }

    public static function getNowYearTotal()
    {
        return Payment::where('paid_year', now()->format('Y'))
            ->where('status', 'paid')
            ->sum('amount');
    }

    public static function getTotalPaymentsTotalInThisMonth()
    {
        return Payment::where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');  // Sum the 'amount' field
    }

}
