<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'chat_room_id',	'user_id',	'message'
    ];

    public function room()
    {
        return $this->hasOne(ChatRoom::class,'id', 'chat_room_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
