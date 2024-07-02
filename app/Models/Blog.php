<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'cover_image_url',
        'user_id',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getBlogById($id)
    {
        $blog = Blog::where('id', $id)->first();
        if($blog){
            return $blog;
        }
        return null;
    }

    public function getBlogs()
    {
        $blogs = Blog::all();
        if($blogs){
            return $blogs;
        }
        return null;
    }

    public function getBlogsByUserId($userId)
    {
        $blogs = Blog::where('user_id', $userId)->get();
        if($blogs){
            return $blogs;
        }
        return null;
    }

    public function getBlogsByTitle($title)
    {
        $blogs = Blog::where('title', 'like', "%$title%")->get();
        if($blogs){
            return $blogs;
        }
        return null;
    }
}
