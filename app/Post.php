<?php

namespace App;

use App\Traits\CanLike;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use CanLike;

    /**
     * @var array
     */
    protected $fillable = [
        'text',
    ];

    /**
     * @var array
     */
    protected $withCount = [
        'comments'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
