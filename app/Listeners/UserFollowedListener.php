<?php

namespace App\Listeners;

use App\Events\UserFollowed;

class UserFollowedListener
{
    /**
     * Handle the event.
     *
     * @param  UserFollowed  $event
     * @return void
     */
    public function handle(UserFollowed $event)
    {
        $event->user->notify(new \App\Notifications\UserFollowed($event->user));
    }
}
