<?php

namespace App\Listeners;

use App\Events\PostCommented;

class PostCommentedListener
{
    /**
     * Handle the event.
     *
     * @param PostCommented $event
     * @return void
     */
    public function handle(PostCommented $event)
    {
        $event->post->author->notify(new \App\Notifications\PostCommented($event->post, $event->user));
    }
}
