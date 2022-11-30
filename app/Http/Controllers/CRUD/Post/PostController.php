<?php

namespace App\Http\Controllers\CRUD\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PriceCalculateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $userPosts           = $user->posts()->withTrashed()->paginate(5);
        $countWithDeleted    = $user->posts()->onlyTrashed()->count();
        $countWithoutDeleted = $user->posts()->whereNull('deleted_at')->count();

        return view('CRUD.posts.index', compact('userPosts', 'countWithDeleted', 'countWithoutDeleted'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('CRUD.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        DB::beginTransaction();

        try {
            Post::create([
                'title' => $request->input('title'),
                'slug' => Str::slug($request->input('title')),
                'post' => $request->input('post'),
                'user_id' => Auth::user()->id
            ]);
        }catch(\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage())
                ->withInput();
        }

        DB::commit();

        return redirect()->route('posts.index')->with('success', 'Пост успешно добавлен!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        return view('CRUD.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('CRUD.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        DB::beginTransaction();

        try {
            $post->update([
                'title'     => $request->input('title'),
                'slug'      => Str::slug($request->input('title')),
                'post'      => $request->input('post'),
                'user_id'   => Auth::user()->id
            ]);
        }catch(\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', $e->getMessage())
                ->withInput();
        }

        DB::commit();

        return redirect()->route('posts.index')->with('success', 'Пост успешно обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         Post::find($id)->delete();

        return redirect()->route('posts.index')->with('success', 'Пост успешно удален!');
    }

    public function deleteFormHomePage($id)
    {
        $post = Post::find($id);

        $post->update([
            'is_admin_deleted' => 1
        ]);

        $post->delete();

        return redirect()->route('homePage')->with('success', 'Пост успешно удален!');
    }

    public function restore($id)
    {
        Post::withTrashed()
            ->find($id)
            ->restore();

        Post::find($id)
            ->update([
                'is_admin_deleted' => NULL
            ]);

        return redirect()->back()->with('success', 'Пост успешно востановлен!');
    }

    public function like(Post $post)
    {
        auth()->user()->likedPosts()->toggle($post->id);

        return redirect()->back();
    }

    public function userWhoAlsoLikePost(Post $post)
    {
        $users = $post->likedUsers;

        return $users;
    }
}
