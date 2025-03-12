<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Auth::check() ? Post::where('user_id', Auth::id())->orderBy('updated_at', 'desc')->paginate(10) : [];
        return view('home', compact('posts'));
    }
}
