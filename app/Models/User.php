<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\Blog;
use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Contracts\Auth\Authenticatable;

class User extends Model implements Authenticatable
{
    use HasFactory,AuthAuthenticatable;

    protected $guarded = [];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function ratingBlog()
    {
        return $this->hasMany(RatingBlog::class);
    }
    // public function ratingBlog()
    // {
    //     return $this->belongsTo(RatingBlog::class);
    // }
}
