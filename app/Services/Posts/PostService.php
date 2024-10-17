<?php

namespace App\Services\Posts;

use App\Contracts\Posts\UserPostInterface;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\DTO\PostDTO;
use App\DTO\FilterPostsDTO;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;



class PostService implements UserPostInterface
{
    public function getPosts(FilterPostsDTO $dto): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Post::with('user');
        
        if ($fromDate = $dto->fromDate ?? null) {
            $query->where('published_at', '>=', new Carbon($fromDate));
        }
        
        if ($toDate = $dto->to_date ?? null) {
            $query->where('published_at', '<=', new Carbon($toDate));
        }
        
        if ($search = $dto->search ?? null) {
            $query->where('title', 'ilike', "%{$search}%")
            ->orWhere('content', 'ilike', "%{$search}%");
        }
        
        if ($tag = $dto->tag ?? null) {
            $query->whereJsonContains('tags', $tag);
        }
        
        return $query->where('published', true)
        ->whereNotNull('published_at')
        ->orderBy('id', 'asc')
        ->paginate(12, ['id', 'title', 'published_at', 'user_id']);
    }

    public function getUserPosts()
    {
        return Auth::user()->posts()->latest()->paginate(6);
    }
    
    public function showPost(int $post_id)
    {
        return Post::query()->findOrFail($post_id);
    }

    public function store(PostDTO $dto): Post
    {
        $user = Auth::user();

        $data = [
            'title' => $dto->title,
            'content' => $dto->content,
            'published_at' => $dto->published_at ?? now(),
            'published' => $dto->published ?? false,
            'category_id' => $dto->category_id,
            'source' => $dto->source,
        ];

        return $user->posts()->create($data);
    }

    public function update(PostDto $dto, int $post_id): Post
    {
        $post = Post::query()->findOrFail($post_id);

        Gate::authorize('modify', $post);

        $data = [
            'title' => $dto->title,
            'content' => $dto->content,
            'published_at' => $dto->published_at ?? now(),
            'published' => $dto->published ?? false,
            'category_id' => $dto->category_id,
            'source' => $dto->source,
        ];

        $post->update($data);

        return $post;
    }

    public function delete(int $post_id)
    {
        $post = Post::query()->findOrFail($post_id);
        
        Gate::authorize('modify', $post);

        $post->delete();
    }
}