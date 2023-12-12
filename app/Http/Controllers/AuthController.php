<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Responses\FailAuthResponse;
use App\Http\Responses\SuccessResponse;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Метод отвечает за регистрацию пользователя
     *
     * @param UserRequest $request
     * @return SuccessResponse
     */
    public function register(UserRequest $request): SuccessResponse
    {
        $data = $request->validated();

        $user = User::create($data);
        $token = Auth::attempt($request->only('name', 'email', 'password'));

        return new SuccessResponse([
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * Метод отвечает за авторизацию пользователя
     *
     * @param LoginRequest $request
     * @return SuccessResponse|FailAuthResponse
     */
    public function login(LoginRequest $request): SuccessResponse|FailAuthResponse
    {
        $request->validated();
        $credentials = $request->only('email', 'password');

        $token = Auth::guard('api')->attempt($credentials);
        if (!$token) {
            return new FailAuthResponse(trans('auth.failed'), Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::guard('api')->user();

        return new SuccessResponse([
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * Метод отвечает за выход пользователя из закрытой части приложения
     *
     * @return SuccessResponse
     */
    public function logout(): SuccessResponse
    {
        Auth::guard('api')->logout();
        return new SuccessResponse([
            'message' => 'Вы успешно вышли с приложения',
        ]);
    }

    /**
     * Метод отвечает за обновление токена пользователя
     *
     * @return SuccessResponse
     */
    public function refresh(): SuccessResponse
    {
        return new SuccessResponse([
            'user' => Auth::guard('api')->user(),
            'newToken' => Auth::guard('api')->refresh()
        ]);
    }
}
