<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'published')->paginate(10); 
        return view('posts.index', ['posts' => $posts]);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        if ($post->status != 'published' && $post->user != Auth::id()) {
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
            'publish_date' => 'nullable|date|after:now',
        ]);

        DB::beginTransaction();

        try {
            $post = new Post();
            $post->title = $request->title;
            $post->content = $request->content;
            $post->status = $request->status;
            $post->user_id = Auth::id();
            $post->created_by = Auth::id();

            if ($request->status == 'published') {
                $post->publish_date = now();
            } elseif ($request->status == 'scheduled') {
                $post->publish_date = $request->publish_date;
            } elseif ($request->status == 'draft') {
                $post->publish_date = now();
            }
            
            $post->save();

            DB::commit();

            return redirect()->route('posts.index')->with('success', 'Post created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving post: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An error occurred while saving the post: ' . $e->getMessage()]);
        }
    }

    public function edit(Post $post)
    {
        if ($post->user != Auth::id()) {
            abort(403);
        }
        return view('posts.edit', ['post' => $post]);
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id != Auth::id()) {
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
        if ($post->user != Auth::id()) {
            abort(403);
        }

        $post->delete();
        return redirect()->route('posts.index');
    }
}
