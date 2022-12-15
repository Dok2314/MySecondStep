<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission','role_id','permission_id');
    }

    protected function name(): Attribute
    {
        $enValues = [
            'Администратор' => 'admin',
            'Разработчик' => 'developer',
            'Пользователь' => 'user',
        ];

        return Attribute::make(
            get: fn($value) => ucfirst($enValues[$value])
        );
    }
}
