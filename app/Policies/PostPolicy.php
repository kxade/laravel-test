<?php

namespace App\Policies;

use App\Models\{Post, User};

class PostPolicy
{
    public function modify(User $user, Post $post,): bool
    {
        return $user->id === $post->user_id;
    }
}
