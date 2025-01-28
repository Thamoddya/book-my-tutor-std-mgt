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

    //Need to get count of schedules for today and future
    public function getScheduleCountAttribute()
    {
        return $this->schedules()->where('day', '>=', now()->format('Y-m-d'))->count();
    }

    public function schedules()
    {
        return $this->hasMany(ClassSchedule::class , 'class_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'class_id');
    }
}
