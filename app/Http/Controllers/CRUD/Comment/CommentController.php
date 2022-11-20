<?php

namespace App\Http\Controllers\CRUD\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $post     = Post::find($id);
        $comments = $post->comments()->orderBy('created_at', 'desc')->paginate(5);

        return view('CRUD.comments.create', compact('post', 'comments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        DB::beginTransaction();

        $postId = $request->input('post_id');

        try {
            Comment::create([
                'user_id'  => Auth::user()->id,
                'post_id'  => $postId,
                'title'    => $request->input('title'),
                'comment'  => $request->input('comment')
            ]);
        }catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
        DB::commit();

        return redirect()->route('commentToPost.create', $postId)->with('success', 'Комментарий успешно добавлен!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function like(Comment $comment)
    {
        auth()->user()->likedComments()->toggle($comment->id);

        return redirect()->back();
    }
}
