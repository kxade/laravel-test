<?php

namespace App\Services\Posts;

use App\Contracts\Posts\UserPostInterface;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\DataTransferObjects\PostDTO;
use Illuminate\Support\Facades\Gate;


class PostService implements UserPostInterface
{
    public function getPosts()
    {
        return Auth::user()->posts()->latest()->paginate(6);
    }

    public function showPost(string $post_id)
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

    public function update(PostDto $dto, Post $post): Post
    {
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

    public function delete(Post $post)
    {
        Gate::authorize('modify', $post);

        dd($post->delete());
    }
}