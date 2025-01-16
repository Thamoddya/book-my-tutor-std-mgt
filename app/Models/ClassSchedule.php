<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'day',
        'start_time',
        'end_time',
        'tutor',
        'mode',
        'link',
        'any_material_url',
        'note',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

}
