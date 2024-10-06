<?php

namespace App\Contracts\Posts;

use App\DataTransferObjects\PostDTO;
use App\Models\Post;

interface UserPostInterface
{
    public function store(PostDTO $dto);

    public function update(PostDTO $dto, Post $post);
}