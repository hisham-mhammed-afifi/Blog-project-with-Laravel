<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Http\Requests\Posts\CreatePostsRequest;
use App\Http\Requests\Posts\UpdatePostsRequest;
use App\Post;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only('create', 'store', 'edit', 'update', 'destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index')
            ->with('posts', Post::searched()->orderBy('id', 'desc')->simplePaginate(3))
            ->with('categories', Category::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.form')
            ->with('categories', Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)
    {
        $image = $request->image->store('posts');
        Post::create([
            'image' => $image,
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $request->category,
            'user_id' => auth()->user()->id
        ]);
        session()->flash('success', 'Post Created Successfully');
        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trashed = Post::withTrashed()->where('id', $id)->firstOrFail();
        $post = Post::find($id);
        $comments = Comment::all();
        if ($post) {
            $category = $post->category;
        } else {
            $category = '';
        }
        return view('posts.show')
            ->with('post', $post)
            ->with('post', $trashed)
            ->with('comments', $comments)
            ->with('categories', Category::all())
            ->with('category', $category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.form')
            ->with('post', $post)
            ->with('categories', Category::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostsRequest $request, Post $post)
    {
        $data = $request->only('image', 'title', 'body', 'category_id');
        if ($request->hasFile('image')) {
            $image = $request->image->store('posts');
            $post->deleteImage();
            $data['image'] = $image;
        }
        $post->update($data);
        session()->flash('success', 'Post Updated Successfully');
        return redirect(route('posts.show', $post->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::withTrashed()
        ->where('id', $id)
        ->firstOrFail();
        if ($post->trashed()) {
            $post->deleteImage();
            $post->forceDelete();
        } else {
            $post->delete();
        }
        session()->flash('success', 'Post Deleted Successfully');
        return redirect(route('posts.index'));
    }

    /**
     * disolay the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $trashed = Post::onlyTrashed()->paginate(3);
        return view('posts.index')
            ->with('posts', $trashed)
            ->with('categories', Category::all());
    }

    /**
     * restore the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $post = Post::withTrashed()
                ->where('id', $id)
                ->firstOrFail();
        $post->restore();
        session()->flash('success', 'Post Restored Successfully');
        return redirect(route('posts.index'));
    }
}
