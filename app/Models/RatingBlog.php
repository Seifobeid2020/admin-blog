<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Blog;

class RatingBlog extends Model
{
    use HasFactory;

    protected $guarded = [];


    // public function blogs()
    // {
    //     return $this->hasMany(Blog::class);
    // }
    // public function users()
    // {
    //     return $this->hasMany(User::class);
    // }

    public function blogs()
    {
        return $this->belongsTo(Blog::class, 'blog_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
