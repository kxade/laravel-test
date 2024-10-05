<?php

namespace App\Services\Posts;

use App\Models\Post;
use App\Enums\PostSource;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function store(array $data, PostSource $source): Post
    {
        $user = Auth::user();
        if (!$user) {
            throw new \Exception('Unauthenticated');
        }

        if (empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $data['source'] = $source;

        return $user->posts()->create($data);
    }

    public function update(array $data, Post $post): Post
    {
        $user = Auth::user();
        if (!$user) {
            throw new \Exception('Unauthenticated');
        }

        if (empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $post->update($data);

        return $post;
    }
}