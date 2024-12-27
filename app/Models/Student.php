<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

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
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function paidToThisMonth(): bool
    {
        return $this->hasMany(Payment::class)
            ->whereMonth('created_at', now()->month)
            ->exists();
    }

    public function paidToLastMonth(): bool
    {
        return $this->hasMany(Payment::class)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->exists();
    }

    public function paidToTwoMonthsAgo(): bool
    {
        return $this->hasMany(Payment::class)
            ->whereMonth('created_at', now()->subMonths(2)->month)
            ->exists();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
