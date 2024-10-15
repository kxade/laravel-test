<?php

namespace App\Contracts\Posts;

use App\DTO\PostDTO;
use App\Models\Post;

interface UserPostInterface
{
    public function getPosts();

    public function showPost(string $post_id);

    public function store(PostDTO $dto);

    public function update(PostDTO $dto, Post $post);
}