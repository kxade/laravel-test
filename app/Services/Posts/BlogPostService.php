<?php

namespace App\Services\Posts;

use App\Contracts\Posts\BlogPostInterface;
use App\Models\Post;
use App\Http\Requests\App\FilterPostsRequest;
use App\DTO\FilterPostsDTO;
use Carbon\Carbon;

class BlogPostService implements BlogPostInterface
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

    public function showPost(string $post_id)
    {
        return cache()->remember(
            key: "posts.{$post_id}", 
            ttl: now()->addHour(), 
            callback: function() use ($post_id) {
                return Post::query()->findOrFail($post_id);
            });
    }
}
