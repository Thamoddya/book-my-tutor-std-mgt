<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'action',
        'description',
        'route',
        'method',
        'status_code',
        'response',
        'response_time',
        'response_size',
        'response_message'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
