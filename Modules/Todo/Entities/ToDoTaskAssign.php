<?php

namespace Modules\Todo\Entities;

use Illuminate\Database\Eloquent\Model;

class ToDoTaskAssign extends Model
{
    protected $fillable = [
        'to_do_task_id',
        'assigned_to',
        'about',
        'to_do_status_id',
        'company_id',
        'created_by',
        'updated_by',
        'status'
    ];

    /**
     * @auther job
     * @date 01-09-19
     * Get the user.
     */
    public function user() 
    {
        return $this->belongsTo('App\Models\user', 'assigned_to');
    }
}
