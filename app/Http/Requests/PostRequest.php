<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Проверка пользователя на право сделать запрос
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Правила валидации полей новости
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'min:50',
                'max:100'
            ],
            'fragment' => [
                'required',
                'string',
                'min:50',
                'max:255'
            ],
            'content' => [
                'required',
                'string',
                'min:100'
            ]
        ];
    }
}
