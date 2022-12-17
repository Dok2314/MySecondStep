<?php

namespace App\Http\Controllers;

use App\Filters\PostFilter;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    public function home(PostFilter $filter)
    {
        $posts    = Post::filter($filter)->orderBy('id', 'desc')->paginate(5);
        $users    = User::all();

        return view('home', compact('posts', 'users'));
    }

    public function search(Request $request)
    {
        $output = '';

        $posts = Post::where('title', 'like', '%' . $request->search .'%')
            ->orWhereHas('user', function ($query) use($request) {
                $query->where('name', $request->search);
            })
            ->orWhere('post', 'like', '%' . $request->search .'%')
            ->orderBy('id', 'desc')
            ->paginate(5);

        foreach ($posts as $post) {
            $userName = $post->user->name;

            $commentsCount = $post->comments->count();

            $output .= "
                <tr>
                    <td>$post->id</td>
                    <td>$post->title</td>
                    <td>$post->post</td>
                    <td>$userName</td>
                    <td>$post->created_at</td>
                    <td>
                        <button
                            id='show-users'
                            data-url='user/$post->id/likes'
                            type='button' class='border-0 bg-transparent' data-bs-toggle='modal' data-bs-target='#exampleModal'>
                            $post->liked_users_count
                        </button>
                        <button class='border-0 bg-transparent'>
                           <i class='fa-solid fa-heart' style='color: black '></i>
                        </button>
                    </td>
                    <td>
                        <a href='/posts/$post->id/comments/create' style='text-decoration: none;'>
                            <span>
                            <i class='fa-solid fa-comment offset-3'></i>
                            $commentsCount
                            </span>
                        </a>
                    </td>
                </tr>
            ";
        }

        return response($output);
    }

    public function changeLocale($locale)
    {
        session(['locale' => $locale]);
        App::setLocale($locale);

        return redirect()->back();
    }
}
