<?php

namespace App\Http\Controllers;

use App\Contracts\Posts\PostsFilter;
use Illuminate\Http\Request;
use App\Models\Post;

class BlogController extends Controller
{
    protected $filterService;

    public function __construct(PostsFilter $filterService)
    {
        $this->filterService = $filterService;
    }

    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:50'],
            'from_date' => ['nullable', 'string', 'date'],
            'to_date' => ['nullable', 'string', 'date', 'after:from_date'],
            'tag' => ['nullable', 'string', 'max:20'],
        ]);

        $posts = $this->filterService->getPosts($validated);

        return view('blog.index', compact('posts'));
    }


    public function show($post) 
    {
        $post = cache()->remember(
            key: "posts.{$post}", 
            ttl: now()->addHour(), 
            callback: function() use ($post) {
                return Post::query()->findOrFail($post);
            });

        
        if (is_Null($post)) {
            abort(404);
        } 
        return view('blog.show', compact('post'));
    }
}