<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(request()->hasHeader('Authorization')) {
            Broadcast::routes([
                'prefix' => 'api',
                'middleware' => ['api', 'auth:api']
            ]);
        } else {
            Broadcast::routes();
        }

        require base_path('routes/channels.php');
    }
}
