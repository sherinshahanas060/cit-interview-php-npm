<?php

namespace Modules\Todo\Entities;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    protected $fillable = [
        'name',
        'color',
        'days',
        'hours',
        'company_id',
        'created_by',
        'updated_by',
        'status'
    ];
}
