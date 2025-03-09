<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'published')->get();
        return view('posts.index', ['posts' => $posts]);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        if ($post->status != 'published' && $post->author != Auth::id()) {
            abort(403);
        }
        return view('posts.show', ['post' => $post]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:60',
            'content' => 'required',
            'status' => 'required|in:draft,published,scheduled',
            'publish_at' => 'nullable|date|after:now',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->status = $request->status;
        $post->publish_at = $request->publish_at;
        $post->author = Auth::id();
        $post->save();

        return redirect()->route('posts.index');
    }

    public function edit(Post $post)
    {
        if ($post->author != Auth::id()) {
            abort(403);
        }
        return view('posts.edit', ['post' => $post]);
    }

    public function update(Request $request, Post $post)
    {
        if ($post->author != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:60',
            'content' => 'required',
            'status' => 'required|in:draft,published,scheduled',
            'publish_at' => 'nullable|date|after:now',
        ]);

        $post->title = $request->title;
        $post->content = $request->content;
        $post->status = $request->status;
        $post->publish_at = $request->publish_at;
        $post->save();

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        if ($post->author != Auth::id()) {
            abort(403);
        }

        $post->delete();
        return redirect()->route('posts.index');
    }
}
