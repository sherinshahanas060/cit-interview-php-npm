<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'email',
        'employee_id_number', 
        'join_date',
        'user_status',
        'title',
        'first_name',
        'middle_name',
        'second_name',
        'gender',
        'city',
        'speciality_id',
        'work_place',
        'date_of_birth',
        'mobile_number',
        'nationality',
        'department',
        'profession',
        'profile_image',
        'status'
    ];
}
