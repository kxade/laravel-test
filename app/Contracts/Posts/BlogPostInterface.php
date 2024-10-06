<?php

namespace App\Contracts\Posts;

use App\Http\Requests\App\FilterPostsRequest;
use App\DataTransferObjects\FilterPostsDTO;

interface BlogPostInterface
{
    public function getPosts(FilterPostsDTO $dto);

    public function showPost(string $post_id);
}