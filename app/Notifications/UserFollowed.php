<?php

namespace App\Notifications;

use App\Http\Resources\PostUserResource;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class UserFollowed extends Notification implements ShouldQueue
{
    use Queueable, Broadcaster, SerializesModels;

    /**
     * @var \App\User
     */
    public $user;

    /**
     * Create a new notification instance.
     *
     * @param \App\User $user
     */
    public function __construct(User $user)
    {
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
            'id' => $this->user->getKey(),
            'FollowedCount' => $this->user->followers()->count(),
            'FollowedBy' => new PostUserResource(auth()->user())
        ];
    }
}
