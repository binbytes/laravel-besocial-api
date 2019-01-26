<?php

namespace App\Listeners;

use App\Events\PostLiked;

class PostLikedListener
{
    /**
     * Handle the event.
     *
     * @param  PostLiked  $event
     * @return void
     */
    public function handle(PostLiked $event)
    {
        $event->post->author->notify(new \App\Notifications\PostLiked($event->post, $event->user));
    }
}
