<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 'published')
                     ->orderBy('updated_at', 'desc')
                     ->paginate(10); 
        return view('posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePostRequest $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();
            $data['created_by'] = Auth::id();

            if ($data['status'] == 'draft') {
                $data['publish_date'] = null;
            } elseif ($data['status'] == 'published') {
                $data['publish_date'] = now();
            } elseif ($data['status'] == 'scheduled') {
                $data['publish_date'] = $request->input('publish_date');
            }

            $post = Post::create($data);

            DB::commit();

            return redirect()->route('posts.show', $post)->with('success', 'Post created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating post: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An error occurred while creating the post: ' . $e->getMessage()]);
        }
    }

    public function edit(Post $post)
    {
        if ($post->user_id != Auth::id()) {
            abort(403);
        }
        return view('posts.edit', compact('post'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        if ($post->user_id != Auth::id()) {
            abort(403);
        }

        DB::beginTransaction();

        try {
            $data = $request->validated();
            $data['updated_by'] = Auth::id();
    
            if ($data['status'] == 'draft') {
                $data['publish_date'] = null;
            } elseif ($data['status'] == 'published') {
                $data['publish_date'] = now();
            } elseif ($data['status'] == 'scheduled') {
                $data['publish_date'] = $request->input('publish_date');
            }
    
            $post->update($data);
    
            DB::commit();
    
            return redirect()->route('home')->with('success', 'Post updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating post: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An error occurred while updating the post: ' . $e->getMessage()]);
        }
    }

    public function destroy(Post $post)
    {
        if ($post->user_id != Auth::id()) {
            abort(403);
        }

        DB::beginTransaction();

        try {
            $post->delete();

            DB::commit();

            return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting post: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An error occurred while deleting the post: ' . $e->getMessage()]);
        }
    }
}
