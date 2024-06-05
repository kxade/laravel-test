<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class PostController extends Controller
{
    public function index() 
    {
        $posts = Post::query()->paginate(12);

        return view('user.posts.index', compact('posts'));
    }

    public function create() 
    {
        return view('user.posts.create');
    }

    public function store(StorePostRequest $request) 
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'content' => ['required', 'string', 'max:1000'],
            'published_at' => ['nullable', 'string', 'date'],
            'published' => ['nullable', 'boolean'],
        ]);
        
        $post = Post::query()->create([
            'user_id' => User::query()->value('id'),
            'category_id' => 1,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'published_at' => new Carbon($validated['published_at'] ?? null),
            'published' => $validated['published'] ?? false,
        ]);

        return redirect()->route('user.posts.show', 1);
    }

    public function show($post_id) 
    {
        $post = Post::query()->findOrFail($post_id);

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
}
