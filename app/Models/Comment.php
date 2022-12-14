<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'post_id',
        'title',
        'comment',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $withCount = ['likedUsers'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function likedUsers()
    {
        return $this->belongsToMany(User::class, 'comment_user_likes','comment_id','user_id');
    }
}
