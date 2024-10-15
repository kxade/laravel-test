<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\Posts\PostService;
use App\Http\Requests\Api\PostRequest;
use App\DTO\PostDTO;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class PostController extends Controller implements HasMiddleware
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    public function index()
    {
        return PostResource::collection(Post::all()); 
    }

    public function store(PostRequest $request)
    {
        $post = $this->postService->store(
            PostDTO::fromApiRequest($request)
        );
        
        return response()->json([
            'message' => 'Post created successfully!',
            'post' => PostResource::make($post)
        ], 201);
    }

    public function show(string $post)
    {
        return new PostResource(Post::findOrFail($post));
    }

    public function update(PostRequest $request, Post $post)
    {
        $updatedPost = $this->postService->update(
            PostDTO::fromApiRequest($request),
            $post,
        );
        
        return response()->json([
            'message' => 'Post updated successfully!',
            'post' => PostResource::make($updatedPost)
        ], 200);
    }

    public function destroy(Post $post)
    {
        $this->postService->delete($post);

        return response()->json(['message' => 'Post deleted successfully!'], 201);
    }
}
