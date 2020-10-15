<?php

namespace Modules\Todo\Entities;

use Illuminate\Database\Eloquent\Model;

class toDoCounter extends Model
{
    protected $table = 'to_do_counter';

    protected $fillable = [
        'user_id',
        'count'
    ];

    /**
     * @auther Iqbal
     * @date 26-10-19
     * Get the user.
     */

    public function user()
    {
        return $this->belongsTo('App\Models\user', 'id', 'user_id');
    }
    
}
