<?php

namespace App\Traits;

use App\Follow;

trait CanFollow
{
    /**
     * Like an item or items.
     *
     * @param int|array|\Illuminate\Database\Eloquent\Model $targets
     * @param string                                        $class
     *
     * @throws \Exception
     *
     * @return array
     */
    public function follow($targets, $class = __CLASS__)
    {
        return Follow::attachRelations($this, 'followings', $targets, $class);
    }

    /**
     * Unlike an item or items.
     *
     * @param int|array|\Illuminate\Database\Eloquent\Model $targets
     * @param string                                        $class
     *
     * @return array
     */
    public function unfollow($targets, $class = __CLASS__)
    {
        return Follow::detachRelations($this, 'followings', $targets, $class);
    }

    /**
     * Toggle like an item or items.
     *
     * @param int|array|\Illuminate\Database\Eloquent\Model $targets
     * @param string                                        $class
     *
     * @throws \Exception
     *
     * @return array
     */
    public function toggleFollow($targets, $class = __CLASS__)
    {
        return Follow::toggleRelations($this, 'followings', $targets, $class);
    }

    /**
     * Check if user is liked given item.
     *
     * @param int|array|\Illuminate\Database\Eloquent\Model $target
     * @param string                                        $class
     *
     * @return bool
     */
    public function isFollowing($target, $class = __CLASS__)
    {
        return Follow::isRelationExists($this, 'followings', $target, $class);
    }

    /**
     * Return item likes.
     *
     * @param string $class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followings($class = __CLASS__)
    {
        return $this->morphedByMany($class, 'followable', 'followables')
            ->wherePivot('relation', '=', Follow::RELATION_FOLLOW)
            ->withPivot('followable_type', 'relation', 'created_at');
    }

    /**
     * Return item likes.
     *
     * @param string $class
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers($class = __CLASS__)
    {
        return $this->morphedByMany($class, 'followable', 'followables', 'followable_id')
            ->wherePivot('relation', '=', Follow::RELATION_FOLLOW)
            ->withPivot('followable_type', 'relation', 'created_at');
    }
}
