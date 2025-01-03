<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'description',
        'teacher',
        'code'
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_classes', 'class_id', 'student_id');
    }
}
