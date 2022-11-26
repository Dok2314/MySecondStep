<?php

namespace App\Http\Controllers;

use App\Filters\PostFilter;
use App\Models\Post;
use App\Models\User;

class HomeController extends Controller
{
    public function home(PostFilter $filter)
    {
        dd('test');
        $posts    = Post::filter($filter)->paginate(5);
        $users    = User::all();

        return view('home', compact('posts', 'users'));
    }
}
