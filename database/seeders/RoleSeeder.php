<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        tap(Role::create([
            'name' => 'Администратор'
        ]));

        tap(Role::create([
            'name' => 'Разработчик'
        ]), function (Role $role) {
            $role->permissions()->syncWithoutDetaching(Permission::whereIn('code', [
                'post create',
                'post read',
                'post destroy',
                'post edit',
                'post restore',
                'user read'
            ])->get());
        });

        tap(Role::create([
            'name' => 'Пользователь'
        ]), function (Role $role) {
            $role->permissions()->sync(Permission::whereIn('code', [
                'post create',
                'post read',
                'post edit',
                'user read'
            ])->get());
        });
    }
}
