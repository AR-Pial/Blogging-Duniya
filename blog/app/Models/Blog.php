<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Blog extends Model
{
    use HasFactory, HasUuids;
    public $timestamps = true;
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'blog_id');
    }
    public function likes()
    {
        return $this->belongsToMany(User::class, 'blog_likes', 'blog_id', 'user_id');
    }
    public function totalLikes()
    {
        return $this->likes()->count();
    }
    public function totalComments()
    {
        return $this->comments()->count();
    }

}
