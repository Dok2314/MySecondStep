<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role_id',
        'password',
        'banned'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeIsNotBanned(Builder $builder)
    {
        return $builder->whereNot('banned');
    }

    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_user_likes','user_id','post_id');
    }

    public function likedComments()
    {
        return $this->belongsToMany(Comment::class, 'comment_user_likes','user_id','comment_id');
    }

    public function isAdministrator()
    {
        return $this->role->id === 1;
    }

    public function isDeveloper()
    {
        return $this->role->id === 2;
    }

    public function isUser()
    {
        return $this->role->id === 3;
    }


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission($code)
    {
        return $this->role->permissions->contains(fn(Permission $permission) => $permission->code == $code);
    }
}
