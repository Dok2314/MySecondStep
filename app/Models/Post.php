<?php

namespace App\Models;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'slug',
        'title',
        'post',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'is_admin_deleted'
    ];

    protected $withCount = [
        'likedUsers',
        'comments'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $builder, QueryFilter $filter)
    {
        return $filter->apply($builder);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likedUsers()
    {
        return $this->belongsToMany(User::class, 'post_user_likes','post_id','user_id');
    }

    protected function title(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ucfirst($value) . ' |author: ' . auth()->user()->name
        );
    }
}
