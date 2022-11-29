<?php

namespace App\Http\Controllers\CRUD\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Image;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(5);

        return view('CRUD.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('CRUD.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('CRUD.users.edit', compact('user', 'roles'));
    }

    public function update(User $user, UserUpdateRequest $request)
    {
        $user->fill($request->validated());

        if($request->has('new_profile_image')) {
            $avatar = $request->file('new_profile_image');

            $filename = time() . '.' . $avatar->getClientOriginalExtension();

            Image::make($avatar)->resize(300, 300)->save(public_path('/storage/images/user/' . $filename));

            $user = Auth::user();
            $user->image = $filename;
        }

        if(isset($request->new_pass))
        {
            $user->password = Hash::make($request->new_pass);
        }

        if($user->role->id != $request->role) {
            $user->role_id = $request->role;
        }

        $user->update();

        return redirect()->route('user.edit', $user)->with('success', 'Пользователь успешно изменён!');
    }
}
