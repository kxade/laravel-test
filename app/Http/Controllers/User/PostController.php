<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Enums\PostSource;
use App\Services\Posts\PostService;
use Illuminate\Http\Request;
use App\Http\Requests\App\PostStoreRequest;
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

        $posts = Auth::user()->posts()->latest()->paginate(6);

        return view('user.posts.index', compact('posts'));
    }

    public function create() 
    {
        return view('user.posts.create');
    }

    public function store(PostStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $post = $this->postService->store($data, PostSource::App);
            session()->flash('success', 'Post created successfully!');        
            return redirect()->route('user.posts.show', $post);
        
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show(string $post) 
    {
        $post = Post::query()->findOrFail($post);

        return view('user.posts.show', compact('post'));
    }

    public function edit(Post $post) 
    {
        // Authorizing the action
        Gate::authorize('modify', $post);
        
        return view('user.posts.edit', compact('post'));
    }

    public function update(PostStoreRequest $request, Post $post) 
    {
        // Authorizing the action
        Gate::authorize('modify', $post);

        $data = $request->validated();

        try {        
            $this->postService->update($data, $post);
            session()->flash('success', 'Post was changed successfully!');
            return redirect()->route('user.posts.show', $post);
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
