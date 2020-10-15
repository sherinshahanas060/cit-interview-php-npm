<?php

namespace Modules\Todo\Entities;

use Illuminate\Database\Eloquent\Model;

class ToDoTask extends Model
{
    protected $fillable = [
        'title',
        'about',
        'to_do_status_id',
        'company_id',
        'created_by',
        'updated_by',
        'completed', 
        'type',
        'priority_id',
        'status',
        'task_date'
    ];

    /**
     * @auther job
     * @date 01-09-19
     * Get the todo assigned users.
     */
    public function assigned() 
    {
        return $this->hasMany('Modules\Todo\Entities\ToDoTaskAssign', 'to_do_task_id')->where('status', 1);
    }

    public function assignToTask()
    {
        return $this->hasMany('Modules\Todo\Entities\ToDoTaskAssign', 'to_do_task_id', 'id');
    }

    /**
     * @auther job
     * @date 02-09-19
     * Get the todo status.
     */
    public function toDoStatus() 
    {
        return $this->belongsTo('Modules\Todo\Entities\ToDoStatusList', 'to_do_status_id');
    }
    /**
     * @auther job
     * @date 01-09-19
     * Get the user.
     */
    public function user() 
    {
        return $this->belongsTo('App\Models\user', 'created_by');
    }

    /**
     * @auther job
     * @date 01-09-19
     * Get the user.
     */
    public function priority()
    {
        return $this->belongsTo('Modules\Todo\Entities\Priority', 'priority_id');
    }
}
