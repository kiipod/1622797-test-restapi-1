<?php

namespace App\Repositories\PostRepository;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Repositories\PostRepository\Interfaces\PostRepositories;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class PostRepository implements PostRepositories
{
    /**
     * Метод получает всю информацию о новости по id
     *
     * @param int $postId
     * @return Model|null
     */
    public function getPostById(int $postId): ?Model
    {
        return Post::find($postId);
    }

    /**
     * Метод отвечает за добавление новой новости
     *
     * @param array $params
     * @param int $userId
     * @return Post
     * @throws InternalErrorException
     */
    public function addNewPost(array $params, int $userId): Post
    {
        $post = new Post();

        $post->title = $params['title'];
        $post->fragment = $params['fragment'];
        $post->user_id = $userId;
        $post->content = $params['content'];

        if (!$post->save()) {
            throw new InternalErrorException('Не удалось сохранить новость', 500);
        }

        return $post;
    }

    /**
     * Метод отвечает за обновление новости
     *
     * @param array $params
     * @param int $postId
     * @return Post
     */
    public function updatePost(array $params, int $postId): Post
    {
        $post = Post::find($postId);

        $post->title = $params['title'];
        $post->fragment = $params['fragment'];
        $post->content = $params['content'];

        $post->save();

        return $post;
    }

    /**
     * Метод отвечает за удаление новости
     *
     * @param int $postId
     * @return void
     */
    public function deletePost(int $postId): void
    {
        $post = Post::whereId($postId)->firstOrFail();

        $post->delete();
    }
}
