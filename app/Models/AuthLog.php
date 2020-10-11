<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'login_ip',
        'mac_id',
        'address',
        'lat',
        'lon',
        'time_zone',
        'login_time',
        'logout_time',
        'device_information',
        'attempt_count',
        'failure_reason'
    ];
}
