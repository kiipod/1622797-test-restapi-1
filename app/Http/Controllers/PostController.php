<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Responses\NotFoundResponse;
use App\Http\Responses\SuccessResponse;
use App\Models\Post;
use App\Repositories\PostRepository\PostRepository;
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

        return new SuccessResponse(['post' => $newPost]);
    }

    /**
     * Метод отвечает за обновление новости
     *
     * @param PostRequest $request
     * @return SuccessResponse
     * @throws Throwable
     */
    public function update(PostRequest $request): SuccessResponse
    {
        $currentPost = $request->findPost();

        $params = $request->validated();
        $postId = $currentPost->id;

        $updatedPost = $this->postRepository->updatePost($postId, $params);

        return new SuccessResponse($updatedPost);
    }

    /**
     * Метод отвечает за удаление новости
     *
     * @param int $postId
     * @return SuccessResponse|NotFoundResponse
     * @throws Throwable
     */
    public function destroy(int $postId): SuccessResponse|NotFoundResponse
    {
        $currentPost = Post::find($postId);
        if (!$currentPost) {
            return new NotFoundResponse();
        }

        $this->postRepository->deletePost($postId);

        return new SuccessResponse('Новость успешно удалена');
    }
}
