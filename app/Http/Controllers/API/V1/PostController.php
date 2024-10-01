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
        $data = $request->validate();

        try {
            $post = $this->postService->store($data, PostSource::Api);
            return response()->json([
                'message' => 'Post created successfully!',
                'post' => $post
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    public function show(string $post)
    {
        return new PostResource(Post::findOrFail($post));
    }

    public function update(StorePostRequest $request, Post $post)
    {
        $post->update($request->validated());

        return new PostResource($post);
    }

    public function destroy(string $post)
    {
        Post::findOrFail($post)->delete();
    }
}
