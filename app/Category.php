<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Post;

class Category extends Model
{
    protected $fillable = [
        'user_id', 
        'thumbnail', 
        'title', 
        'slug', 
        'is_published'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts() 
    {
        return $this->belongsToMany(Post::class, 'category_posts'); 
    }
}
