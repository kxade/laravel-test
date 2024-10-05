<?php

namespace App\Services\Posts;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\DataTransferObjects\PostDTO;

class PostService
{
    public function store(PostDTO $dto): Post
    {
        $user = Auth::user();
        if (!$user) {
            throw new \Exception('Unauthenticated');
        }

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

    public function update(PostDto $dto, Post $post): Post
    {
        $user = Auth::user();
        if (!$user) {
            throw new \Exception('Unauthenticated');
        }

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
}