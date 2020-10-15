<?php

namespace Modules\Todo\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class ToDoTaskCompleted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @author Job
     * @date 31-08-19
     * Create a new event instance.
     *
     * @return void
     */
    
    public $toDoTask;
    public function __construct($toDoTask)
    {
        $this->toDoTask = $toDoTask;
    }

    /**
     * @author Job
     * @date 31-08-19
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return new Channel('toDoTaskCompleted');
    }

    public function broadcastAs()
    {
        return 'todo-task-completed';
    }
}
