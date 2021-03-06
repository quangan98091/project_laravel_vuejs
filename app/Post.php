<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = [
        'user_id', 
        'thumbnail', 
        'title', 
        'slug', 
        'sub_title', 
        'details', 
        'post_type',
        'is_published',
        'view_post',
        'view_like',
        'view_share',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_posts');
    }

    public function likePost()
    {
        return $this->hasOne(LikePost::class);
    }

    // public function comments()
    // {
    //     return $this->hasMany('App\Comment');
    // }
}
