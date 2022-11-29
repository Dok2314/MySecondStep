<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'Создавать пост',
            'code' => 'post create'
        ]);

        Permission::create([
            'name' => 'Удалять пост',
            'code' => 'post destroy'
        ]);

        Permission::create([
            'name' => 'Редактировать пост',
            'code' => 'post edit'
        ]);

        Permission::create([
            'name' => 'Восстанавливать пост',
            'code' => 'post restore'
        ]);

        Permission::create([
            'name' => 'Читать пост',
            'code' => 'post read'
        ]);

        Permission::create([
            'name' => 'Создавать пользователя',
            'code' => 'user create'
        ]);

        Permission::create([
            'name' => 'Удалять пользователя',
            'code' => 'user destroy'
        ]);

        Permission::create([
            'name' => 'Редактировать пользователя',
            'code' => 'user edit'
        ]);

        Permission::create([
            'name' => 'Восстанавливать пользователя',
            'code' => 'user restore'
        ]);

        Permission::create([
            'name' => 'Читать пользователя',
            'code' => 'user read'
        ]);
    }
}
