<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'created_by'
    ];

    /**
     * Conversation of user or auth user
     *
     * @param $query
     * @param null $userId
     * @return mixed
     */
    public function scopeForUser($query, $userId = null)
    {
        if(!$userId) $userId = auth()->id();

        return $query->whereHas('users', function ($query) use($userId) {
            $query->where('id', $userId);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'conversation_user')
                    ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id')
                    ->with('sender');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastMessage()
    {
        return $this->hasOne(Message::class)
                    ->orderBy('messages.id', 'desc')
                    ->with('sender');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function unreadMessage()
    {
        return $this->hasMany(Message::class)
            ->where('is_seen', false)
            ->where('user_id', '<>', auth()->id());
    }

    /**
     * @param int $participant
     *
     * @return mixed
     */
    public static function firstConversion($participant)
    {
        return self::whereHas('users', function ($query) use ($participant) {
            $query->whereIn('id', [
                auth()->id(),
                $participant
            ]);
        })->first();
    }


    /**
     * @param int $participant
     *
     * @return mixed
     */
    public static function firstOrStart($participant)
    {
        if ($conversation = self::firstConversion($participant)) {
            return $conversation;
        }

        return self::start([
            auth()->id(),
            $participant
        ]);
    }

    /**
     * @param array $participants
     *
     * @return mixed
     */
    public static function start($participants)
    {
        $conversation = self::create([
            'created_by' => auth()->id()
        ]);

        if ($participants) {
            $conversation->addParticipants($participants);
        }

        return $conversation;
    }

    /**
     * @param $userIds
     *
     * @return $this
     */
    public function addParticipants($userIds)
    {
        $this->users()->attach(is_array($userIds) ? $userIds : [$userIds]);

        return $this;
    }
}
