<?php

namespace App\Repositories\PostRepository\Interfaces;

use App\Http\Requests\PostRequest;
use App\Models\Post;

interface PostRepositories
{
    public function addNewPost(array $params, int $userId);
    public function updatePost(PostRequest $request, Post $post);
    public function deletePost(int $postId);
}
