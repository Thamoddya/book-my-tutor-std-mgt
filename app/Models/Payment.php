<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getAmountAttribute($value)
    {
        return number_format($value, 2);
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = str_replace(',', '', $value);
    }

    public function getReceiptPictureAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }

    public function getPaymentMethodAttribute($value)
    {
        return ucfirst($value);
    }

    public function getStatusAttribute($value)
    {
        return ucfirst($value);
    }

    public function getPaidAtAttribute($value)
    {
        return $value ? date('F d, Y h:i A', strtotime($value)) : null;
    }

    public function getCreatedAtAttribute($value)
    {
        return date('F d, Y h:i A', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('F d, Y h:i A', strtotime($value));
    }

    public function getDueAmountAttribute()
    {
        return $this->amount - $this->student->payments->where('status', 'paid')->sum('amount');
    }
}
