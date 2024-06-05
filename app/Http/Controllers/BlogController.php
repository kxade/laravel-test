<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon as Carbon;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request) 
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:50'],
            'from_date' => ['nullable', 'string', 'date'],
            'to_date' => ['nullable', 'string', 'date', 'after:from_date'],
            'tag' => ['nullable', 'string', 'max:20'],
        ]);

        $query = Post::query();

        if ($fromDate = $validated['from_date'] ?? null) {
            $query->where('published_at', '>=', new Carbon($fromDate));
        }

        if ($toDate = $validated['to_date'] ?? null) {
            $query->where('published_at', '<=', new Carbon($toDate));
        }

        if ($search = $validated['search'] ?? null) {
            $query->where('title', 'ilike', "%{$search}%")
                ->orWhere('content', 'ilike', "%{$search}%");
        }

        if ($tag = $validated['tag'] ?? null) {
            $query->whereJsonContains('tags', $tag);
        }
        

        $posts = $query->where('published', true)
            ->whereNotNull('published_at')
            ->orderBy('id', 'asc')
            ->paginate(12, ['id', 'title', 'published_at']);
        
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