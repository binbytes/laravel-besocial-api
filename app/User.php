<?php

namespace App;

use App\Traits\CanLike;
use App\Traits\CanFollow;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\MediaLibrary\Models\Media;

class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    use Notifiable, HasApiTokens, CanLike, CanFollow, HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'avatar',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'avatar',
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

    /**
     * @return string|null
     */
    public function getAvatarAttribute()
    {
        return (count($this->getMedia('avatar')) > 0)
            ? $this->getMedia('avatar')->first()->getFullUrl('thumb') : null;
    }

    /**
     * @param Media|null $media
     * @throws \Spatie\Image\Exceptions\InvalidManipulation
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->fit(Manipulations::FIT_CONTAIN, 100, 100);
    }
}
