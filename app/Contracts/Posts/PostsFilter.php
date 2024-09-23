<?php

namespace App\Contracts\Posts;

interface PostsFilter
{
    public function getPosts(array $validated): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
}