<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index() 
    {

        $posts = Auth::user()->posts()->latest()->paginate(6);

        return view('user.posts.index', compact('posts'));
    }

    public function create() 
    {
        return view('user.posts.create');
    }

    public function store(Request $request) 
    {

        $fields = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'content' => ['required', 'string', 'max:1000'],
            'published_at' => ['nullable', 'string', 'date'],
            'published' => ['nullable', 'boolean'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        if (empty($fields['published_at'])) {
            $fields['published_at'] = now();
        }
        
        $post = Auth::user()->posts()->create($fields);

        session()->flash('success', 'Post created successfully!');

        return redirect()->route('user.posts.show', $post);
    }

    public function show($post) 
    {
        $post = Post::query()->findOrFail($post);

        return view('user.posts.show', compact('post'));
    }

    public function edit($post_id) 
    {
        $post = Post::query()->findOrFail($post_id);
        
        return view('user.posts.edit', compact('post'));
    }

    public function update(Request $request, $post) 
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'content' => ['required', 'string', 'max:1000'],
            'published_at' => ['nullable', 'string', 'date'],
            'published' => ['nullable', 'boolean'],
        ]);

        return redirect()->back();
    }

    public function destroy($post) 
    {
        return redirect()->route('user.posts');
    }

    public function usernamePosts(User $username)
    {
        $userPosts = $username->posts()->latest()->paginate(6);
        return view('user.posts.username', [
            'posts' => $userPosts,
            'user' => $username
        ]);
    }
}
