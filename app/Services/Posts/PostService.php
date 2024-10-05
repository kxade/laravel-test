<?php

namespace App\Services\Posts;

use App\Models\Post;
use App\Enums\PostSource;
use Illuminate\Support\Facades\Auth;
use App\DataTransferObjects\PostDto;

class PostService
{
    public function store(
        string $title, 
        string $content, 
        ?string $published_at, 
        bool $published, 
        ?int $category_id, 
        PostSource $source): Post
    {
        $user = Auth::user();
        if (!$user) {
            throw new \Exception('Unauthenticated');
        }

        $data = [
            'title' => $title,
            'content' => $content,
            'published_at' => $published_at ?? now(),
            'published' => $published,
            'category_id' => $category_id,
            'source' => $source,
        ];

        return $user->posts()->create($data);
    }

    public function update(string $title, string $content, ?string $published_at, bool $published, ?int $category_id, PostSource $source, Post $post): Post
    {
        $user = Auth::user();
        if (!$user) {
            throw new \Exception('Unauthenticated');
        }

        $data = [
            'title' => $title,
            'content' => $content,
            'published_at' => $published_at ?? now(),
            'published' => $published ?? false,
            'category_id' => $category_id,
            'source' => $source,
        ];

        $post->update($data);

        return $post;
    }
}