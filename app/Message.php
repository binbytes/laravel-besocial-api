<?php

namespace App;

use App\Events\MessageSent;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'body', 'user_id', 'type', 'is_seen'
    ];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['conversation'];

    protected $casts = [
        'is_seen' => 'boolean'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param $user
     *
     * @return mixed
     */
    public function unreadCount($user)
    {
        return Message::where('user_id', $user->id)
            ->where('is_seen', 0)
            ->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * @param \App\Conversation $conversation
     * @param $body
     * @param $userId
     * @param string $type
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function send(Conversation $conversation, $body, $userId, $type = 'text')
    {
        $message = $conversation->messages()->create([
            'body' => $body,
            'user_id' => $userId,
            'type' => $type,
        ]);

        event(new MessageSent($message));

        return $message;
    }
}
