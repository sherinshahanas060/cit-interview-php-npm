<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $guard_name = 'api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name', 
        'email', 
        'password',
        'email_validated',
        'verification_code',
        'subscription',
        'mobile_validated',
        'user_score',
        'is_user',
        'employee_id',
        'is_delegate',
        'is_employee',
        'status',
        'user_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    public function userBaseFormat()
    {
        return [
            'user_id' => $this->id,
            'name' => $this->name,
            'profile_image' => $this->image->profile_image,
        ];
    }

    /**
     * @author 
     * @date 
     * Get user datails.
     */
    public function userDetails()
    {
        return $this->hasOne('App\Models\UserDetail', 'user_id');
    }

    public function image() 
    {
        return $this->hasOne('App\Models\UserDetail', 'user_id')->select('id', 'user_id', 'profile_image');
    }
}
