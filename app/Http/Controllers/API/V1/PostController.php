<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Enums\PostSource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PostResource::collection(Post::all()); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'content' => ['required', 'string', 'max:1000'],
            'published_at' => ['nullable', 'date'],
            'published' => ['nullable', 'boolean'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        if (empty($fields['published_at'])) {
            $fields['published_at'] = now();
        }

        $fields['source'] = PostSource::Api;

        $post = Auth::user()->posts()->create($fields);

        return response()->json([
            'message' => 'Post created successfully!',
            'post' => $post
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $post)
    {
        return new PostResource(Post::findOrFail($post));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, Post $post)
    {
        $post->update($request->validated());

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $post)
    {
        Post::findOrFail($post)->delete();
    }
}
