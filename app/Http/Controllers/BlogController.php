<?php

namespace App\Http\Controllers;

use App\Contracts\Posts\BlogPostInterface;
use App\Http\Requests\App\FilterPostsRequest;
use App\DataTransferObjects\FilterPostsDTO;

class BlogController extends Controller
{
    protected $postService;

    public function __construct(BlogPostInterface $postService)
    {
        $this->postService = $postService;
    }

    public function index(FilterPostsRequest $request)
    {
        $posts = $this->postService->getPosts(
            FilterPostsDTO::fromAppRequest($request)
        );

        return view('blog.index', compact('posts'));
    }


    public function show(string $post_id) 
    {
        $post = $this->postService->showPost($post_id);

        if (is_Null($post)) {
            abort(404);
        } 
        return view('blog.show', compact('post'));
    }
}