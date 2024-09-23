<?php

namespace App\Services\Posts;

use App\Contracts\Posts\PostsFilter;
use App\Models\Post;
use Carbon\Carbon;

class BlogPostsFilter implements PostsFilter
{
    public function getPosts(array $validated): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Post::query();

        if ($fromDate = $validated['from_date'] ?? null) {
            $query->where('published_at', '>=', new Carbon($fromDate));
        }

        if ($toDate = $validated['to_date'] ?? null) {
            $query->where('published_at', '<=', new Carbon($toDate));
        }

        if ($search = $validated['search'] ?? null) {
            $query->where('title', 'ilike', "%{$search}%")
                ->orWhere('content', 'ilike', "%{$search}%");
        }

        if ($tag = $validated['tag'] ?? null) {
            $query->whereJsonContains('tags', $tag);
        }

        return $query->where('published', true)
            ->whereNotNull('published_at')
            ->orderBy('id', 'asc')
            ->paginate(12, ['id', 'title', 'published_at']);
    }
}
