<?php

namespace App\Contracts\Posts;

use App\Http\Requests\App\FilterPostsRequest;

interface BlogPostInterface
{
    public function getPosts(FilterPostsRequest $request);

    public function showPost(string $post_id);
}