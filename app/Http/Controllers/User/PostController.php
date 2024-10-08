<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Contracts\Posts\UserPostInterface;
use App\Http\Requests\App\PostRequest;
use App\DataTransferObjects\PostDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    protected $postService;

    public function __construct(UserPostInterface $postService)
    {
        $this->postService = $postService;
    }

    public function index() 
    {
        $posts = $this->postService->getPosts();

        return view('user.posts.index', compact('posts'));
    }

    public function create() 
    {
        return view('user.posts.create');
    }

    public function store(PostRequest $request)
    {
        try {
            $post = $this->postService->store(
                PostDTO::fromAppRequest($request)
            );
            
            session()->flash('success', 'Post created successfully!');        
            return redirect()->route('user.posts.show', $post);
        
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(string $post_id) 
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

    public function update(PostRequest $request, Post $post) 
    {
        // Authorizing the action
        Gate::authorize('modify', $post);

        try {
            $updatedPost = $this->postService->update(
                PostDTO::fromAppRequest($request),
                $post,
            );

            session()->flash('success', 'Post was changed successfully!');
            return redirect()->route('user.posts.show', $updatedPost);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Post $post) 
    {
        // Authorizing the action
        Gate::authorize('modify', $post);
        
        $post->delete();
        
        return back()->with('delete', 'Ваш пост был удален');
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
