<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikePost extends Model
{
    protected $fillable = [
        'user_id',  'post_id', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->hasOne(Post::class);
    }

}
