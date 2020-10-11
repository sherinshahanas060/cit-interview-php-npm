<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\AuthLog;
use Carbon\Carbon;
class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        // if($event->user->mobile_validated == 0) {
        //     return redirect()->back()->with('success', ['your message,here']); 
        // }
        $auth_logID = session('auth_logID');
        if($auth_logID != null){
            AuthLog::where('id', $auth_logID)
            ->update(array('user_id' => $event->user->id, 'failure_reason' => 'Success'));
        }  
        
        // AuthLog::get('user')
        
    }
    
}
