<?php

namespace Modules\Todo\Entities;

use Illuminate\Database\Eloquent\Model;

class ToDoTaskAction extends Model
{
    protected $fillable = [
        'to_do_task_id',
        'action',
        'comment',
        'company_id',
        'created_by',
        'updated_by',
        'status'
    ];
}
