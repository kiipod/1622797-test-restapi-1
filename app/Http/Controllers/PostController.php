<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Responses\NotFoundResponse;
use App\Http\Responses\SuccessResponse;
use App\Models\Post;
use App\Repositories\PostRepository\PostRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Throwable;

class PostController extends Controller
{
    public function __construct(private readonly PostRepository $postRepository)
    {
        $this->middleware('auth:api', ['except' => 'show']);
    }

    /**
     * Метод отвечает за показ конкретной новости
     *
     * @param int $postId
     * @return SuccessResponse|NotFoundResponse
     */
    public function show(int $postId): SuccessResponse|NotFoundResponse
    {
        $post = $this->postRepository->getPostById($postId);
        if (!$postId) {
            return new NotFoundResponse();
        }

        return new SuccessResponse($post);
    }

    /**
     * Метод отвечает за создание новости
     *
     * @param PostRequest $request
     * @return SuccessResponse
     * @throws InternalErrorException
     * @throws Throwable
     */
    public function store(PostRequest $request): SuccessResponse
    {
        $params = $request->validated();
        $user = Auth::user();

        $newPost = $this->postRepository->addNewPost($params, $user->id);

        return new SuccessResponse($newPost);
    }

    /**
     * Метод отвечает за обновление новости
     *
     * @param PostRequest $request
     * @param int $postId
     * @return SuccessResponse|NotFoundResponse
     * @throws AuthorizationException
     */
    public function update(PostRequest $request, int $postId): SuccessResponse|NotFoundResponse
    {
        $currentPost = Post::find($postId);
        if (!$currentPost) {
            return new NotFoundResponse();
        }

        $params = $request->validated();

        $this->authorize('update', $currentPost);

        $updatedPost = $this->postRepository->updatePost($currentPost, $params);

        return new SuccessResponse($updatedPost);
    }

    /**
     * Метод отвечает за удаление новости
     *
     * @param int $postId
     * @return SuccessResponse|NotFoundResponse
     * @throws AuthorizationException
     */
    public function destroy(int $postId): SuccessResponse|NotFoundResponse
    {
        $currentPost = Post::find($postId);
        if (!$currentPost) {
            return new NotFoundResponse();
        }

        $this->authorize('delete', $currentPost);

        $this->postRepository->deletePost($postId);

        return new SuccessResponse(['Новость успешно удалена']);
    }
}
