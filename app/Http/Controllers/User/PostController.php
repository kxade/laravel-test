<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Contracts\Posts\UserPostInterface;
use App\Http\Requests\Posts\PostRequest;
use App\Http\Requests\Posts\FilterPostsRequest;
use App\DTO\PostDTO;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function __construct(private UserPostInterface $postService)
    {
    }

    public function index() 
    {
        $posts = $this->postService->getUserPosts();

        return view('user.posts.index', compact('posts'));
    }

    public function create() 
    {
        return view('user.posts.create');
    }

    public function store(PostRequest $request)
    {
        $post = $this->postService->store(
            PostDTO::fromAppRequest($request)
        );
        
        session()->flash('success', 'Post created successfully!');        
        return redirect()->route('user.posts.show', $post);

    }

    public function show(int $post_id) 
    {
        $post = $this->postService->showPost($post_id);

        return view('user.posts.show', compact('post'));
    }

    public function edit(Post $post) 
    {
        // Authorizing the action
        Gate::authorize('modify', $post);
        
        return view('user.posts.edit', compact('post'));
    }

    public function update(PostRequest $request, int $post_id) 
    {
        $updatedPost = $this->postService->update(
            PostDTO::fromAppRequest($request),
            $post_id,
        );

        session()->flash('success', 'Post was changed successfully!');
        return redirect()->route('user.posts.show', $updatedPost);
    }

    public function destroy(int $post_id) 
    {
        $this->postService->delete($post_id);
        
        return back()->with('delete', 'Ваш пост был удален');
    }

    public function usernamePosts(User $username)
    {
        $userPosts = $this->postService->getPosts();

        return view('user.posts.username', [
            'posts' => $userPosts,
            'user' => $username
        ]);
    }

    public function getPublicPosts(FilterPostsRequest $request)
    {
        $posts = $this->postService->getPosts(
            PostDTO::filterPostsRequest($request)
        );

        return view('blog.index', compact('posts'));
    }


    public function showPublic(int $post_id) 
    {
        $post = $this->postService->showPost($post_id);
 
        return view('blog.show', compact('post'));
    }
}
