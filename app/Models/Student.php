<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Student extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'reg_no',
        'name',
        'call_no',
        'wtp_no',
        'batch_id',
        'school_id',
        'created_by',
        'email',
        'address',
        'status',
        'created_at',
        'profile_pic'
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }


    public function paidToThisMonth(): bool
    {
        return $this->payments()
            ->where('paid_month', now()->format('F'))
            ->where('paid_year', now()->format('Y'))
            ->exists();
    }

    public function paidToLastMonth(): bool
    {
        $lastMonth = now()->subMonth();
        return $this->payments()
            ->where('paid_month', $lastMonth->format('F'))
            ->where('paid_year', $lastMonth->format('Y'))
            ->exists();
    }

    public function paidToTwoMonthsAgo(): bool
    {
        $twoMonthsAgo = now()->subMonths(2);
        return $this->payments()
            ->where('paid_month', $twoMonthsAgo->format('F'))
            ->where('paid_year', $twoMonthsAgo->format('Y'))
            ->exists();
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function studentClasses()
    {
        return $this->hasMany(StudentClasses::class, 'student_id');
    }

    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'student_classes', 'student_id', 'class_id');
    }
}
