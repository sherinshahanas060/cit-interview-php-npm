<?php

namespace Modules\Todo\Entities;

use Illuminate\Database\Eloquent\Model;

class ToDoStatusList extends Model
{
    protected $fillable = [
        'name',
        'company_id',
        'created_by',
        'updated_by',
        'status'
    ];
}
