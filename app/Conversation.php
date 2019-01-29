<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'created_by'
    ];

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
    public function last_message()
    {
        return $this->hasOne(Message::class)
                    ->orderBy('messages.id', 'desc')
                    ->with('sender');
    }

    /**
     * @param $participants
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
