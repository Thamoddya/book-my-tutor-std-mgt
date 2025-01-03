<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClasses extends Model
{
    use HasFactory;

    protected $table = 'student_classes';

    protected $fillable = [
        'student_id',
        'class_id',
    ];

    // Belongs to Student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Belongs to Class
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
