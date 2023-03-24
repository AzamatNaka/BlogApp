<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function update(User $user, Post $post) //update
    {
        return ($user->id == $post->user_id);
    }

    public function delete(User $user, Post $post) // delete
    {
        return ($user->id == $post->user_id);
    }
}
