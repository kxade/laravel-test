<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Enums\PostSource;
use App\Services\Posts\PostService;
use App\Http\Requests\Api\PostStoreRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        return PostResource::collection(Post::all()); 
    }

    public function store(PostStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $post = $this->postService->store($data, PostSource::Api);
            return response()->json([
                'message' => 'Post created successfully!',
                'post' => PostResource::make($post)
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    public function show(string $post)
    {
        return new PostResource(Post::findOrFail($post));
    }

    public function update(PostStoreRequest $request, Post $post)
    {
        $data = $request->validated();

        // Authorizing the action
        if (Auth::user()->cannot('modify', $post)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        try {
            $updatedPost = $this->postService->update($data, $post);
            return response()->json([
                'message' => 'Post updated successfully!',
                'post' => PostResource::make($updatedPost)
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }

    public function destroy(string $post)
    {
        Gate::authorize('modify', $post);

        Post::findOrFail($post)->delete();
    }
}
