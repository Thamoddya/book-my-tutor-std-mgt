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
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
