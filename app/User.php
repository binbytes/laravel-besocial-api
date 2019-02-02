<?php

namespace App;

use App\Traits\CanFollow;
use App\Traits\CanLike;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens, CanLike, CanFollow;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * @return string
     */
    public function generateAccessToken()
    {
        return $this->createToken(config('app.name'))->accessToken;
    }

    /**
     * @return \Illuminate\Database\Eloquent\CgetRecentNotificationsollection|\Illuminate\Support\Collection
     */
    public function getRecentNotifications()
    {
        return $this->notifications()
                    ->take(5)
                    ->latest()
                    ->get();
    }
}
