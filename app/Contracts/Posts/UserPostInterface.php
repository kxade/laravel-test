<?php

namespace App\Contracts\Posts;

use App\DTO\PostDTO;

interface UserPostInterface
{
    public function getAllPosts();

    public function getFilteredPosts(PostDTO $dto);

    public function getUserPosts();

    public function getUsernamePosts($user);

    public function showPost(int $post_id);

    public function showPublicPost(int $post_id);

    public function store(PostDTO $dto);

    public function update(PostDTO $dto, int $post_id);
}
