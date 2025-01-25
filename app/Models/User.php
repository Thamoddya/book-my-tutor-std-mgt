<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'nic',
        'password',
        'phone',
        'address',
        'status',
        'profile_image'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    //get added student count
    public function getAddedStudentCount()
    {
        return Student::where('created_by', $this->id)->count();
    }

}
