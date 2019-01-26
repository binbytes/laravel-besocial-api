<?php

namespace App\Notifications;

use App\Post;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class PostLiked extends Notification implements ShouldQueue
{
    use Queueable, Broadcaster, SerializesModels;

    /**
     * @var \App\Post
     */
    public $post;

    /**
     * @var \App\User
     */
    public $user;

    /**
     * Create a new notification instance.
     *
     * @param \App\Post $post
     * @param \App\User $user
     */
    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [

        ];
    }
}
