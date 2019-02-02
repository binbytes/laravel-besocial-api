<?php

namespace App\Providers;

use App\Events\PostCommented;
use App\Events\PostLiked;
use App\Events\UserFollowed;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PostLiked::class => [
            \App\Listeners\PostLikedListener::class
        ],
        PostCommented::class => [
            \App\Listeners\PostCommentedListener::class
        ],
        UserFollowed::class => [
            \App\Listeners\UserFollowedListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
