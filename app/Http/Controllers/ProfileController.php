<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        if($request->hasFile('image')) {
            $avatar = $request->file('image');

            $filename = time() . '.' . $avatar->getClientOriginalExtension();

            Image::make($avatar)->resize(300, 300)->save(public_path('/storage/images/user/' . $filename));

            $user = Auth::user();
            $user->image = $filename;
            $user->save();
        }

        return view('profile.index', compact('user'));
    }
}
